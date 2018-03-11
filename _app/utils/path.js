
const path = require('path');

/**
 * Return the filename of a given filepath
 * @param  {string} filepath Filepath of the target file or directory
 * @return {string}          the name of the file
 */
path.getFilename = function(filepath) {
    let filename = this.basename(filepath, this.extname(filepath));

    console.log(filename);

    return filename;
}

module.exports = path;
