/**
 * { item_description }
 *
 */

var filterSpaceless = function filterSpaceless(nunjucks) {

    'use strict';

    return function(content) {
        let spaceless = content;

        if (process.env.NODE_ENV === 'production') {
            spaceless = content
                .replace(/$\s+/, '')
                .replace(/\s+^/, '')
                .replace(/>\s+</gi, '><')
                .replace(/>\s{2,}(\S)/gi, '> $1')       // experimental: remove space after tag before text
                .replace(/(\S[^:])\s{2,}</gi, '$1 <')   // experimental: remove space after text before tag
                .replace(/,\s{2,}/g, ', ')              // experimental: remove excess space after comma
                .replace(/\.\s{2,}/g, '. ')             // experimental: remove excess space after spaces
                .replace(/^\s+|\s+$/g, '')              // remove space before and after the filtered content
                ;
        }

        return new nunjucks.runtime.SafeString(spaceless.trim());
    };
};


module.exports = filterSpaceless;
