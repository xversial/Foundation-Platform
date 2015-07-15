### Create Themes

You can add different themes to Platform 4 to adjust the look and feel of your application. Themes are located in the `public/themes` directory. Platform 4 ships with 2 default themes: `frontend/default` and `admin/default`. These themes are namespaced in the same order as composer packages in order to prevent naming collisions.

You can add your own theme as long as it's namespaced in the following order: `area/my-own-theme`. The `area` being an area for your locations (for example: back-end, front-end, help center, etc...) and your theme name. Add a `theme.json` file with all the info for your theme. A basic theme.json file should look like this:

    {
        "name": "Default Frontend Theme",
        "slug": "frontend::default",
        "description": "The default theme.",
        "author": "Cartalyst LLC",
        "version": "2.0"
    }

After creating your theme, you can simply go into the Platform 4 settings and select it as the default theme. You can now also create extension assets specifically for your theme.

> Please note that the slug you're adding in the `theme.json` file needs to be exactly the same as the theme's namespaced folder names.
