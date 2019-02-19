const stylelint = require('stylelint');
const browserReporter = require('postcss-browser-reporter');
const reporter = require('postcss-reporter');
const stylelintConfig = require('./stylelint.config.js');

module.exports = [
  stylelint(stylelintConfig),
  browserReporter(),
  reporter(),
];
