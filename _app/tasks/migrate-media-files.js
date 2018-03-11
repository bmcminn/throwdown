const Config = require('../config.js');

/**
 * [migrateMediaFiles description]
 * @param  {[type]} filepath [description]
 * @return {[type]}          [description]
 */
module.exports = function(filepath) {
    // TODO: create a task file for migrating all assets if they don't already exist in the destination directory

    let files = [];

    if (!filepath) {
    }

    let exts = defaults.mediaFiles;

    let extTest = new RegExp('.' + exts.join('|') + '$');

    if (!extTest.test(filepath)) {
        return;
    }

    console.log('migrating', filepath);

    // let targetPath = filepath.substr(Config.contentDir);
};
