### Widgets

- [Introduction](#introduction)
- [Creating Widgets](#creating-widgets)
- [Using Widgets](#using-widgets)

<a name="introduction"></a>
#### Introduction

Extension Widgets are pieces of views which can be re-used throughout your Platform 2 application. An example could be a menu widget for your custom navigation extension or a Twitter feed widget for your Twitter extension.

<a name="creating-widgets"></a>
#### Creating Widgets

If you want to register a small widget but don't want to create a class for it you can do it directly in the `extensions.php` file. 

	'widgets' => array(
		'foo' => function ()
		{
			// return content.
		}
	),

If you'd like to create a separate class for the widget to have some extra functionality you can create a class in the `widgets` folder. By default, Platform 2 will register your widgets by using your class name as the widget key. You can override this by registering the widget in the `extensions.php` file.

	'widgets' => array(
		'foo' => 'My\Widget\Namespace\Foo@someMethod',
	),

<a name="using-widgets"></a>
#### Using Widgets

You can use widgets by using the `Widget` alias and the `make` function.

	echo Widget::make('widget_key', array $parameters);

Or use the provided blade shortcut.

	@widget('widget_key', array $parameters)
