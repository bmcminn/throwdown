const Path = require('path');

let Config = {};

Config.ROOT_DIR = process.cwd();

Config.ASSETS_DIR = Path.join(Config.ROOT_DIR, 'assets');
Config.CACHE_DIR = Path.join(Config.ROOT_DIR, 'cache');
Config.CONTENT_DIR = Path.join(Config.ROOT_DIR, 'content');
Config.DIST_DIR = Path.join(Config.ROOT_DIR, 'public');

Config.CSS_DIR = Path.join(Config.ASSETS_DIR, 'css');
Config.CSS_DIST = Path.join(Config.DIST_DIR, 'css');

Config.LOGS_DIR = Path.join(Config.CACHE_DIR, 'logs');

Config.SERVER_PORT = 8080;
Config.SERVER_PATH = Path.join(process.cwd(), 'public');

Config.DB_PATH = Path.join(Config.CACHE_DIR, 'db.sqlite');

Config.watchFiles = [
    Path.join(Config.ASSETS_DIR, '**/*'),
    Path.join(Config.CONTENT_DIR, '**/*'),
];

module.exports = Config;
