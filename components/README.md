# Civil CMS Components
This theme uses a setup to separate assets into components that are more encapsulated than they would be in a normal WordPress setup. Each directory in `/components` contains a component for use anywhere on the site. This readme contains some guidelines for creating, modifying, and including components.

## Anatomy of a component
Every component is composed of several files, some of which are required:
* Directory - each component's containing directory should be named for the component. This name should be hyphenated if separate words are required. Make this name short but descriptive of what the component is used for, as it will be included in several other locations and filenames.
* Component class - Each component has a controller class. This class should be named `class-[component-name].php` and may contain a number of features for the component. @TODO James should populate this area
* Parent JS file - This file should always be located at `[component-directory]/index.js` and may contain two things:
    * Imports for that components associated CSS, JS class, and any other peripheral front-end assets.
    * A configuration object for that component's JS class. Documentation on this configuration and what it can/should contain can be found [here](https://github.com/alleyinteractive/js-component-framework). **NOTE** the `name` property of this configuration _must_ match the component directory name.
    * Limited logic for pulling in related classnames from the global `civilCMSClassnames` object.
* Template parts directory - At minimum, a single template containing markup and template logic for the component. This directory may contain other related templates as well.
* Assets directory - At minimum, this should contain a CSS file containing styles for the component. **NOTE** The name of this stylesheet _must_ match the component directory name. This directory may also contain any related front-end/static assets for the component (such as images).
    * More on writing CSS for this project can be found [here](../client/README.md).

## Including a component
@TODO James should populate this section.

## CSS Modules
This project uses CSS modules to namespace (or scope) component CSS classes to specific components. **NOTE** This does not apply to any CSS in `/client/src/css`, only CSS found in the `/components` directory. There are several points you should be aware of about this setup before beginning development:
* Classes should be written a bit differently with CSS Modules than they normally are. Because CSS Modules is namespacing our classes for us (kind of like automated BEM), we can _and should_ write component classes, to a certain extent, with a consistent, repetitive naming convention. For example, every component will probably have a `.wrapper` class. In normal CSS, this would be dangerous as every class has a global scope. CSS Modules, however, will convert this class into something like `.site-header__wrapper___sjd78f`, preventing any clashing with the `.wrapper` class in other components.
* We have to assume the resulting, transformed class cannot be known to us ahead of time (mostly because it contains a random, 5 character base64 hash of the class). Because of this, we have to use a JSON manifest containing a mapping of untransformed classes to transformed classes, which might look something like: `{ "wrapper": "my-header__wrapper___3f8c2" }`. We've written a PHP class for handling the process of reading in this JSON file and making it accessible to component templates. The major functions you'll need to get classes into your markup can be found in `inc/stylesheets/stylesheets.php`. **NOTE** this automated process is the reason why your primary component CSS file _must_ have the same name as the component directory.
* We are using a PostCSS plugin to generate these JSON files. More information on that plugin and usage of CSS modules can be found [here](https://github.com/css-modules/postcss-modules).
