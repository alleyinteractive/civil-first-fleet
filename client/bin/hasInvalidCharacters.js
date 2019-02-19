const chalk = require('chalk');

/**
 * Used to make sure values in the asset JSON don't contain unexpected characters.
 * This should prevent any PHP slipping through, which would be dangerous since
 * we're `include`ing the resulting JSON file.
 *
 * NOTE: This is a negated character set because we're looking for
 *  anything that _isn't_ one of these characters.
 *
 * @param {string} value string to validate
 * @returns {bool} whether or not value contains unsafe characters
 */
const assetRegex = new RegExp('[^\\/\\.\\-_a-zA-Z0-9\\s]', 'g');
module.exports = hasInvalidCharacters = (value) => {
  if (assetRegex.test(value)) {
    console.log(
      chalk.red(`Attempted to write invalid value '${value}' to static asset JSON manifest. All JSON values must match ${assetRegex}`)
    );
    return true;
  }

  return false;
};
