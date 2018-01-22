/**
 * { item_description }
 *
 */

var filterSanitize = function filterSanitize(nunjucks) {
    'use strict';

    return function(content) {
        var d = new Date();

        process.env.HASH_ID = process.env.HASH_ID || d.getTime();

        if (global.DEPLOY) {
            return `${content}?cb=${process.env.HASH_ID}`;
        } else {
            return content;
        }
    }
};


module.exports = filterSanitize;
