import * as Path from 'path';
import chokidar from 'chokidar';
import * as Config from './.bin/config.js';
// import * from './log';

// const path = require('path');
// const fs = require('grunt').file;
// const chokidar = require('chokidar');
// const _ = require('lodash');
// const chalk = require('chalk');
// const Log = reuqire('./.bin/log');

chokidar
    .watch(Config.files, { ignored: /(^|[\/\\])\../ })
    .on('change', (filepath, filemeta) => {
        if (filepath.match(/\.styl$/)) {
            console.log('file');
            // compileStyles(filepath);
        }
    });

let SERVER_PORT = Config.FILE_SERVER_PATH || 8080;
let SERVER_PATH = Config.FILE_SERVER_PATH || './';

Log.info(`Starting node fileserver at http://localhost:${SERVER_PORT}`);

require('node-file-server');
