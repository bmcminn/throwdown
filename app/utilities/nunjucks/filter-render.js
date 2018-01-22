/**
 * Allows for Nunjucks markup within markdown contents to be rendered with the current model context
 * @sauce: https://perishablepress.com/best-method-for-email-obfuscation/
 */



var renderFilter = function renderFilter(nunjucks) {

    'use strict';

    return function(content, ctx) {

        content = nunjucks.renderString(content.trim(), ctx);

        return nunjucks.runtime.SafeString(content);
    };
};


module.exports = renderFilter;
