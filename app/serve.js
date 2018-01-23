const Path = require('path');
const chokidar = require('chokidar');

const Config = require('./config.js');

const FS = require('./utils/fs.js');
const bus = require('./utils/bus.js');
const Log = require('./utils/log.js');

// =============================================
//  LOAD APP MIDDLEWARE
// =============================================

const events = {
    cssUpdate: 'update-css',
    jsUpdate: 'update-js',
    contentUpdate: 'update-content',
};

const compileStyles = require('./middleware/styles.js');
const renderPage = require('./middleware/renders.js');

bus.on(events.cssUpdate, compileStyles);
bus.on(events.contentUpdate, renderPage);

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
    // .on('any', function(i, e) {
    //     console.log(i, e);
    // })
    .on('change', function(filepath, filemeta) {
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

require('./utils/server.js');
