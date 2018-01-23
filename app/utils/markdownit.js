const hljs = require('highlightjs');
const mdit = require('markdown-it');

// process markdown contents

let options = Object.assign({}, { omitExtraWLInCodeBlocks: true });

// update our markdown instance
options.highlight = function(str, lang) {
    if (lang && hljs.getLanguage(lang)) {
        try {
            return hljs.highlight(lang, str).value;
        } catch (__) {}
    }

    return ''; // use external default escaping
};

module.exports = mdit(options);
