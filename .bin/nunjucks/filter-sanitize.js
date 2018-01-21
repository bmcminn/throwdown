/**
 * { item_description }
 *
 */

var filterSanitize = function filterSanitize(nunjucks) {

    'use strict';

    return function(content) {
        var sanitize = content
                .replace(/<!--[\s\S]+?-->/, '')     // remove HTML comments
                .replace(/markdown="1"/, '')        // remove markdown="1" directives
                ;

        return new nunjucks.runtime.SafeString(sanitize.trim());
    };
};


module.exports = filterSanitize;
