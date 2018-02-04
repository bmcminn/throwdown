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

};

const nunjucks = require('../utils/nunjucks.js')([viewsPath], njopts);

// TODO: register shortcode plugins and call the necessary shortcode with these parameters
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
function getPostType(filepath) {
    let postType = 'page';

    let stringParts = filepath.substr(Config.source.length + 1).split('/');

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
    }

    return path.join(Config.destination, target, 'index.html');
}



function getTemplate(data) {

    // prioritize content template override
    if (data.template) {
        return data.template;
    }

    // use posttype template if it exists
    if (data.postType) {

        let postTypeTemplate = path.join(Config.theme, `views/${data.postType}.${Config.view_ext}`);

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

    // make published date a standard date string
    // TODO: fix published string
    data.published = getPublishedDate(data);

    // Log.debug(data.published);

    // // map author as array if string
    // if (data.author)

    // define postType
    data.postType = data.postType || getPostType(filepath);

    // trim leading/trailing whitespace from page content
    data.content = data.content.trim();

    // assign the filepath (unique identifier)
    data.filepath = filepath;

    // assign render path
    data.renderPath = getRenderPath(filepath);

    data.template = getTemplate(data);

    Log.debug('getTemplate', data);

    // TODO: expunge empty data fields

    return data;
}

/**
 * [processShortcodes description]
 * @param  {[type]} match           [description]
 * @param  {[type]} shortCodeConfig [description]
 * @return {[type]}                 [description]
 */
function processShortcodes(match, shortCodeConfig) {
    let parts = shortCodeConfig
        .trim()
        .split('||');

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
        post: pageData,
    });

    // process short codes
    let content = pageData.content.replace(
        /\[\[([\s\S]+?)\]\]/gi,
        processShortcodes
    );

    content = md.render(content);
    // console.log(markup);

    // process markdown?
    markup = nunjucks.render(pageData.template, model);

    // process nunjucks?

    console.log(markup);

    return pageData;
}

module.exports = renderPage;
