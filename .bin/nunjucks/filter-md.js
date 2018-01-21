/**
 * { item_description }
 * @sauce: https://perishablepress.com/best-method-for-email-obfuscation/
 */

const md    = require('markdown-it')();
const prism = require('markdown-it-prism');

let opts = {

} ;

md.use(prism, opts);


var mdFilter = function mdFilter(nunjucks) {

    'use strict';

    return function(content) {

        // TODO: fix the lack of filtering for HTML comments in MD files
        content = content.replace(/<!--[\s\S]+-->/gi, '');

        content = md.render(content);

        // console.log(content);

        return new nunjucks.runtime.SafeString(content.trim());
    };
};


module.exports = mdFilter;
