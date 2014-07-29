var _           = require('lodash')
  , path        = require('path')
  // , minify.json = require('node-json-minify')
  ;

JSON.minify = JSON.minify || require("node-json-minify");

module.exports = function(grunt) {

  grunt.initConfig({

    jsonlint: {
      theme_json: {
        src: [
          'config.json',
          'public/**/*.json'
        ]
      }
    },


    bowercopy: {
      options: {
        srcPrefix: 'bower_components'
      }

    , js: {
        options: { destPrefix: 'public/js/vendor' }
      , files: {
          'slick.js': 'slick-carousel/slick/slick.js',
          'jquery.js': 'jquery/dist/jquery.min.js'
        }
      }

    , less: {
        options: { destPrefix: 'public/less/vendor' }
      , files: {
          '_normalize.less': 'normalize-less/normalize.less',
          'font-awesome/': 'fontawesome/less/*.less'
        }
      }

    , img: {
        options: { destPrefix: 'public/images' }
      , files: {
          'ajax-loader.gif': 'slick-carousel/slick/ajax-loader.gif'
        }
      }

    , fonts: {
        options: { destPrefix: 'public/fonts' }
      , files: {
          '.': 'fontawesome/fonts/*',
          './': 'slick-carousel/slick/fonts/*'
        }
      }

    , php: {
        options: { destPrefix: 'app/' }
      , files: {
          'minify.json.php': 'jsonMinify/minify.json.php'
        }
      }
    },



    recess: {
      theme_files: {
        options: {
          compile: false,
          noIDs: false,
          noJSPrefix: false,
          zeroUnits: false,
          noUniversalSelectors: false,
          noUnderscores: false,
          strictPropertyOrder: false,
          noOverqualifying: false
        },
        src: ['public/less/main.less']
      }
    },


    less: {
      development: {
        options: {
          paths: ['stylesheets']
        },
        files: {
          'public/css/main.css': 'public/less/main.less'
        }
      }
    },


    autoprefixer: {
      development: {
        src: 'public/less/main.css',
        dest: 'public/less/main.css'
      }
    },


    jshint: {
      theme_js: [
        'gruntfile.js',
        'public/js/**/*.js'
      ],
      options: {
        ignores: [
          'public/js/vendor/**/*.js'
        ],
        undef: true,
        eqnull: true,
        boss: true,
        laxbreak: true,
        laxcomma: true,
        unused: false,
        globals: {
          jQuery: true,
          underscore: true,
          navigator: true,
          $: true,
          _: true,
          console: true,
          window: true,
          document: true,
          setTimeout: true,
          clearTimeout: true,
          module: true,
          define: true,
          require: true,
          process: true,
          Modernizr: true
        }
      }
    },



    watch: {

      json: {
        files: [
          'config.json',
          'public/**/*.json'
        ],
        tasks: ['jsonlint']
      },

      css: {
        files: [
          'public/less/**/*.less'
        ],
        tasks: ['recess', 'less', 'autoprefixer'],
        options: {
          livereload: true
        }
      },

      javascript: {
        files: [
          'gruntfile.js',
          'scripts/**/*.js'
        ],
        tasks: ['jshint']
      }

    },


    major: { files: ['./package.json', './bower.json'] },
    minor: { files: ['./package.json', './bower.json'] },
    patch: { files: ['./package.json', './bower.json'] },
    resetVersion: { files: ['./package.json', './bower.json'] }

  });


  /**
   * [updateVersion description]
   * @param  {[type]} itemIndex [description]
   * @param  {[type]} target    [description]
   * @return {[type]}           [description]
   */
  function updateVersion(itemIndex, target) {

    var fileVersion = null; // fileVersion gets used as a flag so we're not constantly writing the value of fileVersion

    _.each(target, function(value, index) {
      var fileLoc   = value
        , fileData  = JSON.parse(grunt.file.read(fileLoc))
        , version   = null
        ;

      if (value.match(/theme\.json/)) {
        version = fileData.about.version.split('.');
      } else {
        version = fileData.version.split('.');
      }

      grunt.log.writeln('updating: ' + value);
      version[itemIndex] = parseInt(version[itemIndex]) + 1;


      if (value.match(/theme\.json/)) {
        fileData.about.version = version.join('.');
      } else {
        fileData.version = version.join('.');
      }

      if (!fileVersion) {
        fileVersion = version.join('.');
      }
      grunt.file.write(path.resolve(process.cwd(), fileLoc.toString()), JSON.stringify(fileData, null, 2));
    });
    grunt.log.ok('Version: ' + fileVersion);
  }



  grunt.registerMultiTask('major', 'Issue a major revision update.', function() {
    updateVersion(0, this.data);
  });


  grunt.registerMultiTask('minor', 'Issue a minor revision update.', function() {
    updateVersion(1, this.data);
  });


  grunt.registerMultiTask('patch', 'Issue a patch revision update.', function() {
    updateVersion(2, this.data);
  });


  grunt.registerMultiTask('resetVersion', 'Reset the version number of repo.', function() {
    var fileVersion = '0.0.1';

    _.each(this.data, function(value, index) {
      var fileLoc   = value
        , fileData  = JSON.parse(grunt.file.read(fileLoc))
        ;
      grunt.log.writeln('resetting version: ' + value);

      if (value.match(/theme\.json/)) {
        fileData.about.version = fileVersion;
      } else {
        fileData.version = fileVersion;
      }

      // fileData.version = fileVersion;
      grunt.file.write(path.resolve(process.cwd(), fileLoc.toString()), JSON.stringify(fileData, null, 2));
    });
    grunt.log.ok('Version: ' + fileVersion);
  });


  grunt.loadNpmTasks('grunt-jsonlint');
  grunt.loadNpmTasks('grunt-recess');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compress');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-search');
  grunt.loadNpmTasks('grunt-bowercopy');
  grunt.loadNpmTasks('grunt-bower-install-simple');


  grunt.registerTask('default', [ 'jsonlint', 'jshint', 'recess', 'less', 'autoprefixer', 'compress' ]);
  grunt.registerTask('build',   [ 'jsonlint', 'jshint', 'compress' ]);
  grunt.registerTask('release-patch', [ 'jsonlint', 'jshint', 'patch', 'compress' ]);
  grunt.registerTask('release-minor', [ 'jsonlint', 'jshint', /* 'search:dumptag', */ 'minor', 'compress' ]);
  grunt.registerTask('release-major', [ 'jsonlint', 'jshint', /* 'search:dumptag', */ 'major', 'compress' ]);
  grunt.registerTask('bower',   [ 'bower-install-simple', 'bowercopy' ]);

};
