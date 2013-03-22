### Platform - Changelog

----------

1.2.2 Changelog
----------

**General:**

  * Twitter Bootstrap updated to v2.3.1
  * Laravel updated to 3.2.13
  * Fixed installer problem that was generating a random table after a succesfull database connection.

**Theme Bundle:**

  * Less Compiler updated to v0.3.9

**Menu Extension**

  * Updated UI to be a bit more friendly.
  * Allowed default menus to be editable.

----------

1.2.1 Changelog
----------

**Menus:**

  * Fixed problem with pages as children in the navbar not having the correct uri.
  * Fixed frontend navbar widget depth issue not rendering the navbar correctly.

----------

1.2.0 Changelog
----------

**General:**

  * Fixed missing image declared on CSS on the default frontend theme.

**Extensions:**

  * Fixed invalid slug Exception

**Developers:**

  * Fixed extension creator stubs namespace problems.
  * Fixed problem with example widget name.

**Settings:**

  * Settings tabs now shows up even if the extension doesn't have entries on the database.

**Menus:**

  * Fixed problem when adding new children to menus not being saved correctly.
  * Updated how new menu items url slugs are saved.
  * Added native support to default frontend theme for dropdown menus.
  * Added restrict by group select for menu items.

**Media:**

  * Extension is now a core extension.
  * Fixed Blade @media extension call's not working properly

**Social:**

  * Extension is now a core extension.

**CMS**

  * Added feature to pages to allow for file driven pages.
  * Added feature to set group permissions for a given page.
  * Redactor WYSIWYG editor now standard.

----------

1.1.3 Changelog
----------

**General:**

  * Some files cleanup.
  * Added the Laravel dragon to the paths.php file.

**Menus:**

  * Fixed page menus not being marked as active on the UI.
  * Navigation widget cleanup.

**Users:**

  * Fixed missing language line for the register page.

**Developers:**

  * Fixed extension creator zip file not having the proper directory structure.
  * Fixed the missing javascript file on the extension creator page.
  * Updated some stubs.

----------

1.1.2 Changelog
----------

**General:**

  * Application key reset.
  * Various bug fixes across a few extensions.

**Extension Manager:**

  * Fixed issue with routes and extending frontend controllers.

**Developer Tools:**

  * Fixed the zip files being corrupted on windows.
  * Fixed missing comma in stubs.
  * New tool: Theme Creator.

**Menus:**

  * Fixed menu delete and lang call spelling error.

**Filesystem:**

  * Fixed namespace issues on PHP 5.3.2

----------

1.1.1 Changelog
----------

**General:**

  * Updated to latest Laravel Version 3.2.12
  * upgraded bootstrap to 2.2.1.
  * consolidated url.js into helpers.js.
  * new global modal widget for delete confirmations on tables.

**Pages**

  * Added enable/disable options for content.
  * Added copy functionality for pages and content.
  * Added enable/disable information to tables on index pages.

**Settings:**

  * Fixed an bug on language files with permissions.

**Extensions Manager:**

  * Fixed bug that it was not showing the correct version if an extension was not installed or had an update available and updated the index view.

**Localisation:**

  * Fixed bug when adding new currencies.

----------

1.1.0 Changelog
----------

**General:**

  * All 'bundle::' type calls have been changed to '{vendor}/bundle::' for controllers, settings, permissions, language, config, views, widgets and assets.
  * Moved the Platform::is_installed() from application/start.php to application/platform/platform.php
  * Cleaned a bit the application/platform/platform.php
  * Extended Laravel URL and Redirect core classes.
  * HTML comments are now compiled to PHP comments (in Blade templates).
  * Added method to return the current Platform version.
  * Added in new Filesystem Bundle to allow for FTP usage to get around apache user permission issues if desired.

**Installer:**

  * Fixed installer issues on some MySQL versions.
  * Added a new dependencies manager for the installer.
  * Added in optional FTP fields for the new filesystem bundle.

**Extensions Manager:**

  * Refactored the extensions manager. Extensions are now much more modular and easily extendable/overridable.

**Pages**

  * Pages has been completely refactored to be a basic dynamic CMS system with content and page sections.

**Settings:**

  * Bug fixes.
  * Settings are now modular.
  * Added in filesystem message configurations to the general settings admin form.

**Themes:**

  * Theme directory structure has been modified in the extension folder
  * New default themes HTML5boilerplate
  * Upgraded Twitter Bootstrap 2.1.*
  * Fixed integration of Font Awesome with Twitter Bootsrap

**Localisation:**

  * New core extension to manage system languages, countries and currencies.

----------

1.0.2 Changelog
----------

**Installer:**

  * Fixed a few bugs with the installer that were causing errors.

**Users:**

  * Fixed a bug causing user permissions to not be updated from a validation error being thrown incorrectly.
  * Fixed a bug causing the suspension feature on login that prevented it from working.

----------

1.0.1 Changelog
----------

**General:**

  * README Updates
  * Adding in CHANGELOG.MD

**Installer:**

  * Fixed a language file inconsistancy

**Menus:**

  * Adding nullable to the uri column in menus to fix an issue some people are having with installation.

**Users:**

  * Fixing API setting call issues in the users extension preventing emails from being sent

**Settings:**

  * Adding HTML::entities processing to settings to fix a minor security issue.
