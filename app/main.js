const Path = require('path');
const chokidar = require('chokidar');

const Config = require('./config.js');

const FS = require('./utils/fs.js');
const bus = require('./utils/bus.js');
const Log = require('./utils/log.js');
// const migrateMediaFiles = require('./middleware/migrate-media-files.js');

// =============================================
//  LOAD APP MIDDLEWARE
// =============================================

const events = {
    cssUpdate:     'update-css',
    jsUpdate:      'update-js',
    contentUpdate: 'update-content',
};

bus.on(events.cssUpdate, require('./middleware/styles.js'));
bus.on(events.jsUpdate, require('./middleware/scripts.js'));
bus.on(events.contentUpdate, require('./middleware/renders.js'));

// =============================================
//  SETUP FILE WATCH INSTANCE
// =============================================

/**
 * [processFiles description]
 * @param  {[type]} name     [description]
 * @param  {[type]} exts     [description]
 * @param  {[type]} filepath [description]
 */
function registerEventHooks(name, exts, filepath) {
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
        migrateMediaFiles();
        console.log(i, e);
    })
    .on('change', function(filepath, filemeta) {
        // process style files
        registerEventHooks(events.cssUpdate, Config.styleExts, filepath);

        // process js files
        registerEventHooks(events.jsUpdate, Config.scriptExts, filepath);

        // process content files
        registerEventHooks(events.contentUpdate, Config.markdownExts, filepath);
    });

// =============================================
//  SETUP FILE SERVER INSTANCE
// =============================================

require('./utils/server.js');
