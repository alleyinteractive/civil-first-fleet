const path = require('path');
const paths = require('./paths');
const filenames = require('./filenames');
const lintingPlugins = require('./postcssLinting');

const jsExclude = [
  /node_modules/,
  /\.min\.js$/,
];

const jsInclude = [
  paths.globalJs,
  paths.components,
  paths.entries,
  paths.admin,
];

module.exports.cssExclude = [
  paths.globalJs,
];

// Loaders used for processing CSS
module.exports.cssLoaders = [
  {
    loader: 'css-loader',
    options: {
      sourceMap: true,
      importLoaders: 1,
      minimize: {
        autoprefixer: false,
      },
    },
  },
  {
    loader: 'postcss-loader',
    options: {
      sourceMap: true,
      config: {
        path: path.join(paths.config, 'postcss.config.js'),
      },
    },
  },
];

// Loaders common to all webpack configs
module.exports.defaultLoaders = [
  {
    enforce: 'pre',
    test: /\.js$/,
    exclude: jsExclude,
    include: jsInclude,
    use: 'eslint-loader',
  },
  {
    enforce: 'pre',
    test: /\.s?css$/,
    loader: 'postcss-loader',
    options: {
      plugins: () => lintingPlugins,
    },
  },
  {
    test: /\.js$/,
    exclude: jsExclude,
    include: jsInclude,
    use: 'babel-loader',
  },
  {
    test: [
      /\.png$/,
      /\.jpg$/,
      /\.svg$/,
      /\.woff2?$/,
      /\.ttf$/,
    ],
    use: {
      loader: 'url-loader',
      options: {
        limit: 10000,
        name: 'media/[name].[ext]',
      },
    },
  },
  {
    test: [
      /\.eot$/,
      /\.min\.js$/,
    ],
    exclude: [
      /node_modules/,
    ],
    use: {
      loader: 'file-loader',
      options: {
        name: 'media/[name].[ext]',
      },
    },
  },
];
