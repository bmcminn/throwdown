# Throwdown

> Let's Get Ready to Rumble!!!
> Version: 0.0.1


## Description

Throwdown is a simple flat-file based system that simplifies creating websites.


## Requirements

- PHP 5.4+
- Git/Github
- [Composer](https://getcomposer.org/download/)
- [Node.js/NPM](http://nodejs.org/download/)
- [Bower](https://github.com/bower/bower)


## Installation: Round 1

1. `git clone` this [repo](https://github.com/GiggleboxStudios/Throwdown.git)
2. open a terminal and run the following commands in-order to get Throwdown going:
    - `composer install -o`: installs PHP dependencies
    - `npm install --save-dev`: installs all Node.js dependencies
    - `bower install --save`: installs all theme dependencies
    - `grunt`: this should validate that all of the above steps were run correctly
3. open `config.json` and modify all data relavent to your local/remote servers
4. load up the site in your browser to see the starting homepage!


## Getting Started: Round 2

Provided you followed the steps above and are seeing the demo homepage, congrats! You're ready to rumble!


// TODO: Finish writing the writeup on using this thing :P


## Deploying

When you're ready to deploy your website to your remote server, simply run `grunt deploy` in your terminal and it will autogenerate a production-ready `_dist/` folder that you can upload to your server.

Optionally, you can define FTP credentials in `config.json` and let Grunt deploy your site via FTP.

**NOTE: the FTP configuration data should NOT be compiled into your production source code for your protection. ALWAYS double check that FTP credentials are removed from `_dist/config.json`**
