const _ = require('lodash');
const path = require('path');
const fs = require('./utils/fs.js');
const regex = require('./utils/regex.js');

// defaults to be applied for missing parameters in user config.yaml(s)
const defaults = {
    // include/exclude glob paths for system watch process
    include: ['./content/**/*', './theme/**/*'],
    exclude: [],

    // content localization defaults
    lang: 'en',
    timezone: null,

    // server configs
    port: 8080,
    host: 'localhost',

    // general collection
    layout: 'pages',
    limit_posts: 0,

    // content publishing/preview configs
    unpublished: false,
    show_drafts: false,
    future: false,

    // syntax hightlighting defaults
    highlight_theme: 'Monokai Sublime',

    // filepaths for system critical components
    cache: './app/cache',
    destination: './public',
    source: './content',
    theme: './theme',

    // file extensions to be watched for changes
    mediaExts: ['gif', 'jpg', 'jpeg', 'png', 'tiff', 'mov', 'mp3', 'mp4'],
    styleExts: ['sass', 'scss', 'styl', 'css'],
    scriptExts: ['js', 'ts'],
    markdownExts: ['markdown', 'mdown', 'mkdn', 'mkd', 'md', 'txt', 'mdwn'],

    // base collections config object
    collections: {},
};

// user config filepath
let configYAML = path.join(process.cwd(), './theme/config.yaml');

// get user config overrides
let overrides = fs.readYAML(configYAML);

// define Config export using defaults and overrides
let Config = _.defaultsDeep(defaults, overrides);

// define watchFiles for serve.js watch process
Config.watchFiles = [].concat(
    Config.include.map((filepath) => path.join(process.cwd(), filepath)),
    Config.exclude.map((filepath) => '!' + path.join(process.cwd(), filepath))
);

// map filepaths to root dir
Config.cache = path.join(process.cwd(), Config.cache);
Config.theme = path.join(process.cwd(), Config.theme);
Config.source = path.join(process.cwd(), Config.source);
Config.destination = path.join(process.cwd(), Config.destination);

// glob for custom config.yaml configs
let collectionConfigs = fs.expand(
    { filter: 'isFile' },
    Config.watchFiles.map((filepath) => filepath + '/config.yaml')
);

// map each config file based on the posttype folder name
_.each(collectionConfigs, (filepath) => {
    let parts = filepath.split('/');
    let collection = parts[parts.length - 2];
    Config.collections[collection] = fs.readYAML(filepath);

    // default collection posts limit config to system default
    Config.collections[collection].limit_posts =
        Config.collections[collection].limit_posts || Config.limit_posts;

    // default collection.layout to the colleciton name
    // NOTE: if the collection name view does not exist, the sytem will default to the system.layout value
    Config.collections[collection].layout =
        Config.collections[collection].layout ||
        collection.trim().replace(regex.hyphenable, '-');
});

// ensure collections.defaults properties is defined accordingly
Config.collections.defaults = {
    limit_posts: Config.limit_posts,
    layout: Config.layout,
};

module.exports = Config;
