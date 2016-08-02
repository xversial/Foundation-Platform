#### Content

Most of the content you create in Platform 5 can be either content stored in the database or in static content files.

Content files are saved in the `public/themes/<theme-area>/<theme-name>/views/content` folder.

After creating a content file you can create a content entry for it in the Platform 5 back-end.

##### Re-using Content

Content entries, either static or database driven can be used in views directly by including them with their slug through the `@content('content-entry-slug')` method. This method is an extension to the blade templating language specially made to work with Platform 5.

For example, if you have a view called `welcome.blade.php` for your homepage text and a markdown content file called `intro.md` which contains an intro text for your application, you can import that intro text into your view with the `@content()` blade structure.

    // welcome.blade.php
    <h1>My Platform 5 Website</h1>

    @content('intro')
