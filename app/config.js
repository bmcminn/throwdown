const path = require('path');
const fs    = require('./utils/fs.js');

let Config = {};

Config.ROOT_DIR = process.cwd();

Config.APP_DIR = path.join(Config.ROOT_DIR, 'app');
Config.ASSETS_DIR = path.join(Config.APP_DIR, 'assets');
Config.CACHE_DIR = path.join(Config.APP_DIR, 'cache');

Config.CONTENT_DIR = path.join(Config.ROOT_DIR, 'content');
Config.PUBLIC_DIR = path.join(Config.ROOT_DIR, 'public');

Config.SERVER_PORT = 8080;
Config.SERVER_PATH = path.join(process.cwd(), 'public');

Config.DB_PATH = path.join(Config.CACHE_DIR, 'db.sqlite');

if (!fs.exists(Config.DB_PATH)) {
    fs.write(Config.DB_PATH, '');
}

Config.watchFiles = [
    path.join(Config.ASSETS_DIR, '**/*'),
    path.join(Config.CONTENT_DIR, '**/*'),
];

module.exports = Config;
