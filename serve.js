const Path = require('path');
const FS = require('./.bin/fs.js');
const chokidar = require('chokidar');
const Config = require('./.bin/config.js');
const bus = require('./.bin/bus.js');
const Log = require('./.bin/log.js');
// import * from './log';

// const path = require('path');
// const fs = require('grunt').file;
// const chokidar = require('chokidar');
// const _ = require('lodash');
// const chalk = require('chalk');
// const Log = reuqire('./.bin/log');
Log.debug([123456, true]);

console.log(Config.watchFiles);

chokidar
    .watch(Config.watchFiles, { ignored: /(^|[\/\\])\../ })
    .on('change', (filepath, filemeta) => {
        console.log('file', filepath, filemeta);

        Log.debug(JSON.stringify([filepath, filemeta]));

        if (filepath.match(/\.(sass|scss|styl|css)$/)) {
            bus.emit('style update', filepath);
            // compileStyles(filepath);
        }

        if (filepath.match(/\.(js|ts)$/)) {
            bus.emit('js update', filepath);
            // compileStyles(filepath);
        }

        if (filepath.match(/\.(markdown|mdown|mkdn|mkd|md|text|mdwn)$/)) {
            bus.emit('content update', filepath);
            // compileStyles(filepath);
        }
    });

process.env.FILE_SERVER_PATH = Config.SERVER_PORT;
process.env.FILE_SERVER_PORT = Config.SERVER_PATH;

require('node-file-server');
