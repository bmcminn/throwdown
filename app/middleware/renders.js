const _ = require('lodash');
const frontmatter = require('gray-matter');

const path = require('../utils/path.js');
const fs = require('../utils/fs.js');
const Log = require('../utils/log.js');
const Config = require('../config.js');
const nunjucks = require('../utils/nunjucks.js');


/**
 * get post type based on the directory we're storing the file in
 * @param  {string} filepath target filepath
 * @return {string}          name of post type
 */
function getPostType(filepath) {

    let postType = 'page';

    let stringParts = filepath
        .substr(Config.CONTENT_DIR.length + 1)
        .split('/')
        ;

    if (stringParts.length > 1) {
        postType = stringParts[0];
    }

    return postType;
}


function getPublished(content) {

    console.log('getPublished!');

    if (content.hasOwnProperty('draft')) {
        console.log('draft === true');

        return false;
    }

    console.log(content.published);

    let now = Date.now();
    let pubDate = Date.parse(content.published);

    console.log(now, pubDate);

    if (now < pubDate) {
        return false;
    }

    return pubDate;
}


function getRenderPath(filepath) {

    let target = filepath
        .substr(Config.CONTENT_DIR.length + 1)
        .replace(/\.[\w\d]{2,}$/, '')
        ;

    if (target === 'index') {
        target = path.join(Config.PUBLIC_DIR, 'index.html');
    }

    return path.join(Config.PUBLIC_DIR, target, 'index.html');
}


/**
 * Defines the data model for a given post
 * @param  {[type]} filepath [description]
 * @return {[type]}          [description]
 */
function getContent(filepath) {

    let content = fs.read(filepath);

    data = frontmatter(content);

    data = Object.assign(data, content.data);

    delete(data.data);

    // make published date a standard date string
    // TODO: fix published string
    data.published = getPublished(data);

    console.log(data.published);

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

    // TODO: expunge empty data fields

    return data;

}


const renderPage = function(filepath, norender) {

    norender = norender || false;

    let content = getContent(filepath);

    if (norender) {
        return content;
    }

    return content;
};

module.exports = renderPage;
