/* eslint-disable import/no-extraneous-dependencies */
// Webpack dependencies
const webpack = require('webpack');

// Config requires
const entry = require('./entry');
const loaders = require('./loaders');
const paths = require('./paths');
const resolve = require('./resolve');
const externals = require('./externals');
const filenames = require('./filenames');
const themename = require('./themename');

// Plugins
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');

/**
 * Primary WebPack config.
 */
module.exports = {
  mode: 'production',

  entry: entry.admin,

  // Plugins array we configured above
  plugins: [
    new webpack.NoEmitOnErrorsPlugin(),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
    }),
    new ExtractTextPlugin(filenames.cssNoHash),
    new OptimizeCssAssetsPlugin({
      cssProcessorOptions: {
        map: {
          inline: false,
        },
      },
    }),
  ],

  devtool: 'source-map',

  // Define module outputs
  output: {
    path: paths.buildRoot,
    publicPath: themename.themePublic,
    filename: filenames.fileNoHash,
    chunkFilename: filenames.chunkNoHash,
  },

  // Where webpack resolves modules
  resolve,

  // Enable require('jquery') where jquery is already a global
  externals,

  // Loaders
  module: {
    rules: [
      {
        test: /\.s?css$/,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          publicPath: paths.extractTextPublic,
          use: loaders.cssLoaders,
        }),
      },
    ].concat(loaders.defaultLoaders),
  },
};
