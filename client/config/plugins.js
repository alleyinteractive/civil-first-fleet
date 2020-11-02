/* eslint-disable import/no-extraneous-dependencies */
const StylelintPlugin = require('stylelint-webpack-plugin'); 
const webpack = require('webpack');
const path = require('path');
const paths = require('./paths');

// Plugins used in all webpack configs
const defaultPlugins = [
  new StylelintPlugin({
    configFile: path.join(paths.repoRoot, '.stylelintrc'),
    context: paths.themeRoot,
    ignorePath: path.join(paths.repoRoot, '.stylelintignore')
  }),
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
