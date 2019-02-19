/* eslint-disable import/no-extraneous-dependencies */
// Webpack dependencies
const path = require('path');

// Config requires
const loaders = require('./loaders');
const { entry } = require('./entry');
const paths = require('./paths');
const { buildPlugins } = require('./plugins');
const resolve = require('./resolve');
const externals = require('./externals');
const filenames = require('./filenames');
const themename = require('./themename');
const optimization = require('./optimization');
const wpAssets = require('../bin/wpAssets');

// Plugins
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CleanPlugin = require('clean-webpack-plugin');
const StatsPlugin = require('webpack-stats-plugin').StatsWriterPlugin;

/**
 * Primary WebPack config.
 */
module.exports = {
  mode: 'production',

  entry,

  // Plugins array we configured above
  plugins: buildPlugins.concat([
    new CleanPlugin(['client/build/js', 'client/build/css'], {
      root: path.join(__dirname, '../../'),
    }),
    new ExtractTextPlugin(filenames.cssWithHash),
    new StatsPlugin({
      transform: wpAssets,
      fields: ['assetsByChunkName', 'hash'],
      filename: 'assetMap.json',
    }),
  ]),

  devtool: 'source-map',

  // Define module outputs
  output: {
    path: paths.buildRoot,
    publicPath: themename.themePublic,
    filename: filenames.fileWithHash,
    chunkFilename: filenames.chunkWithHash,
  },

  // Where webpack resolves modules
  resolve,

  // Enable require('jquery') where jquery is already a global
  externals,

  // Optimization options, such as chunk-splitting
  optimization,

  // Loaders
  module: {
    rules: [
      {
        test: /\.s?css$/,
        exclude: loaders.cssExclude,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          publicPath: paths.extractTextPublic,
          use: loaders.cssLoaders,
        }),
      },
    ].concat(loaders.defaultLoaders),
  },
};
