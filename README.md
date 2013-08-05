# Throwdown (Alpha, 0.2)

A simple and flexible flat file system for the tinkerers out there.

_**Author:** [@brandtleymcminn](https://twitter.com/brandtleymcminn)_<br>
_Last Updated: August 5, 2013_



## TL;DR. Quickstart Guide:

1. To get started, copy the directory into the root system directory of your Localhost.
2. Open a terminal program and navigate to your projects directory
3. Run `composer install` on the directory and wait for composer to finish installing system dependencies

Have fun :)



## **Congratulations** \*Confetti and horn noises\*

And welcome to Throwdown! A powerful and flexible flat file CMS developed using PHP and consumes nothing but good ole' wholesome JSON and Markdown!

Now I know what you're thinking, this just sounds like another PHP library with a predisposition for voilence, but it really is more than that.

I've worked with the best of them. WordPress, Drupal, Blogger... but they all have one thing in common. They try too hard, thus I'm working too hard to make these systems do what I want within a sandboxed context using someone else' API(s). I needed a system that worked as I expected it to, that was efficient to get started with and easy to update as needed. So I wrote Throwdown and tailored it to my exacting specifications, because my clients don't need today's "modern CMS", they need a website that's built on a future focused platform.

But I won't get ahead of myself here...


## It works alright, but there's still more to be done...

I'm not satisfied with everything about this system yet. I have a whole slew of AWESOME features in mind that I think will be absolutely killer when implemented properly, but for now I'll just glaze over some of the highlights so far:



### Simple system configuration/installation

- The system is configured via the `config.json` file located in the root directory.
    ```json
    {
      "default_template":       "default.php"           // fallback template in the event a pages defined template does not exist
    , "default_homepage":       "home"                  // specify a different homepage, other than the default.md page
    , "current_theme":          "testing"               // enable a specific theme. there is no fallback for this yet

    , "site_name":              "Throwdown CMS"         // specifies the sitename rendered on a given views' `<title>` tag
    , "site_name_legal":        "Throwdown CMS"         // specifies a system constant you can use to change the legal name used in `/terms` and `/privacy` page files

    , "site_footer_copyright":  "Throwdown CMS, LLC."   // specifies a system constant you can use when rendering the footer copyright section


    //
    // Define your own custom things here for later use if you like
    //

    }
    ```


### Pretty URLs by default
- Pages are created and accessed by the URL structure of your site
- The system will parse hyphens or underscores out of the `page/article.md` file name as space delimiters automagically.
    - Use whatever is comfortable for you and stick with it... consistency is key
- `http://yoursitename.com/pagename` will request the `/pages/pagename.md` file which tells the system which template to load a specific template file, located inside the currently enabled theme.
- `http://yoursitename.com/articles` will request the `/articles/index.php` script and subsequent directories in the URL request string will request a given article.md file
- **NOTE:** if a given request URL references a Markdown file that does not exist in the `/pages` directory for any given context, the system will return a 404 error, which is also managed via a `404.md` file with a corresponding `404.php` template.
- **NOTE:** if a given request URL does exist and the template defined for that file does not exist in the currently enabled theme, then the system will default to the `default.php` template
    - _**The `default.php` template is required as per Theme development guidelines.**_


### Simple theme construction
- Themes are added to the `/templates`
- You may enable a theme by copying its folder name exactly and using it as the argument within `config.json`



As I set more things up, I'll probably re-cajigure a bunch of things here and there and better document the things that currently work. As it stands, I still need to document the template functions file and just about everything else located in the `/app` directory.

More stuff coming soon :)



## As always, Submit issues if you find any!

I know there isn't a whole lot to go on right now, but please bear with me... I'll do my best to support any and all [issues submitted](https://github.com/GiggleboxStudios/Throwdown/issues) via Github.



## LICENSE &ndash; [/LICENSE](https://github.com/GiggleboxStudios/Throwdown/blob/master/LICENSE)

## TODO/Change Log &ndash; [/TODO](https://github.com/GiggleboxStudios/Throwdown/TODO)