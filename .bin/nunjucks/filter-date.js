/**
 * { item_description }
 *
 */

var filterDate = function filterDate(nunjucks) {
    'use strict';

    let moment = require('moment-timezone');

    return function(date, format, model) {


        return moment(date).tz(model.site.timezone).format(format);

        // return new nunjucks.runtime.SafeString(date.trim());
    };
};


module.exports = filterDate;
