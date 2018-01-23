const Path = require('path');

let Config = {};

Config.ROOT_DIR = process.cwd();

Config.APP_DIR = Path.join(Config.ROOT_DIR, 'app');
Config.ASSETS_DIR = Path.join(Config.APP_DIR, 'assets');
Config.CACHE_DIR = Path.join(Config.APP_DIR, 'cache');

Config.CONTENT_DIR = Path.join(Config.ROOT_DIR, 'content');
Config.DIST_DIR = Path.join(Config.ROOT_DIR, 'public');

Config.SERVER_PORT = 8080;
Config.SERVER_PATH = Path.join(process.cwd(), 'public');

Config.DB_PATH = Path.join(Config.CACHE_DIR, 'db.sqlite');

Config.watchFiles = [
    Path.join(Config.ASSETS_DIR, '**/*'),
    Path.join(Config.CONTENT_DIR, '**/*'),
];

module.exports = Config;
