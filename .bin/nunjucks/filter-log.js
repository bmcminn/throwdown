/**
 * { item_description }
 *
 */

var filterLog = function filterLog(nunjucks) {
    'use strict';

    JSON.log = require('json-stringify-safe');

    return function(content) {
        content = `<script>console.log(${JSON.log(content)})</script>`;

        return new nunjucks.runtime.SafeString(content.trim());
    };
};


module.exports = filterLog;
