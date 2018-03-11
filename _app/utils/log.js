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
 * [__typeChecks description]
 * @param  {[type]} m [description]
 * @return {[type]}   [description]
 */
Log.__typeChecks = function(msg) {
    let type = (typeof msg).toLowerCase().trim();

    if (type === 'object') {
        Array.isArray(msg)
            ? (msg = chalk.yellowBright(JSON.stringify(msg)))
            : (msg = chalk.cyanBright(JSON.stringify(msg)));
    }

    if (type === 'boolean') {
        msg
            ? (msg = chalk.greenBright(`'${msg}'`))
            : (msg = chalk.redBright(`'${msg}'`));
    }

    if (type === 'number') {
        msg = chalk.magentaBright(`'${msg}'`);
    }

    return msg;
};

/**
 * A generic logging function
 * @param  {string} type Type of message we wish to log
 * @param  {any}    msg  Data we wish to log; non-string data will be JSON encoded
 * @return {null}
 */
Log.__log = function(type, color, msg) {
    let args = Array.prototype.slice.call(msg);

    msg = args.map(this.__typeChecks).join(' ');

    let dateTime = new Date().toISOString();
    let typeStr = type.toUpperCase();

    msg = [chalk[color](`[${dateTime}] [${typeStr}]`), `:: ${msg}`].join(' ');

    // this is our single source of truth
    console.log(msg);

    fs.append(LOG_FILE, chalk.stripAnsi(msg));
};

// TODO: setup logger register helper
// Log.register = function(type, color) {
//     this.
// }

// Export a singleton with only the methods we wish to expose
module.exports = {
    info: function() {
        Log.__log('info', 'blue', arguments);
    },
    warn: function() {
        Log.__log('warning', 'yellow', arguments);
    },
    error: function() {
        Log.__log('error', 'redBright', arguments);
    },
    debug: function() {
        Log.__log('debug', 'magentaBright', arguments);
    },
    success: function() {
        Log.__log('success', 'green', arguments);
    },
    // register: Log.register(,
};
