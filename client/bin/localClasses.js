const path = require('path');
const fs = require('fs-extra');
const paths = require('../config/paths');
const hasInvalidCharacters = require('./hasInvalidCharacters');

/**
 * Generate JSON file containing localized classnames for a particular stylesheet.
 * For use in the getJSON option in postcss-modules
 *
 * @param {string} cssFileName Full filepath of CSS file currently being processed
 * @param {object} classnames Object ontaining mapping of localized classnames
 */
module.exports = function localClasses(cssFileName, manifest) {
  const cssFileInfo = path.parse(cssFileName);
  const classnames = Object.keys(manifest).reduce((acc, classname) => {
    if (
      ! hasInvalidCharacters(classname) &&
      ! hasInvalidCharacters(manifest[classname])
    ) {
      acc[classname] = manifest[classname];
    }

    return acc;
  }, {});

  addToGlobalManifest(cssFileInfo.name, classnames);
}

/**
 * Generate JSON file containing all localized classnames, keyed by filename
 *
 * @param {string} filename Filename of CSS file currently being processed
 * @param {object} manifest Object containing mapping of localized classnames
 */
function addToGlobalManifest(filename, manifest) {
  let globalManifest;

  try {
    globalManifest = JSON.parse(
      fs.readFileSync(
        path.join(paths.buildRoot, 'classnames.json'),
        'utf8'
      )
    );
  } catch(error) {
    globalManifest = {};
  }

  globalManifest[filename] = manifest;
  fs.outputFileSync(
    path.join(paths.buildRoot, 'classnames.json'),
    JSON.stringify(globalManifest)
  );
}
