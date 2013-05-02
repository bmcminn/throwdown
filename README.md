Throwdown (Alpha)
=================

Simple blogging for the tinkerers out there.

_**Author:** [@brandtleymcminn](https://twitter.com/brandtleymcminn)_<br>
_Last Updated: May 1, 2013_


Introduction:
-------------

If you've made it this far, then Congratulations *Confetti and horn noises* You've selected one of the premier products offered by GiggleboxStudios, namely Throwdown. Now I know what you're thinking, this just sounds like another PHP library with a voilent connotation, but it's more than that.

I wrote Throwdown as a way to prove to myself how far I've come as a PHP developer and software designer since I started programming back in 2006 and
it's based entirely on my biased opinions of how a proper blogging software should function.

I've worked with the best of them. WordPress, Drupal, Blogger... but they all have one thing in common. They try too hard, thus I try too hard to do what I want which is writing.

That being said, I would like to inform you that this software:

1. is in (Alpha), meaning it doesn't entirely work... (yet).
2. is not for everyone (again, it's [totally biased](http://www.fxnetworks.com/totallybiased) and may not fit your style or mindset),
3. is not a CMS... it's a CDA... there's a difference.

*[CMS]: Content Management System
*[CDA]: Content Delivery Application


Whats inside?
-------------

To start, there is no database of any sort integrated. Took it out completely. I hate the overhead caused by databases since they make backups and migrations a chore. Plus they start to smell a little funky after a while...

Instead I've opted for utilizing a single `cache.json` file to index the sites content. Works like a champ.

More features are detailed below, but if you find yourself experience sudden excitement, shortness of breath, constant astonishment or a sudden wettness in your ears, that's not part of the test. But you should still try this thing out anyway. Keep testing.

If you find something that seems wierd, check the manual (README.md) but for more serious inquiries or bug(s) reports, confirm it in the [Issues](https://github.com/GiggleboxStudios/Throwdown/issues) section and I'll be sure to check up on it.


So what can this puppy do?
--------------------------

###Stupid Simple&trade; Installation
The install is so easy it makes WordPress look like a nub. All you do is fill in the information as requested and BAM! You're ready to start writing.

This step is the only real automation you'll encounter when using this script, but it helps to jumpstart your `config.json` setup without me explaining how to do so.


###Raw file storage
You may be asking yourself, "If I don't use a database, what DO I use?" Glad you asked. I lemonbombed the UI I had planned and instead used the physical directory system of the server to manage and store my files. Why? What better file management system than a file management system? You terminal buffs may rejoice at anytime.

Managing the files locally ensures I know where my files are and can read/write/edit them without having to use a browser or DB interface. Not to mention it's all plain-text data. Go plain-text.


###Directory based categories
Now stay with me on this, but since you use the file system as your storage and management, you can categorize content by placing your content in a sub directory. So those of you who like to categorize your articles in different directories may feel right at home with this idea. Here's a -crude- demo of what I'm talking about:

```
  /articles
    - article-title-here.md
    /kittens
      - article-about-kittens.md
    /sriracha
      - article-about-sriracha-being-delicious.md
      - possibly-a-recipe-to-make-something-with-sriracha.md
```

The possibilities are endless, and if you ever manage to find your content in a dimension where Sriracha is King Condoment, your SEO is probably through the roof with this system. Your welcome.


###Full-bore Markdown (MD)
This software only uses MD. Why? Because I like MD. It's plain-text, easy to ready, perfect for writing content. I've utilized the [PHP Markdown Extra]() library to parse my beautifully written `.md` files into `HTML` with some nifty bonus features:

- **Syntax Highlighting:** [BeautyOfCode](http://startbigthinksmall.wordpress.com/2008/10/30/beautyofcode-jquery-plugin-for-syntax-highlighting/)
- MORE TO COME SOON!


###Per-File Meta Data
Using [YAML Front Matter](https://github.com/Blaxus/YAML-FrontMatter) you can manage your articles meta data on a per-file basis. You'll soon find this is WAY better than keybanging around in a UI.

```markdown
---
author: Brandtley McMinn
published: March 21, 2013
tags: cool, pants, tacos
images: custom-images
---
```

1. **author:** can be used to denote who wrote the article, if other than yourself.
2. **publish:** Set the publish date so people know when it was published. Optionally if you set a future date, the system will know to publish this article then.
3. **tags:** your content like you want. Tags are comma separated and can be accessed via the `/tags/` directory.
4. **images:** if you plan to include images in your article, use this directive to point to a specific image directory.
5. Even add your own tags if you want, the system won't use them by default but you can make use of it in a [plugin](#plugins-maybe) if needed.

You can set the publish date of your content which is used to determine chronology, as well as defer publishing to a later date if you so desire.


###Pretty URLs
This software uses pretty URLs by default because I like them and they're good for SEO. Don't bother changing it because the `.htaccess` file is edited manually and you don't want to anger the server gods.


###Simple Theming Capability
Took a page from the [Tumblr]() boys in that the theme template is nothing more than a one-page `.html` file. This provides ALL possible markup scenarios for various content types and is parsed using [PHPQuery]().


---

_**NOTE: These Feature(s) are HIGHLY EXPERIMENTAL!!!**_

---

###Simple Theme Extensions/Plugins
These "Plugins" are installed by dropping the file(s) into the `/plugins` directory which "enables" them. Remove them by deleting the respective file or prefixing it with an underscore; ex: `_disabled-plugin-file.php`

Plugins are my way of giving you some kind of voice in this wacky system I built. Albeit a tad "unstructured" you can basically dump any plugin file into the `/plugins` directory and let the system "have at it". **More on this later...**



###Local2Remote Sync (maybe...)
Will provide a mechanism to point your localhost instance at your remote server and "push" your local files to it. I think this would be simpler than issuing a deploy via git, but what do I know :P if you wanted to do that I'm sure you could figure it out.


TODO:
-----

- Pages: these will be static content pages different from articles in that they require no `meta` block.

- Post Syndication: posting to Facebook and Twitter (other social networks) is in the pipe, but haven't figured out how that will work just yet.

- Admin interface overlay; including:
    - Cache generation
    - Remote sync init
    - "Active" plugins list


CHANGELOG:
----------

###MAY 2013
- 05/01/2013
    * Updated `install.php` to include some basic design and instructions.
    * Added form markup to `install.php` -- implementing processing soon.
    * Updated README.md to reflect some updates in process and overall structure of the app.

###APRIL 2013
- 04/28/2013
    * Finalized functionality of `install.php` and have started coding it
- 04/27/2013
    * Started hashing out functionality of `install.php`
