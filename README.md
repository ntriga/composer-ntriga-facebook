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

### Getting posts Facebook ###

```php
use Ntriga\Facebook;

require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

$fb = new Facebook('app_id', 'app_secret');
if ($fb->checkPageKey()) {

	$feed = $fb->getFeed();

	foreach ($feed->data as $post) {
		//Saving post to DB
	}

	$instagram_feed = $fb->getInstagramFeed();

	foreach ($instagram_feed->data as $post) {
		//Saving post to DB
	}
}else{
	$fb->showLogin();
}
```