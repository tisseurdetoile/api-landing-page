# API-LANDING-PAGE

API-LANDING-PAGE is a PHP API for dealing with vue-landing-page

## Installation

Use composer [composer](https://getcomposer.org/) to build API-LANDING-PAGE

```bash
docker run --rm -v $(pwd):/app composer:latest update
```

## Usage

rename config.inc.php.changeme to config.inc.php
change your setup information

```bash
docker run --rm -p 8000:80 -v $(pwd):/var/www/html phpstorm/php-apache:7.4-xdebug2.9 /bin/bash -c 'a2enmod rewrite; apache2-foreground'
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
