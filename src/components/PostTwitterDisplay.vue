<template>
  <div>
    <p class="excerpt">
      {{ post.title }}
      ... <a v-bind:href="post.link">[lire]</a>
    </p>
    <div class="post-list__meta">
      <TSDateDisplay v-bind:timestamp="post.timestamp" />
      &#8226;
      <span v-if="post.mention" class="post-meta__tags">
        via
        <span v-for="mention in post.mention" :key="mention.id">
          <a v-bind:href="'http://www.twitter.com/' + mention.screen_name">
            @{{ mention.name }}&nbsp;&nbsp;
          </a>
        </span>
      </span>
    </div>
    <hr class="post-list__divider" />
  </div>
</template>
<script>
import TSDateDisplay from './TSDateDisplay'

export default {
  name: 'PostTwitterDisplay',
  components: { TSDateDisplay },
  props: { post: Object },
}
</script>
