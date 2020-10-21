/* eslint-disable import/no-extraneous-dependencies */
// Webpack dependencies
const webpack = require('webpack');
const path = require('path');
const fs = require('fs');
const os = require('os');

// Config requires
const paths = require('./paths');
const { defaultPlugins } = require('./plugins');
const { getHotEntry } = require('./entry');
const loaders = require('./loaders');
const resolve = require('./resolve');
const externals = require('./externals');
const filenames = require('./filenames');

/**
 * Primary WebPack config.
 */
module.exports = (env) => {
  const certPath = env.certPath || path.join(
    os.homedir(),
    'broadway/config/nginx-config'
  );

  return {
    mode: 'development',

    entry: {
      dev: getHotEntry(env),
    },

    // Plugins array we configured above
    plugins: defaultPlugins.concat([
      new webpack.HotModuleReplacementPlugin(),
    ]),

    devtool: 'cheap-module-eval-source-map',

    // Define module outputs
    output: {
      path: paths.buildRoot,
      publicPath: '//localhost:8080/client/build',
      filename: filenames.fileNoHash,
      chunkFilename: filenames.chunkNoHash,
    },

    // Where webpack resolves modules
    resolve,

    externals,

    // Loaders
    module: {
      rules: [
        {
          test: /\.s?css$/,
          exclude: loaders.cssExclude,
          use: ['style-loader'].concat(loaders.cssLoaders),
        },
      ].concat(loaders.defaultLoaders),
    },

    // Dev server setup. This is present in config as it is both easier to read
    // and allows us to configure headers
    devServer: {
      hot: true,
      quiet: false,
      noInfo: false,
      contentBase: '/client/build',
      headers: { 'Access-Control-Allow-Origin': '*' },
      stats: { colors: true },
      https: env.http ? false : {
        cert: fs.readFileSync(
          path.join(certPath, 'server.crt'),
          'utf8'
        ),
        key: fs.readFileSync(
          path.join(certPath, 'server.key'),
          'utf8'
        ),
      },
    },
  };
};
