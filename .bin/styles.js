import path from 'path';
import { file as fs } from 'grunt';
import { each } from 'lodash';
import Log from './log';

module.exports.compileStyles = function(filepath) {
    let styles = fs.expand({ filter: 'isFile' }, [
        path.join(STYL_DIR, '**/*'),
        '!' + path.join(STYL_DIR, '**/_*'),
    ]);

    _.each(styles, function(style) {
        let filename = path
            .basename(style)
            .replace(/\s+/, '-')
            .toLowerCase();

        let newStyle = path.join(DIST_DIR, filename.replace(/\.[\w\d]+/, ''));

        let content = fs.read(style);

        Stylus(content)
            .set('filename', style)
            .set('paths', [STYL_DIR])
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
                fs.write(`${newStyle}.css`, css);

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
