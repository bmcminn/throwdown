/**
 * Node file server
 * @author: https://github.com/phagunbaya
 * @github: https://github.com/phagunbaya/file-server
 */

var fs = require('fs');
var walk = require('walk');
var express = require('express');

var Log = require('./log');

var folder = process.env['FILE_SERVER_PATH'] || './public';
var http_port = parseInt(process.env['FILE_SERVER_PORT']) || 8080;

function start() {
    var app = express();

    app.use(express.static(folder));

    app.get('/', function(req, res, next) {
        var files = [];
        var walker = walk.walk(folder, { followLinks: false });

        walker.on('file', function(root, stat, next) {
            var replacer = folder + '/';
            var subPath = root === folder ? '' : root.replace(replacer, '');

            files.push({
                time: stat.birthtime.getTime(),
                name:
                    subPath.length > 0 ? subPath + '/' + stat.name : stat.name,
                size: stat.size,
            });

            return next();
        });

        walker.on('error', function(err) {
            Log.error('Error getting list of files: ' + err);
            res.status(500).send({ message: 'Internal server error' });
            return next();
        });

        walker.on('end', function() {
            Log.info('Found ' + files.length + ' files');
            res.status(200).send(files);
            return next();
        });
    });

    app.listen(http_port, function() {
        Log.info('Server start at http://localhost:' + http_port);
    });
}

start();
