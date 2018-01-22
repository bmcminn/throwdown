

const helpers = {};



helpers.slugify = (content) => {
    return content.toLowerCase().replace(/\s+/g, '-');

}


module.exports = helpers;
