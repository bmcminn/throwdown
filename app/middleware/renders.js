const _ = require('lodash');
const frontmatter = require('gray-matter');

const path = require('../utils/path.js');
const fs = require('../utils/fs.js');
const db = require('../utils/db.js');
const Log = require('../utils/log.js');
const Config = require('../config.js');
const md = require('../utils/markdownit.js');

// init nunjucks instance
let viewsPath = path.join(Config.theme, 'views');

let njopts = {
    autoescape: false,
};

const nunjucks = require('../utils/nunjucks.js')([viewsPath], njopts);

// register shortcode plugins
const shortcodeHandlers = {};

fs
    .expand(fs.filter.isFile, [
        path.join(process.cwd(), 'app/plugins/**/shortcode.*.js'),
    ])
    .map((filepath) => {
        let plugin = require(filepath);

        shortcodeHandlers[plugin.label] = plugin.processor;
    });

/**
 * get post type based on the directory we're storing the file in
 * @param  {string} filepath target filepath
 * @return {string}          name of post type
 */
function getPostType(data) {
    // bail if we already provided the post type in the front matter config
    if (data.postType) {
        return data.postType;
    }

    let postType = 'page';

    let stringParts = data.filepath.substr(Config.source.length + 1).split('/');

    if (stringParts.length > 1) {
        postType = stringParts[0];
    }

    return postType;
}

/**
 * [getPublishedDate description]
 * @param  {[type]} content [description]
 * @return {[type]}         [description]
 */
function getPublishedDate(content) {
    if (content.hasOwnProperty('draft')) {
        return false;
    }

    // Log.debug(content.published);

    let now = Date.now();
    let pubDate = Date(content.published);

    // Log.debug(now, pubDate);

    if (now < pubDate) {
        return false;
    }

    return pubDate;
}

/**
 * [getRenderPath description]
 * @param  {[type]} filepath [description]
 * @return {[type]}          [description]
 */
function getRenderPath(filepath) {
    let target = filepath
        .substr(Config.source.length + 1)
        .replace(/\.[\w\d]{2,}$/, '');

    if (target.match(/index/)) {
        target = path.join(Config.destination, 'index.html');
    } else {
        target = path.join(Config.destination, target, 'index.html');
    }

    return target;
}

/**
 * [getTemplate description]
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 */
function getTemplate(data) {
    // prioritize content template override
    if (data.template) {
        return data.template;
    }

    // use posttype template if it exists
    if (data.postType) {
        let postTypeTemplate = path.join(
            Config.theme,
            `views/${data.postType}.${Config.view_ext}`
        );

        if (fs.exists(postTypeTemplate)) {
            return data.postType;
        }
    }

    // reutrn default template
    return 'default';
}

/**
 * Defines the data model for a given post
 * @param  {[type]} filepath [description]
 * @return {[type]}          [description]
 */
function getContent(filepath) {
    let fileContent = fs.read(filepath);

    data = frontmatter(fileContent);

    data = Object.assign(data, data.data);

    delete data.data;

    // assign the filepath (unique identifier)
    data.filepath = filepath;

    // make published date a standard date string
    // TODO: fix published string
    data.published = getPublishedDate(data);

    // // map author as array if string
    data.author = getAuthor(data);

    // define postType
    data.postType = getPostType(data);

    // trim leading/trailing whitespace from page content
    data.content = data.content.trim();

    // assign render path
    data.renderPath = getRenderPath(filepath);

    // get template
    data.template = getTemplate(data);

    // expunge empty data fields
    data = expungeNulls(data);

    return data;
}

/**
 * [expungeNulls description]
 * @param  {[type]} oldData [description]
 * @return {[type]}         [description]
 */
function expungeNulls(oldData) {
    let data = {};

    for (prop in oldData) {
        if (oldData.hasOwnProperty(prop)) {
            if (oldData[prop]) {
                data[prop] = oldData[prop];
            }
        }
    }

    return data;
}

/**
 * [processShortcodes description]
 * @param  {[type]} match           [description]
 * @param  {[type]} shortCodeConfig [description]
 * @return {[type]}                 [description]
 */
function processShortcodes(match, shortCodeConfig) {
    let parts = shortCodeConfig.trim().split('||');

    // get shortcode label
    let shortcode = parts[0].trim();

    let opts = {};

    // parse all the attributes defined in the shortcode
    parts.slice(1).map((prop) => {
        prop = prop.split('=');

        let key = prop[0].trim().toLowerCase();
        let val = prop[1].trim();
        let value;

        // assign value, we'll override it based on the following conditions...
        value = val;

        // if boolean true
        val.toLowerCase() === 'true' ? (value = true) : null;

        // if boolean false
        val.toLowerCase() === 'false' ? (value = false) : null;

        // if number
        val.match(/^[\d.,]+$/) ? (value = parseFloat(val, 10)) : null;

        opts[key] = value;
    });

    // check if we have a handler for this shortcode
    if (!shortcodeHandlers[shortcode]) {
        return `<!-- couldn't process shortcode '${shortcode}' -->`;
    }

    // pass the shortcode parameters to the handler and return the updated contents
    return shortcodeHandlers[shortcode](opts);
}

/**
 * [getAuthor description]
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 */
function getAuthor(data) {
    let authorList = [];

    // bail if we haven't authored
    if (!data.author) {
        return null;
    }

    // validate if data.author is an array like it should be
    if (!Array.isArray(data.author)) {
        Log.error(data.filepath, ':: data.author should be an array.');
        return [];
    }

    if (data.author) {
        data.author.map((author) => {
            if (Config.author[author]) {
                authorList.push(Config.author[author]);
            } else {
                Log.warn(`Author ${author} does not exist in config.yaml`);
            }
        });
    }

    //
    return authorList.length > 0 ? authorList : null;
}

/**
 * [renderPage description]
 * @param  {[type]} filepath [description]
 * @param  {[type]} norender [description]
 * @return {[type]}          [description]
 */
function renderPage(filepath, norender) {
    norender = norender || false;

    let pageData = getContent(filepath);

    if (norender) {
        return pageData;
    }

    let model = Object.assign(Config, {
        page: pageData,
    });

    // process short codes
    let content = pageData.content.replace(
        /\[\[([\s\S]+?)\]\]/gi,
        processShortcodes
    );

    // model.content = md.render(content);
    model.content = content;

    delete model.page.content;

    // process markdown?

    // process nunjucks?
    markup = nunjucks.render(pageData.template, model);

    fs.write(pageData.renderPath, markup);

    return pageData;
}

module.exports = renderPage;
