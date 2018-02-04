const nunjucks = require('../utils/nunjucks.js')(['./theme/views'], {});

let test1 = nunjucks.renderString('{{ testing }}', { testing: 'hello, i\'m a test' });

console.log(test1);


console.log('--------------------------');


let test2 = nunjucks.render('default', { content: 'help' });

console.log(test2);


