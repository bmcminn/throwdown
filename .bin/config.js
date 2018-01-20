const Path = require('path');

let Config = {};

Config.ROOT_DIR = process.cwd();

Config.DIST_DIR = Path.join(Config.ROOT_DIR, 'public');

Config.CONTENT_DIR = Path.join(Config.ROOT_DIR, 'content');
Config.CACHE_DIR = Path.join(Config.ROOT_DIR, 'cache');

Config.STYL_DIR = Path.join(Config.ROOT_DIR, 'styl');
Config.CSS_DIR = Path.join(Config.DIST_DIR, 'css');

Config.SERVER_PORT = 8080;
Config.SERVER_PATH = Path.join(process.cwd(), 'public');

Config.DB_PATH = Path.join(Config.CACHE_DIR, 'db.sqlite');

module.exports = Config;
