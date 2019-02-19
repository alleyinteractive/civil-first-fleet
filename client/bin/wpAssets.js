/* eslint-disable import/no-extraneous-dependencies */
const path = require('path');
const hasInvalidCharacters = require('./hasInvalidCharacters');

/**
 * Collect all assets for a specific entry point into an object.
 *
 * @param {array} assetList - array of relative asset paths for a specific entry point.
 */
const getAssets = (assetList) => assetList.reduce((assetAcc, outputPath) => {
  const fileInfo = path.parse(outputPath);
  const ext = fileInfo.ext.replace('.', '');

  // Validate key and value
  if (hasInvalidCharacters(ext) || hasInvalidCharacters(outputPath)) {
    return assetAcc;
  }

  if ('map' !== ext) {
    return Object.assign({}, assetAcc, { [ext]: outputPath });
  }

  return assetAcc;
}, {});

/**
 * Build JSON object containing a map of asset names to the output filename of that asset (including hash).
 * Assets are organized by entry point.
 *
 * @param {string} filename - optional filename override for this build.
 * @return {string} JSON object containg asset name => filename mapping.
 */
module.exports = (stats) => {
  const assets = stats.assetsByChunkName;

  // Loop through entries
  const entryMap = Object.keys(assets).reduce((entryAcc, entryName) => {
    // Validate entry name
    if (hasInvalidCharacters(entryName)) {
      return entryAcc;
    }

    // Make sure it's an array
    const assetList = [].concat(assets[entryName]);

    // Loop through assets
    return Object.assign(
      {},
      entryAcc,
      { [entryName]: getAssets(assetList) }
    );
  }, {});

  return JSON.stringify(entryMap);
};
