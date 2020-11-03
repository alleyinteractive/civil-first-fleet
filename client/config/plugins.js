/* eslint-disable import/no-extraneous-dependencies */
const StylelintPlugin = require('stylelint-webpack-plugin'); 
const webpack = require('webpack');
const fs = require("fs");
const path = require('path');
const paths = require('./paths');
const stylelintignore =
  fs.existsSync( path.join(paths.repoRoot, '.stylelintignore') )
    ?  path.join(paths.repoRoot, '.stylelintignore')
    : ''
  ;
const stylelintrc =
  fs.existsSync( path.join(paths.repoRoot, '.stylelintrc') )
    ?  path.join(paths.repoRoot, '.stylelintrc')
    : ''
  ;

// Plugins used in all webpack configs
const defaultPlugins = [
  ...(stylelintrc ? 
    [ new StylelintPlugin({
      configFile: stylelintrc,
      context: paths.themeRoot,
      ignorePath: stylelintignore
    })] : []
  ),
  new webpack.optimize.ModuleConcatenationPlugin(),
  new webpack.NamedModulesPlugin(),
];

// Plugins used only for `start` and `build` webpack configs
const buildPlugins = defaultPlugins.concat([
  new webpack.NoEmitOnErrorsPlugin(),
  new webpack.ProvidePlugin({
    $: 'jquery',
    jQuery: 'jquery',
  }),
]);

module.exports = {
  defaultPlugins,
  buildPlugins,
};
