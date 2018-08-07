# README #

## composer.json ##

### Edit composer.json ###

```json
{
	"repositories": [
		{
			"type": "git",
			"url": "https://dspventures@bitbucket.org/dspdevteam/composer-ntriga-instagram.git"
		}
	]
}
```

### Require package ###

```
composer require ntriga/instagram:dev-master
```

## PHP ##

### Show login ###

```php
use Ntriga\Instagram;

require __DIR__ . '/../vendor/autoload.php';

$insta = new Instagram();
$insta->showLogin();
```