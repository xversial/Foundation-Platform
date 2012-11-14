1.1.1 Changelog
----------

**General:**

upgraded bootstrap to 2.2.1.
consolidated url.js into helpers.js.
new global modal widget for delete confirmations.

**Pages**

added copy command for content & pages

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

1.0.2 Changelog
----------

**Installer:**

  * Fixed a few bugs with the installer that were causing errors.

**Users:**

  * Fixed a bug causing user permissions to not be updated from a validation error being thrown incorrectly.
  * Fixed a bug causing the suspension feature on login that prevented it from working.

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