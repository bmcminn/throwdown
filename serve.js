const Path = require('path');
const chokidar = require('chokidar');
const Config = require('./.bin/config.js');

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

process.env.FILE_SERVER_PATH = Config.SERVER_PORT;
process.env.FILE_SERVER_PORT = Config.SERVER_PATH;

console.log(`Starting node fileserver at http://localhost:${SERVER_PORT}`);

require('node-file-server');
