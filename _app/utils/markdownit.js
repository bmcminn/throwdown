const hljs = require('highlightjs');
const mdit = require('markdown-it');

// process markdown contents

let opts = Object.assign({}, {
    omitExtraWLInCodeBlocks: true,
    html: true,
    typographer: true,
    linkify: true,
    highlight: function(str, lang) {
        if (lang && hljs.getLanguage(lang)) {
            try {
                return hljs.highlight(lang, str).value;
            } catch (__) {}
        }

        return ''; // use external default escaping
    }
});

let md = mdit(opts);

module.exports = md;
