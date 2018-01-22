const Path = require('path');
const FS = require('./app/fs.js');
const chokidar = require('chokidar');
const Config = require('./config.js');
const bus = require('./app/bus.js');
const Log = require('./app/log.js');
// const app = require('./app/build.js');

// =============================================
//  LOAD APP MIDDLEWARE
// =============================================

const compileStyles = require('./middleware/styles.js');

const events = {
    cssUpdate: 'update-css',
    jsUpdate: 'update-js',
    contentUpdate: 'update-content',
};

bus.on(events.cssUpdate, compileStyles);

// =============================================
//  SETUP FILE WATCH INSTANCE
// =============================================

function processFiles(name, exts, filepath) {
    let extRegex = new RegExp('.' + exts.join('|') + '$');
    if (filepath.match(extRegex)) {
        bus.emit('pre-' + name, filepath);
        bus.emit(name, filepath);
        bus.emit('post-' + name, filepath);
    }
}

let watchFiles = FS.expand({ filter: 'isFile' }, Config.watchFiles);

chokidar
    .watch(watchFiles, { ignored: /(^|[\/\\])\../ })
    .on('any', function(i, e) {
        console.log(i, e);
    })
    .on('change', function(filepath, filemeta) {
        console.log('file', filepath, filemeta);

        Log.debug(JSON.stringify([filepath, filemeta]));

        // process style files
        processFiles(
            events.cssUpdate,
            ['sass', 'scss', 'styl', 'css'],
            filepath
        );

        // process js files
        processFiles(events.jsUpdate, ['js', 'ts'], filepath);

        // process content files
        processFiles(
            events.contentUpdate,
            ['markdown', 'mdown', 'mkdn', 'mkd', 'md', 'text', 'txt', 'mdwn'],
            filepath
        );
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
