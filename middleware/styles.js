const path = require('path');
const _ = require('lodash');
const fs = require('../app/fs.js');
const Log = require('../app/log.js');
const Config = require('../config.js');

const compileStyles = function(filepath) {
    Log.info(filepath);

    let styles = fs.expand({ filter: 'isFile' }, [
        path.join(Config.CSS_DIR, '**/*'),
        '!' + path.join(Config.CSS_DIR, '**/_*'),
    ]);

    _.each(styles, function(style) {
        let filename = path
            .basename(style)
            .replace(/\s+/, '-')
            .toLowerCase();

        let newStyle = path.join(
            Config.DIST_DIR,
            filename.replace(/\.[\w\d]+/, '.css')
        );

        let content = fs.read(style);

        Stylus(content)
            .set('filename', style)
            .set('paths', [Config.CSS_DIR])
            // .set('linenos',     process.env.NODE_ENV ? false : true)
            // .set('compress',    process.env.NODE_ENV ? true : false)
            .render(function(err, css) {
                if (err) {
                    console.error(chalk.red(err));
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

                console.log(chalk.green(`> Compiled ${style}`));
            });
    });
};

module.exports = compileStyles;
