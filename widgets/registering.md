### Registering Widgets

You can register your widgets anywhere in your application with the `Widget::map` function. Let's register our twitter feed widget.

    Widget::map('twitterfeed', 'App\Widgets\TwitterFeed@show');
