const sqlite = require('sqlite');
const Promise = require('bluebird');

const Config = require('./config.js');

const dbPromise = Promise.resolve().then(() => sqlite.open(Config.DB_PATH), { Promise }))
.then(db => db.migrate({ force: Config.LOCAL ? 'last' : false }));
