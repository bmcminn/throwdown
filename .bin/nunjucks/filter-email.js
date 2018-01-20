/**
 * { item_description }
 * @sauce: https://perishablepress.com/best-method-for-email-obfuscation/
 */

var obfuscate = require('./helper-obfuscate');

var obfuscateEmail = function obfuscateEmail(nunjucks) {

    'use strict';

    return function(content) {

        // obfuscate the content string
        content = obfuscate(content);

        // render an HTML link
        content = `<a class="obfuscate eobfuscate">${content}</a>`

        return new nunjucks.runtime.SafeString(content.trim());
    };
};


module.exports = obfuscateEmail;
