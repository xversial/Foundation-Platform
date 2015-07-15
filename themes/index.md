## Themes

Platform 4 uses [Cartalyst's Themes 3 package](http://cartalyst.com/manual/themes) for managing themes. Because of re-using it, Platform 4 comes with all of the goodness of Themes 3 like asset queuing and compiling. In the documentation below you can find out how to create your own custom themes.

### Important Notes

- Default admin and frontend themes are UNTRACKED on git since they're installed using composer. Always, create a new theme and override any views or assets as needed and set your new theme active.
- Default themes are installed through composer, therefore, would get overwritten as soon as an update is found by composer.
- Always modify your extensions' views inside the extension (workbench) and do not modify the published views located under `public/themes/:area/:name/extensions/*` Published assets are not tracked on git and will be overwritten by the theme publisher as soon as you run its command or automatically run after composer install/update.
