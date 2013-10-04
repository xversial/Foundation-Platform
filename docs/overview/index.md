## Introduction

- [Features](platform/overview#features)
- [Requirements](platform/overview#requirements)
- [License](platform/overview#license)

Cartalyst's Platform application provides a very flexible and extensible way of building your custom application. It gives you a basic installation to get you quick-started with content management, themeable views, application extensions and much more. Pretty much everything on Platform can be extended and overwritten so you can add your own functionality. Platform is not just another CMS, it's a starting point for you to build your application providing the tools you need to get the job done as easy as possible.

### Flexibility

---

The main goal of Platform was flexibility. Platform aims to be as unobtrusive
to your application as possible, while providing all the features to make it
awesome and **save you time**. The `app` folder is almost identical to a
stock-standard Laravel 4 `app` folder, with a few registered service
providers and preset configurations.

The end result? You can continue to make any application you would like without
having to conform to Platform "standards" or "practices".

Want to install Platform for an administration area but build a completely custom
website? Sure, just start working with `app/routes.php` as you normally would.
Utilize our API, data and extensions where you need, they won't get in your way.

### Extensibility

---

Platform was made to be even more extendable than Platform 1. A number of key files to get you off the ground with extending Platform are:

 - `app/hooks.php`
 - `app/functions.php`
 - `app/overrides.php`

These files provide a number of templates and boilerplate code for you to override extension classes, API routes, hook into system events and add custom logic.

### Features {#features}

---

- Authentication & Authorization
- Social Authentication (OAuth, OAuth 2)
- Twitter Bootstrap 2.3.1 Ready
- Frontend/Backend/Custom Themes
- User/Group management + permissions
- Content Management
- Menu manager
- Settings
- Themes manager
- Dashboard
- Extension manager
- Localisation
- Developer Tools (extension & theme creator)
- Powerful Extension System
- Widgets
- Plugins
- API

### Requirements {#requirements}

---

- PHP >= 5.3.7
- MCrypt PHP Extension

To use Cartalyst's Platform application you need to have a valid Cartalyst.com subscription. Click [here](platform/https://www.cartalyst.com/pricing) to obtain your subscription.

### License {#licence}

---

Cartalyst's Platform application is licensed under [the BSD 3-Clause license](platform/overview/license).
