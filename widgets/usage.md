### Using Widgets

You can use widgets by using the `Widget` alias and the `make` function.

    echo Widget::make('twitterfeed', $parameters);

Or use the provided blade shortcut.

    @widget('twitterfeed', $parameters)
