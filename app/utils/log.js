const chalk = require('chalk');
chalk.stripAnsi = require('strip-ansi');
const path = require('path');

const fs = require('./fs.js');
const Config = require('../config.js');

let today = [
    new Date().getFullYear(),
    new Date().getMonth() + 1,
    new Date().getDate(),
];

const LOG_FILE = path.join(process.cwd(), 'app/logs', `${today.join('-')}.log`);

if (!fs.exists(LOG_FILE)) {
    fs.write(LOG_FILE, '');
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
        case 'warning':
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

    let dateTime = new Date().toISOString();
    let typeStr = type.toUpperCase();

    msg = [chalk[color](`[${dateTime}] [${typeStr}]`), `:: ${msg}`].join(' ');

    console.log(msg);

    fs.append(LOG_FILE, chalk.stripAnsi(msg));
};

// Export a singleton with only the methods we wish to expose
module.exports = {
    info: (msg) => Log.__log('info', msg),
    warn: (msg) => Log.__log('warning', msg),
    error: (msg) => Log.__log('error', msg),
    debug: (msg) => Log.__log('debug', msg),
    success: (msg) => Log.__log('success', msg),
};
