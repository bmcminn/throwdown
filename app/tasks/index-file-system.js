const Path = require('path');
const FS = require('grunt').file;
const _ = require('lodash');
const Config = require('../config.js');
const DB = require('../db.js');

let exts = ['markdown', 'mdown', 'mkdn', 'mkd', 'md', 'text', 'mdwn'].join('|');

let files = [Path.join(Config.CONTENT_DIR, `**/*.+(${exts})`)];

let filesList = FS.expand({ filter: 'isFile' }, files);

console.log(filesList, files);
