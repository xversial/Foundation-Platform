## Widgets

Widgets are pieces of views which can be re-used throughout your Platform 2 application. An example could be a menu widget for your custom navigation or a Twitter feed widget. Widgets can both be created directly into your app in the `app/widgets` folder or through extensions.

### Creating Widgets

Widgets should best be created in the `app/widgets` folder. Widgets preferable are stand-alone classes which contain all of the functionality to build pieces of views or content.

For example, you may have a `TwitterFeed` class widget.

	<?php namespace App\Widgets;

	class TwitterFeed {

		public function show()
		{
			// custom list with recent twitter messages.
		}

	}

### Registering Widgets

You can register your widgets anywhere in your application with the `Widget::map` function. Let's register our twitter feed widget.

	Widget::map('twitterfeed', 'App\Widgets\TwitterFeed@show');

### Using Widgets

You can use widgets by using the `Widget` alias and the `make` function.

	echo Widget::make('twitterfeed', $parameters);

Or use the provided blade shortcut.

	@widget('twitterfeed', $parameters)
