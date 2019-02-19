const path = require('path');
const paths = require('./paths');

module.exports = {
  modules: [
    paths.themeRoot,
    'node_modules',
  ],
  extensions: ['.js', '.json', '.css'],
  alias: {
    entries: path.join(__dirname, '../src/entries'),
    admin: path.join(__dirname, '../src/admin'),
    images: path.join(__dirname, '../src/images'),
    components: path.join(__dirname, '../../components'),
    css: path.join(__dirname, '../src/css'),
    js: path.join(__dirname, '../src/js'),
    utils: path.join(__dirname, '../src/js/utils'),
    config: __dirname,
  },
};
