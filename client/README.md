# Civil CMS Client-side Source Files

## Client Side Assets

This is the root directory of client-side source file assets. Webpack will compile and/or copy your files to `static` for use in the site. Three NPM scripts are available from the theme root:

* `npm run dev`: Run webpack-dev-server, enabling hot reloading.
* `npm run watch`: Watch for changes in the dependency tree and compile.
* `npm run build`: Compile, with minification and sourcemaps.
* `npm run build-admin`: Compile scripts and styles for use in wp-admin

**NOTE**: Each of the above npm scripts uses its own webpack config. More information on these configs is in the [config directory](client/config/README.md)

**IMPORTANT INFORMATION ABOUT HTTPS**: If you're having cross-domain issues with the `dev` or `watch` scripts, be sure to review the [documentation in the infosphere](https://infosphere.alley.ws/production/local-development/https-with-webpack.html).

## Running `watch` or `dev` for a specific entry point
In cases where the front end build for the site is very large or contains many location-specific entry points (like `home` and `article`) build speed can become an issue. In these cases, you may want to develop for only one or a few of those locations at a time. To do this, you can append one or more entry point keys to the run command:

`npm run dev -- --env.entry=article,landing` - this command will run the `dev` script for only the `article` and `landing` entry points, omitting all other entries and modules from the build.

## Hot reloading in the `dev` environment
Enabling hot reloading is a two-step process:

1. `npm run dev`
2. Load the page with the query param `?civil-first-fleet-dev=1` appended (for example, on the homepage, load `wp.dev?civil-first-fleet-dev=true`). Hot reloading will _only_ work on pages that have this query param added.

### Why are there two steps?
`npm run dev` bundles files much differently than either `npm run watch` or `npm run build`, and this theme loads different assets depending on whether you've toggled the `?civil-first-fleet-dev` query param. The `civil-first-fleet-dev` query param will tell wordpress to load all static assets in a single bundle from `localhost:8080` rather than broadway, allowing webpack to access and update the modules in the bundle on-the-fly.

### Adding a script to the hot-reloaded `dev.bundle.js`
1. All client-side assets will be added to the `dev` entry point used for hot reloading automatically. If you provide a specific entry to build with `--env.entry`, the `dev` entry point will contain only those assets.
2. You must add the following to the top of any script this should be hot-reloaded:
```js
if (module.hot) {
    module.hot.accept();
}
```
3. `module.hot.accept()` will cascade to all child modules, so you can add this to you entry script and it will accept HMR for all modules in that entry point.

### Configuring PostCSS
With the update to webpack 4, PostCSS can now be configured in `client/config/postcss.config.js`. The one exception is the autoprefixer browser settings, which can be configured in package.json. The reason for this is Babel uses the same browser settings for transpiling.

### Configuring Babel
Babel can now be configured in `.babelrc`, located in the root theme directory. All changes to the configuration should be made within the `env` preset, which will configure [babel-preset-env](https://github.com/babel/babel-preset-env). Note: If you intend to change any settings within the `targets.browsers` property, consider adding your changes to the `browserslist` property in package.json instead, as that setting will be used for autoprefixer as well.

