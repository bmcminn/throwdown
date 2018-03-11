const path = require('path');
const low = require('lowdb');
const FileSync = require('lowdb/adapters/FileSync');

let dbPath = path.resolve('./app/cache/db.json');

const Log = require('./log.js');

const adapter = new FileSync(dbPath);
const db = low(adapter);


// db._.mixin({
//     upsert: (arr, filterKey, data) => {

//         // console.log('asdjfksjflsdf', arr, filterKey, data);
//         let filter = {};

//         filter[filterKey] = data[filterKey];

//         let res = _.filter(arr, filter);

//         // if we found an existing entry
//         if (!!res.length) {
//             _.assign(res, data);
//         }
//     }
// });


// Set some defaults
db.defaults({ posts: [] })
  .write()
  ;


module.exports = db;
