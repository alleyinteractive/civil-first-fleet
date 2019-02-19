# Civil CMS front-end build configuration files

This directory contains configurations for webpack and its constituent modules.

## Using This Directory

Each of the [`dev`](client/config/webpack.dev.config.js), [`watch`](client/config/webpack.watch.config.js), [`build`](client/config/webpack.build.config.js), and [`build-admin`](client/config/webpack.admin.config.js) npm scripts has its own separate webpack configuration. These configurations contain a lot of common elements, each of which is housed in its own JS module. These modules, generally speaking, are split up by concern (or roughly by webpack configuration property):

* `entry.js` - Config and functions for managing entry points.
* `externals.js` - Config for the `externals` config property.
* `filenames.js` - Various common filenames and filename templates used throughout the configs.
* `loaders.js` - Common webpack loader configs. 
* `paths.js` - Path definitions used to point to entry point files, output directories, etc.
* `plugins.js` - webpack plugins used across the configs. This contains a small set of default plugins used in all configs (`defaultPlugins`), and a larger set used only in `build` and `start` (`buildPlugins`).
* `resolve.js` - Common config for webpack's `resolve` property.
* `themename.js` - Logic for determining the name of the current WordPress theme for use in pointing webpack to the appropriate location for built files.

## Additional configurations

* `stylelint.config.js` - Config for CSS and SASS linting.
* `postcss.config.js` - Config for the `postcss-loader`. Any additional postcss plugins should be added to this file.