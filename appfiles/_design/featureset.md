REFERENCE:
    http://www.phrozn.info/en/
    http://net.tutsplus.com/tutorials/other/using-htaccess-files-for-pretty-urls/


BLOG CONFIGURATION
- Blog is configured by using a single config.JSON file
- Config would include fields like
    - Blog name
    - Google Analytics codes (top, bottom... make this customizable somehow, via plugin modules?)
    - Twitter name (for new post integration)
    - ...


TOOLS
- PHP 5.3+
- Uses Zepto/jQuery for interaction
- Only uses a feed/newsletter subscription mechanic.
- Use EdenPHP mail module
- fitvids.js for video resizing
- NO COMMENTS... Maybe Disqus integration...
- Post new article link via Twitter
- ...


ARTICLE STORAGE
- Articles are stored in categories (directories) as MD files
- MD files contain meta data to be parsed when the file is accessed by the system - https://github.com/Blaxus/YAML-FrontMatter
- Meta data includes tags: desc: author:
- PHP uses modtime and createtime file meta to denote publish/update timestamps
- MD filenames contain "post date" ex: 03-02-2012|post-title-heiphenated.md
    - serves two purposes
        1. ensures file date created meta conflicts/updates dont ruin chronology
        2. allows easy finding of files created dates in local/remote folder system


FUNCTIONALITY
- Sitemap is updated via nightly cronjob
- Newsletter email notices are news blasted nightly via cronjob
- Subscriber data is written to server as JSON data
- Optional plugin capability?
- System generates obligatory sitemap.xml file for google indexing
- System uses role="" and data-widget="" attributes to define where markup should be placed


CONSIDERATIONS
- Single page app format
- No admin section
- Only admin style deal is to view site stats
- "/Articles" directory in main is where articles are stored
- Setup "paged" delimiter to create "paged" content when MD is parsed
- Setup `<code>` blocks to be parsed similar to github md files using ```
- Syntax highlighting via (research this)
- Deployment via github?


PROPOSED FOLDER HIERARCHY

- /hostroot
    .htaccess                             // obligatory .htaccess to control app file access
    config.json                           // entire site config is store in this file (.htaccess block is required on this file)
    index.php                             // contains main class, handles routes and such

    humans.txt                            // credits myself (the creator) and all peoples and softwares the collectively made "BLOGSYSTEMNAMEHERE"

    template.html                         // raw template file the system uses to build its views

    /app                                  // app related functionality defined in this folder

    /plugins                              // isolate plugin files to a directory outside the /app folder
                                          // would require an interface script the system uses to run plugins...
                                          //   ex: /app/plugins.php comes to mind...

    /css
        styles.css                        // compiled template styles are minified here
        /less                             // system is built using LESS/SASS located in here
        /articles                         // this folder allows for custom "per article" style sheets)
            article-name-here.css         // custom article CSS

    /img                                  // template/theme assets go in here

    /js                                   // just what is says :P
        app.dev.js                        // development app.js file
        app.min.js                        // minified/built app.js file
        /libs
            jquery.min.js                 // latest jQuery build (minified of course)

    /articles
        articles.cache.json               // the system builds a cache of all meta data (tags, cats and search specifically; for quick reference without processing ALL directories each page load)

        /category-name                    // categories are defined as folders inside /articles
            02-03-2013|article-name.md    // articles names are prefixed with a date string, and article names are heiphenated denoted by a pipe character
            /images                       // each category has a contextual image directory for its respective articles
