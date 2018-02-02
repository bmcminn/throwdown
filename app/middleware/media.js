const path = require('path');
const _ = require('lodash');
const Stylus = require('stylus');
const CSSO = require('csso');

const fs = require('../utils/fs.js');
const Log = require('../utils/log.js');
const Config = require('../config.js');

const JS_DIR = path.join(Config.theme, 'js');
const JS_DEST = path.join(Config.destination, 'js');

// TODO: make this compile and minify all client side scripts
module.exports = function(filepath) {
    Log.info(filepath);

    let styles = fs.expand({ filter: 'isFile' }, [
        path.join(JS_DIR, '**/*'),
        '!' + path.join(JS_DIR, '**/_*'),
    ]);

    _.each(styles, function(style) {
        let filename = path
            .basename(style)
            .replace(/\s+/, '-')
            .toLowerCase();

        let newStyle = path.join(JS_DEST, filename.replace(/\.[\w\d]+/, '.js'));

        let content = fs.read(style);

        Stylus(content)
            .set('filename', style)
            .set('paths', [JS_DIR])
            // .set('linenos',     process.env.NODE_ENV ? false : true)
            // .set('compress',    process.env.NODE_ENV ? true : false)
            .render(function(err, css) {
                if (err) {
                    Log.error(err);
                    return;
                }

                // POST PROCESS CSS A BIT
                css = css
                    .replace(/#__ROOT__/gi, ':root')
                    .replace(/PP__/gi, '--');

                // Write unminified styles to disk
                fs.write(newStyle, css);

                let csso_opts = {
                    debug: process.env.NODE_ENV ? false : true,
                    // ,   c:      process.env.NODE_ENV ? true : false
                };

                css = CSSO.minify(css, csso_opts).css;

                // console.log(css);
                fs.write(`${newStyle}.min.css`, css);

                Log.success(`Compiled ${style}`);
            });
    });
};
