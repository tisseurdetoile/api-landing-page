<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// import composer's autoloader
require_once "../vendor/autoload.php";
$config = require_once "./config.inc.php";

/**
 * normalise les textes pour serialisation
 */
function normalize($text)
{
    $striped = trim(preg_replace('/\s\s+/', ' ', $text));
    $striped = strtr($striped, array_flip(get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES)));
    $striped = preg_replace('/\s+?(\S+)?$/', '', substr($striped, 0, 255));
    $striped = str_replace("'", "’", $striped);

    return $striped;
}

use Abraham\TwitterOAuth\TwitterOAuth;

// initialise leaf
$app = new Leaf\App;

$db = new SQLite3('landing_page.sqlite');

$app->config($config);

$app->get('/', function () use ($app) {
    $starttime = microtime(true);
    $sqliteVersion = $GLOBALS['db']->querySingle("SELECT SQLITE_VERSION()");

    $endtime = microtime(true);
    $timediff = ($endtime - $starttime) * 100;

    $status = ["status" => "OK", "sqlite" => $sqliteVersion, 'elapsed' => $timediff];
    $app->response->json($status);
});

$app->get('/posts', function () use ($app) {
    $starttime = microtime(true);
    $settingValue = $app->config('default_name');

    $sqlFindPosts = "SELECT JSON FROM main.DATAS
    WHERE SHAURL IN ( SELECT SHAURL FROM main.DATAS GROUP BY SHAURL ) ORDER BY TS DESC LIMIT 9";

    $posts = [];

    $findPosts = $GLOBALS['db']->query($sqlFindPosts);

    while ($row = $findPosts->fetchArray()) {
        array_push($posts, unserialize($row['JSON']));
    }

    $endtime = microtime(true);
    $timediff = ($endtime - $starttime) * 100;
    $res = ['elapsed' => $timediff, 'posts' => $posts];

    $app->response->json($res);
});

$app->get('/me', function () use ($app) {
    $meValue = $app->config('me');
    $app->response->json($meValue);
});

$app->get('/fetch', function () use ($app) {
    $starttime = microtime(true);
    $url = $app->config('rss');
    $maxElements = $app->config('maxelement');

    /** rss fetch */

    $rss = Feed::loadRss($url);

    $shaUrl = hash('sha256', $url);

    $rss_to_db = 0;
    $rss_error = 0;
    $found = 0;
    $ni = 0;

    foreach ($rss->item as $item) {
        if ($ni++ > $maxElements) {
            break;
        }

        $title = (string) $item->title;
        $link = (string) $item->link;
        $ts = (string) $item->timestamp;

        $srtHash = $title . $link;
        $hash = hash('sha256', $srtHash);

        $sqlFindOne = "SELECT * FROM( SELECT * FROM main.DATAS WHERE SHAURL = '$shaUrl' ) WHERE ITEM_SHA = '$hash'";

        $findOne = $GLOBALS['db']->querySingle($sqlFindOne);

        if (is_null($findOne)) {
            $striped = (string) $item->description;
            $description = normalize($striped);

            $title = strtr($title, array_flip(get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES)));
            $title = str_replace("'", "’", $title);

            $jItem = [
                'type' => 'rss',
                'title' => $title,
                'link' => $link,
                'timestamp' => $ts,
                'hash' => $hash,
                'description' => $description,
            ];

            $sjItem = SQLite3::escapeString(serialize($jItem));

            $sql = "INSERT INTO main.DATAS (TYPE, SHAURL, TITLE, LINK, TS ,JSON, ITEM_SHA) VALUES ('1','$shaUrl','$title','$link', '$ts', '$sjItem', '$hash')";

            if ($GLOBALS['db']->exec($sql)) {
                $rss_to_db++;
            } else {
                $rss_error
                ++;
            }

        } else {
            $found++;
        }
    }

    $rss_result = ['to_db' => $rss_to_db, 'db_error' => $rss_error, 'found' => $found];

    /** fin fetch rss */

    /** twitter fetch */

    $twitterConfig = $app->config('twitter');
    $twitter_to_db = 0;
    $twitter_error = 0;
    $twitter_fetch_error = 0;
    $twitter_found = 0;

    $twitter_result = [];

    $connection = new TwitterOAuth(
        $twitterConfig['apiKey'],
        $twitterConfig['apiSecretKey'],
        $twitterConfig['apiAccessToken'],
        $twitterConfig['apiAccessTokenSecret']);

    $statuses = $connection->get("statuses/user_timeline", ["count" => 25, "exclude_replies" => true]);

    $shaUrl = hash('sha256', $twitterConfig['name']);

    if (count($statuses) >= 1) {
        foreach ($statuses as $status_item) {
            $type = 'twitter';
            $title = normalize($status_item->text);
            $hash = (string) $status_item->id_str;
            $link = 'https://twitter.com/' . $status_item->user->id . '/status/' . $hash;
            $ts = strtotime($status_item->created_at);

            $sqlFindOne = "SELECT * FROM( SELECT * FROM main.DATAS WHERE SHAURL = '$shaUrl' ) WHERE ITEM_SHA = '$hash'";

            $findOne = $GLOBALS['db']->querySingle($sqlFindOne);

            if (is_null($findOne)) {
                $item = [];
                $item['type'] = $type;
                $item['title'] = $title;
                $item['timestamp'] = $ts;
                $item['link'] = $link;
                $item['user'] = $status_item->user->screen_name;
                $item['hash'] = $hash;
                $item['mention'] = $status_item->entities->user_mentions;

                $sjItem = SQLite3::escapeString(serialize($item));

                $sql = "INSERT INTO main.DATAS (TYPE, SHAURL, TITLE, LINK, TS ,JSON, ITEM_SHA) VALUES ('2','$shaUrl','$title','$link', '$ts', '$sjItem', '$hash')";

                if ($GLOBALS['db']->exec($sql)) {
                    $twitter_to_db++;
                } else {
                    $twitter_error++;
                }
            } else {
                $twitter_found++;
            }
        }
    } else {
        $twitter_fetch_error = 1;
    }

    $twitter_result = ['to_db' => $twitter_to_db, 'db_error' => $twitter_error, 'twitter_fetch_error' => $twitter_fetch_error, 'found' => $twitter_found];

    $endtime = microtime(true);
    $timediff = ($endtime - $starttime) * 100;

    $res = ['elapsed' => $timediff, 'rss' => $rss_result, 'twitter' => $twitter_result];

    $app->response->json($res);
});

$app->run();
