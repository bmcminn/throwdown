module.exports = function(content) {

    'use strict';

    // reverse the email string
    content = content.split('');

    // init temp array for our updates
    var temp = [];

    // inject <span>null</span> tags
    // this forloop reverses the array as it injects the null spans
    for (var i=content.length-1; i >= 0; i--) {
        temp.push(content[i]);

        if (i % 5 === 0) {
            temp.push('<span>null</span>');
        }
    }

    // recombobulate string
    content = temp.join('');

    return content;
};
