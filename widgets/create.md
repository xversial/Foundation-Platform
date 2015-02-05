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
