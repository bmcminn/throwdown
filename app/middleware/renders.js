const Path = require('path');
const _ = require('lodash');

const fs = require('../utils/fs.js');
const Log = require('../utils/log.js');
const Config = require('../config.js');

const renderPage = function(filepath) {
    Log.info(filepath);

    Log.success(`Rendered ${filepath}`);
};

module.exports = renderPage;
