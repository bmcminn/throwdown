const Path = require('path');
const _ = require('lodash');
const Stylus = require('stylus');
const CSSO = require('csso');

const fs = require('../utils/fs.js');
const Log = require('../utils/log.js');
const Config = require('../config.js');

const CSS_DIR = Path.join(Config.ASSETS_DIR, 'css');
const CSS_DIST = Path.join(Config.PUBLIC_DIR, 'css');

const compileStyles = function(filepath) {
    Log.info(filepath);

    let styles = fs.expand({ filter: 'isFile' }, [
        Path.join(CSS_DIR, '**/*'),
        '!' + Path.join(CSS_DIR, '**/_*'),
    ]);

    _.each(styles, function(style) {
        let filename = Path.basename(style)
            .replace(/\s+/, '-')
            .toLowerCase();

        let newStyle = Path.join(
            CSS_DIST,
            filename.replace(/\.[\w\d]+/, '.css')
        );

        let content = fs.read(style);

        Stylus(content)
            .set('filename', style)
            .set('paths', [CSS_DIR])
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

module.exports = compileStyles;
