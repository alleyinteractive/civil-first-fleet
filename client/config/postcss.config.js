/* eslint-disable import/no-extraneous-dependencies */
// Plugins
const calc = require('postcss-calc');
const modules = require('postcss-modules');
const cssImport = require('postcss-import');
const customProps = require('postcss-custom-properties');
const customMedia = require('postcss-custom-media');
const values = require('postcss-modules-values-replace');
const nested = require('postcss-nested');
const units = require('postcss-units');
const colorFunction = require('postcss-color-function');
const criticalCSS = require('postcss-critical-css');
const autoprefixer = require('autoprefixer');
const mixins = require('postcss-sassy-mixins');
const focus = require('postcss-focus');

// Other imports
const filenames = require('./filenames');
const paths = require('./paths');
const lintingPlugins = require('./postcssLinting');
const localClasses = require('../bin/localClasses');
const cssVars = require('./css');

// Flattens child objects into top-level object
function flatten(obj) {
  return Object.keys(obj)
    .reduce((acc, curr) => (
      Object.assign({}, acc, obj[curr])
    ), {});
}

// Config
module.exports = (ctx) => ({
  plugins: [
    cssImport({
      plugins: lintingPlugins,
      path: [
        paths.globalStyles,
      ],
    }), // Import files
    customProps({
      variables: flatten(cssVars),
      preserve: false,
    }),
    units(), // Compute rem() function
    customMedia({
      extensions: cssVars.breakpoints,
    }),
    values(), // Arbitrary values for both css and JS
    mixins(),
    nested(), // Allow nested syntax.
    calc({
      mediaQueries: true,
    }),
    colorFunction(),
    focus(),
    autoprefixer({
      flexbox: 'no-2009',
    }),
    modules({
      generateScopedName: filenames.localIdentTemplate,
      globalModulePaths: [/client\/src\/css/, /client\/src\/admin/],
      getJSON: localClasses,
    }),
    criticalCSS(),
  ],
});
