const Path = require('path');
const FS = require('./.bin/fs.js');
const chokidar = require('chokidar');
const Config = require('./.bin/config.js');
const bus = require('./.bin/bus.js');
const Log = require('./.bin/log.js');
const app = require('./.bin/build.js');
// import * from './log';

// const path = require('path');
// const fs = require('grunt').file;
// const chokidar = require('chokidar');
// const _ = require('lodash');
// const chalk = require('chalk');
// const Log = reuqire('./.bin/log');

let watchFiles = FS.expand({ filter: 'isFile' }, Config.watchFiles);

chokidar
    .watch(watchFiles, { ignored: /(^|[\/\\])\../ })
    .on('any', function(i, e) {
        console.log(i, e);
    })
    .on('change', function(filepath, filemeta) {
        console.log('file', filepath, filemeta);

        Log.debug(JSON.stringify([filepath, filemeta]));

        if (filepath.match(/\.(sass|scss|styl|css)$/)) {
            let event = 'css-update';
            bus.emit(event, filepath);
        }

        if (filepath.match(/\.(js|ts)$/)) {
            let event = 'js-update';
            bus.emit(event, filepath);
        }

        if (filepath.match(/\.(markdown|mdown|mkdn|mkd|md|text|mdwn)$/)) {
            let event = 'content-update';
            bus.emit(event, filepath);
        }
    });

// =============================================

process.env.FILE_SERVER_PATH = Config.SERVER_PATH || '/public';
process.env.FILE_SERVER_PORT = Config.SERVER_PORT || 8080;

require('node-file-server');
