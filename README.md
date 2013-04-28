Throwdown (Alpha)
===============

Simple blogging for the tinkers out there.

_**Author:** [@brandtleymcminn](https://twitter.com/brandtleymcminn)_<br>
_Last Updated: April 21, 2013_


Introduction:
-------------

If you've made it this far, please read on in the voice of Cave Johnson, because it makes documentation SO much more fun to read :)

I wrote Throwdown as a way to prove to myself how far I've come as a PHP developer and software designer since I started programming back in 2006.

It's based entirely on my biased opinions of how a proper blogging software should function. That being said, I would like to inform you that this software:

1. is in (Alpha), meaning it doesn't entirely work... (yet).
2. is not for everyone (again, it's [totally biased](http://www.fxnetworks.com/totallybiased)),
3. is not a CMS... it's a CDA... there's a difference.

*[CMS]: Content Management System
*[CDA]: Content Delivery Application

Whats inside?
-------------

To start, there is no database of any sort integrated. None at all. I hate the overhead caused by databases since they make backups and migrations a chore. Plus they smell funny after a while...

Instead I've opted for utilizing a single `cache.json` file to index the sites content. Works like a champ.

More features are detailed below, and if you find anything wrong with any of them, please post an issue to the repo so I can get a fix in for it. Keep testing.

So what can this puppy do?
--------------------------

###Raw file storage
You may be asking yourself, "Cave! If you don't use a database, what DO you use?" Glad you asked. I lemonbombed the UI I had planned and instead used the physical directory system of the server to manage and store my files. Why? What better file management system than a file management system? You terminal buffs may rejoice anytime.

Managing the files locally ensures I know where my files are and can read/write/edit them without having to use a browser or DB interface. Not to mention it's all plain-text data. Go plain-text.


###Directory based categories
Now stay with me on this. Since we use the file system as our storage medium, you can categorize content by placing your content in a sub directory.


###Full-bore Markdown (MD)
This software only uses MD. Why? Because I like MD. It's plain-text, easy to ready, perfect for writing content. I've utilized the [PHP Markdown Extra]() library to parse my beautifully written `.md` files into `HTML` with some nifty bonus features:

- **Syntax Highlighting:** [BeautyOfCode](http://startbigthinksmall.wordpress.com/2008/10/30/beautyofcode-jquery-plugin-for-syntax-highlighting/)
- MORE TO COME SOON!


###Per-File Meta Data
Using [YAML Front Matter](https://github.com/Blaxus/YAML-FrontMatter) you can manage your contents meta data on a per-file basis. You'll soon find this is WAY better than keybanging around in a UI.

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
4. **images:** if you plan to include images in your article, use this directive to point to a specific image directory

You can set the publish date of your content which is used to determine chronology, as well as defer publishing to a later date if you so desire.


###Pretty URLs
This software uses pretty URLs by default because I like them and they're good for SEO. Don't bother changing it because the `.htaccess` file is edited manually and you don't want to anger the server gods.



---

_**NOTE:** These Feature(s) are HIGHLY EXPERIMENTAL!!!_

---

###Local2Remote Sync (maybe...)
Will provide a mechanism to point your localhost instance at your remote server and "push" your local files to it. I think this would be simpler than issuing a deploy via git, but what do I know :P if you wanted to do that I'm sure you could figure it out.


TODO:
-----

- Pages: these will be static content pages different from articles in that they require no `meta` block.

- Post Syndication: posting to Facebook and Twitter (other social networks) is in the pipe, but haven't figured out how that will work just yet.

- Admin interface overlay


CHANGELOG:
----------
