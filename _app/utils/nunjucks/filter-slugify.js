/**
 * { item_description }
 * @sauce: https://perishablepress.com/best-method-for-email-obfuscation/
 */

var slugify = require('./helpers').slugify;

var filterSlugify = function filterSlugify(nunjucks) {

    'use strict';

    return function(content) {

        // slugify the content string
        content = slugify(content);

        // render an HTML link
        // content = `<a class="slugify pslugify">${content}</a>`

        return new nunjucks.runtime.SafeString(content.trim());
    };
};


module.exports = filterSlugify;
