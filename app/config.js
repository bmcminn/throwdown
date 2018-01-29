const path = require('path');
const fs = require('./utils/fs.js');
const _ = require('lodash');

const defaults = {
    cache: './app/cache',
    destination: './public',
    exclude: [],
    future: false,
    highlight_theme: 'Monokai Sublime',
    host: 'localhost',
    include: ['./content/**/*', './theme/**/*'],
    lang: 'en',
    limit_posts: 0,
    port: 8080,
    layout: 'pages',
    show_drafts: false,
    source: './content',
    theme: './theme',
    timezone: null,
    unpublished: false,
    mediaExts: ['gif', 'jpg', 'jpeg', 'png', 'tiff', 'mov', 'mp3', 'mp4'],
    styleExts: ['sass', 'scss', 'styl', 'css'],
    scriptExts: ['js', 'ts'],
    markdownExts: ['markdown', 'mdown', 'mkdn', 'mkd', 'md', 'txt', 'mdwn'],
    collections: {},
};

let configYAML = path.join(process.cwd(), './theme/config.yaml');

let overrides = fs.readYAML(configYAML);

let Config = _.defaultsDeep(defaults, overrides);

Config.watchFiles = [].concat(
    Config.include.map((filepath) => path.join(process.cwd(), filepath)),
    Config.exclude.map((filepath) => '!' + path.join(process.cwd(), filepath))
);

// gather all custom config.yaml configs
let collectionConfigs = fs.expand(
    { filter: 'isFile' },
    Config.watchFiles.map((filepath) => filepath + '/config.yaml')
);

_.each(collectionConfigs, (filepath) => {
    //
    let filepathParts = filepath.split('/');

    // get the second-to-last index (collection)
    let collection = filepathParts[filepathParts.length - 2];

    Config.collections[collection] = fs.readYAML(filepath);
});

module.exports = Config;
