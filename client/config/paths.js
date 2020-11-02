const path = require('path');

module.exports = {
  themeRoot: path.join(__dirname, '../../'),
  globalJs: path.join(__dirname, '../src/js'),
  admin: path.join(__dirname, '../src/admin'),
  entries: path.join(__dirname, '../src/entries'),
  globalStyles: path.join(__dirname, '../src/css'),
  sourceRoot: path.join(__dirname, '../src'),
  buildRoot: path.join(__dirname, '../build'),
  repoRoot: path.join(__dirname, '../../../../'),
  components: path.join(__dirname, '../../components'),
  // This value should be a relative path from `client/build/css` to `client/build/media`
  // (or whatever directory is configured for url-loader in `./loaders.js`)
  extractTextPublic: '../',
  config: __dirname,
};
