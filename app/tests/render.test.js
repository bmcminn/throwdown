const path = require('path');

const Log = require('../utils/log.js');
const render = require('../middleware/renders.js');
const Config = require('../config.js');

let testFile = path.join(Config.source, 'index.md');

let content = render(testFile);

// console.log(content);

// console.log(content);
