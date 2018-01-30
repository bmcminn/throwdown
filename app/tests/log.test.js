const Log = require('../utils/log.js');

Log.info('testing', 'multiple', 'arguments');
Log.debug('testing', 'multiple', 'arguments', 1);
Log.warn('testing', 'multiple', 'arguments', true);
Log.error('testing', 'multiple', 'arguments', ['pants', true, 90]);
Log.success(
    'testing',
    'multiple',
    'arguments',
    { pants: true, rad: 12 },
    false,
    90
);
