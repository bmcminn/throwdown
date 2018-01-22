const Path = require('path');
const FS = require('./app/fs.js');
const chokidar = require('chokidar');
const Config = require('./config.js');
const bus = require('./app/bus.js');
const Log = require('./app/log.js');
// const app = require('./app/build.js');

// =============================================
//  SETUP FILE WATCH INSTANCE
// =============================================

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
            bus.emit('pre-' + event, filepath);
            bus.emit(event, filepath);
            bus.emit('post-' + event, filepath);
        }

        if (filepath.match(/\.(js|ts)$/)) {
            let event = 'js-update';
            bus.emit('pre-' + event, filepath);
            bus.emit(event, filepath);
            bus.emit('post-' + event, filepath);
        }

        if (filepath.match(/\.(markdown|mdown|mkdn|mkd|md|text|mdwn)$/)) {
            let event = 'content-update';
            bus.emit('pre-' + event, filepath);
            bus.emit(event, filepath);
            bus.emit('post-' + event, filepath);
        }
    });

// =============================================
//  SETUP FILE SERVER INSTANCE
// =============================================

process.env.FILE_SERVER_PATH = Config.SERVER_PATH || '/public';
process.env.FILE_SERVER_PORT = Config.SERVER_PORT || 8080;

// require('node-file-server');
require('./app/server.js');

// let middleware = FS.expand({ filter: 'isFile' }, [
//     Path.join(process.cwd(), 'middleware', '*.js'),
// ]);

// Log.debug(middleware);

// =============================================
//  LOAD APP MIDDLEWARE
// =============================================

bus.on('update-css', require('./middleware/styles.js'));
