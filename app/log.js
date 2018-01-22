const chalk = require('chalk');
const Path = require('path');
const FS = require('./fs.js');
const Config = require('../config.js');

let today = [
    new Date().getFullYear(),
    new Date().getMonth() + 1,
    new Date().getDate(),
];

const LOG_FILE = Path.join(Config.LOGS_DIR, `${today.join('-')}.log`);

if (!FS.exists(LOG_FILE)) {
    FS.write(LOG_FILE, '');
}

const Log = {};

/**
 * A generic logging function
 * @param  {string} type Type of message we wish to log
 * @param  {any}    msg  Data we wish to log; non-string data will be JSON encoded
 * @return {null}
 */
Log.__log = function(type, msg) {
    if (!typeof msg === 'string') {
        msg = JSON.stringify(msg);
    }

    switch (type) {
        case 'warn':
            color = 'yellow';
            break;
        case 'error':
            color = 'red';
            break;
        case 'debug':
            color = 'magenta';
            break;
        case 'success':
            color = 'green';
            break;
        default:
            color = 'blue';
            break;
    }

    console.log(
        chalk[color](`[${new Date().toISOString()}] [${type.toUpperCase()}]`) +
            ` :: ${msg}`
    );

    FS.append(
        LOG_FILE,
        `[${new Date().toISOString()}] [${type.toUpperCase()}] :: ${msg}`
    );
};

// Export a singleton with only the methods we wish to expose
module.exports = {
    info: (msg) => Log.__log('info', msg),
    warn: (msg) => Log.__log('warn', msg),
    error: (msg) => Log.__log('error', msg),
    debug: (msg) => Log.__log('debug', msg),
    success: (msg) => Log.__log('success', msg),
};
