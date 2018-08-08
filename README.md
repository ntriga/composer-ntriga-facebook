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

### Getting posts ###

```php
use Ntriga\Instagram;

require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

$insta = new Instagram();
if ($insta->checkPageKey()) {
	$posts = $insta->getPosts();

	foreach ($posts->data as $post) {
		//Saving post to DB
	}
}else{
	$insta->showLogin();
}
```