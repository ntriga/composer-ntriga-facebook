# README #

## composer.json ##

### Edit composer.json ###

```json
{
	"repositories": [
		{
			"type": "git",
			"url": "https://dspventures@bitbucket.org/dspdevteam/composer-ntriga-whise.git"
		}
	]
}
```

### Require package ###

```
composer require ntriga/whise:dev-master
```

## PHP ##


### Get Whise instance ###

```php
use Ntriga\Whise;

require __DIR__ . '/../vendor/autoload.php';

$extra_options = [
	'groupID' => 'group/website',
	'endpoint' => 'endpoint'
];

$cb = new Whise('apikey', 'portal', $extra_options);
```

### Get hotels ###

```php
use Ntriga\Whise;

require __DIR__ . '/../vendor/autoload.php';

$cb = new Whise('apikey', 'portal', $extra_options);
$hotels = $cb->find();
```