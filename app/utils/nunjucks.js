const path = require('path');
const fs = require('../utils/fs.js');
const nunjucks = require('nunjucks');
const chokidar = require('chokidar');

const regex = {
    ext: /\.[\w\d]{2,}$/i,
};

let reloader = new nunjucks.Loader.extend({
    init: function(viewspath, opts) {
        this.opts = opts || {};
        this.templates = {};
        // TODO: need better way of passing custom options to nunjucks instance
        this.opts.extension = this.opts.extension || '.twig';
        this.viewsDir = viewspath[0];

        this.getFiles();

        let self = this;

        if (this.opts.watch) {
            chokidar.watch(self.viewsDir).on('change', (filepath) => {
                console.log('updated view:', filepath);
                this.getFile(filepath);
                this.emit('update', this.getFileName(filepath));
            });
        }
    },

    getFile: function(filepath) {
        let self = this;

        let name = this.getFileName(filepath);
        this.templates[name] = fs.read(filepath);
    },

    getFiles: function() {
        let self = this;

        let viewFiles = fs.expand(
            { filter: 'isFile' },
            path.join(self.viewsDir, '**/*' + self.opts.extension)
        );

        viewFiles.map(this.getFile, this);
    },

    getFileName: function(filepath) {
        let self = this;

        let filename = filepath
            .substr(self.viewsDir.length + 1) // remove the base directory path
            .replace(regex.ext, '');

        return filename;
    },

    // TODO: add watcher process to update files when changed
    getSource: function(name) {
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
    },
});

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

const env = new nunjucks.Environment(reloader);

module.exports = nunjucks;
