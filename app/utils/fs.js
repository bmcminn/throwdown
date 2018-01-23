const FS = require('grunt').file;

/**
 * Appends the specified string data to a file target of your choosing
 * @param  {string} filepath The target file to append to
 * @param  {string} data     The string data to append into target file
 * @param  {object} opts     (Optional) options for configuring how FS.write works
 * @return {string}          The modified string data from the file
 */
FS.append = (filepath, data, opts) => {
    opts = opts || {};
    opts = Object.assign(
        {
            encoding: 'utf8', // https://nodejs.org/docs/latest/api/buffer.html#buffer_buffers_and_character_encodings
        },
        opts
    );

    content = FS.read(filepath);
    content += '\n' + data;

    FS.write(filepath, content, opts);

    return content;
};

module.exports = FS;
