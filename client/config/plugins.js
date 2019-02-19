/* eslint-disable import/no-extraneous-dependencies */
const webpack = require('webpack');
const path = require('path');
const paths = require('./paths');

// Plugins used in all webpack configs
const defaultPlugins = [
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
