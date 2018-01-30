const path = require('path');
const _ = require('lodash');

const Config = require('../config.js');
const render = require('../middleware/renders.js');
const db = require('../utils/db.js');
const fs = require('../utils/fs.js');

let exts = ['markdown', 'mdown', 'mkdn', 'mkd', 'md', 'text', 'mdwn'].join('|');

let files = [path.join(Config.source, `**/*.+(${exts})`)];

let filesList = fs.expand({ filter: 'isFile' }, files);

_.each(filesList, (filepath, index) => {
    let content = render(filepath);

    console.log(content);

    let post = db
        .get('posts')
        .filter({ filepath: filepath })
        .value();

    if (post) {
        db
            .get('posts')
            .find({ filepath: filepath })
            .assign(content)
            .write();

        return;
    }

    db
        .get('posts')
        .push(content)
        .write();
});
