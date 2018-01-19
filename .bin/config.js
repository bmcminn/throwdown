import * as Path from 'path';

module.exports = {
    DIST_DIR: Path.join(process.cwd(), 'dist'),
    STYL_DIR: Path.join(process.cwd(), 'styl'),
    CSS_DIR: Path.join(DIST_DIR, 'css'),
};
