# Content

Most of the content you create in Platform 2 can be either content stored in the database or in static content files.

Content files are saved in the `public/content` folder.

After creating a content file you can create a content entry for it in the Platform 2 back-end.

## Re-using Content {#re-using-content}

Content entries, either static or database driven can be used in views directly by including them with their slug throught the `@content('content-entry-slug')` method. This method is an extension to the blade templating language specially made to work with Platform 2.

For example, if you have a view called `welcome.blade.php` for your homepage text and a markdown content file called `intro.md` which contains an intro text for your application, you can import that intro text into your view with the `@content()` blade structure.

	// welcome.blade.php
	<h1>My Platform 2 Website</h1>

	@content('intro')
