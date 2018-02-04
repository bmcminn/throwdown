const path = require('path');
const nunjucks = require('nunjucks');
const chokidar = require('chokidar');

const fs = require('../utils/fs.js');
const Log = require('../utils/log.js');

const regex = {
    ext: /\.[\w\d]{2,}$/i,
};



// Reloader.prototype.getSource = function(name) {
//     // load the template
//     // return an object with:
//     //   - src:     String. The template source.
//     //   - path:    String. Path to template.
//     //   - noCache: Bool. Don't cache the template (optional).
// }

function Reloader(viewspath, opts) {
    this.init(viewspath, opts);
    // this.opts = opts || {};
    // this.opts.extension = this.opts.extension || '.twig';
    // this.templates = {};
    // // TODO: need better way of passing custom options to nunjucks instance
    // this.viewsDir = viewspath;

    // this.getFiles();

    // console.log(this.templates);
}


/**
 * Constructor for the nunjucks loader instance
 * @param  {array}  viewspath list of views paths
 * @param  {obj}    opts      configuration for this loader instance
 * @return {nunjucks}
 */
Reloader.prototype.init = function(viewspath, opts) {

    this.opts = opts || {};
    this.opts.extension = this.opts.extension || '.twig';
    this.templates = {};
    // TODO: need better way of passing custom options to nunjucks instance
    this.viewsDir = path.resolve(viewspath[0]);

    this.getFiles();

    // let self = this;

    // chokidar.watch(self.viewsDir).on('change', (filepath) => {
    //     console.log('updated view:', filepath);
    //     this.getFile(filepath);
    //     this.emit('update', this.getFileName(filepath));
    // });
};

Reloader.prototype.getFile = function(filepath) {
    let self = this;

    let name = this.getFileName(filepath);
    this.templates[name] = fs.read(filepath);
};

Reloader.prototype.getFiles = function() {
    let self = this;

    let viewFiles = fs.expand(
        { filter: 'isFile' },
        path.join(self.viewsDir, '**/*' + self.opts.extension)
    );

    viewFiles.map(this.getFile, this);
};

Reloader.prototype.getFileName = function(filepath) {
    let self = this;

    // Log.debug(filepath);

    let filename = filepath
        .substr(self.viewsDir.length + 1) // remove the base directory path
        .replace(regex.ext, '');

    // Log.debug(filename);

    return filename;
};

// TODO: add watcher process to update files when changed
Reloader.prototype.getSource = function(name) {
    let self = this;

    name = name.replace(regex.ext, '');

    if (!self.templates[name]) {
        throw Error(`No template '${name}' exists.`);
    }

    return {
        src: self.templates[name],
        path: name,
        noCache: this.noCache || false,
    };
};

let filters = {
    date: function(datetime, format) {
        return require('./nunjucks/filter-date')(nunjucks)(
            datetime,
            format || 'YYYY-MM-DDThh:mm:ssZ',
            model
        );
    },
    // date: require('nunjucks-date-filter')

    debug: function(ctx, space) {
        return new nunjucks.runtime.SafeString(
            JSON.stringify(ctx, null, space || 0)
        );
    },

    shorten: function(str, count) {
        return str.slice(0, count || 5);
    },

    spaceless: function(content) {
        return require('./nunjucks/filter-spaceless')(nunjucks)(content);
    },

    sanitize: function(content) {
        return require('./nunjucks/filter-sanitize')(nunjucks)(content);
    },

    log: function(content) {
        return require('./nunjucks/filter-log')(nunjucks)(content);
    },

    hash: function(content) {
        return require('./nunjucks/filter-hash')(nunjucks)(content);
    },

    // @sauce: https://perishablepress.com/best-method-for-email-obfuscation/
    email: function(content) {
        return require('./nunjucks/filter-email')(nunjucks)(content);
    },

    phone: function(content) {
        return require('./nunjucks/filter-phone')(nunjucks)(content);
    },

    slugify: function(content) {
        return require('./nunjucks/filter-slugify')(nunjucks)(content);
    },

    md: function(content) {
        return require('./nunjucks/filter-md')(nunjucks)(content);
    },

    render: function(content, ctx) {
        return require('./nunjucks/filter-render')(nunjucks)(content, ctx);
    },

    parseFloat: function(content) {
        return parseFloat(content).toFixed(1);
    },

    icon: function(name) {
        return new nunjucks.runtime.SafeString(
            '<i class="fa fa-' + name + '" aria-hidden="true"></i>'
        );
    },
};


module.exports = function(viewspath, opts) {

    nunjucks.configure(viewspath, opts);

    // let Reloader = new nunjucks.Loader.extend(Reloader);

    const env = new nunjucks.Environment(new Reloader(viewspath, opts));

    for (filter in filters) {
        if (filters.hasOwnProperty(filter)) {
            env.addFilter(filter, filters[filter]);
        }
    }

    return env;
};
