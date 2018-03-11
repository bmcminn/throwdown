
//
const fs            = require('./utils/fs');
const path          = require('path');
const graymatter    = require('gray-matter');


const REGEX = {
    indexFile:  /^index\.[\S]{2,}$/i
,   fileExt:    /\.[\S]{2,}$/i
};


//
const ROOT_DIR      = path.resolve(process.cwd());
const CONTENT_DIR   = path.resolve(ROOT_DIR, 'content');
const PUBLIC_DIR    = path.resolve(ROOT_DIR, 'public');
const APP_DIR       = path.resolve(ROOT_DIR, 'app');
const THEME_DIR     = path.resolve(ROOT_DIR, 'theme');
const LOGS_DIR      = path.resolve(ROOT_DIR, 'logs');
const CACHE_DIR     = path.resolve(ROOT_DIR, 'cache');


// ensure the file system exists
[ CONTENT_DIR, PUBLIC_DIR, APP_DIR, THEME_DIR, LOGS_DIR, CACHE_DIR ].forEach((dir) => {
    if (!fs.isDir(dir)) {
        fs.mkdir(dir);
    }
});


// get list of all files to cache
const srcFilesGlob = [
    path.join(CONTENT_DIR, '**/*.md')
];

const srcFiles = fs.expand(srcFilesGlob);


const contentFiles = srcFiles.map((filepath) => {

    let fileDest = filepath
        .substring(CONTENT_DIR.length + 1)
        .replace(REGEX.indexFile, '')
        .replace(REGEX.fileExt, '')
        ;


    return {
        filename: fileDest === '' ? 'index' : path.basename(fileDest),
        src: filepath,
        dest: path.posix.join(PUBLIC_DIR, fileDest, 'index.html')
    };
});


console.log(contentFiles);

