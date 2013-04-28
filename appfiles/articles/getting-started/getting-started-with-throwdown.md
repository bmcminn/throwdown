---
author: Brandtley McMinn
published: March 21, 2013
tags: cool, pants, tacos
images: custom-images
js: test.js
---


*[YAMLfm]: YAML Front Matter
*[CMS]: Content Management System
*[CDA]: Content Delivery Application



Let me start by saying what this software is not...
---------------------------------------------------

This software is **NOT** a CMS solution. There are plenty of CMS soclutions out there that do a fantastic job, however I do not want my blog managed by a CMS, locked away in a database which makes editing a chore and backing up and converting the data to another system an even bigger headache.

This software is designed to allow you, the writer(s), to store their articles in a consistent folder hierarchy as raw files.

No databases, simple configuration (one `config.json` file to rule them all), makes sense to me :)


Article Meta Data
-----------------
Article meta data is parsed using a system called [YAMLfm](https://github.com/Blaxus/YAML-FrontMatter). Just use the metablock format as described below to set article meta like author, published date and tags categorizing the articles content for indexing later.




```markdown
---
author: Brandtley McMinn
published: March 21, 2013
tags: cool, pants, tacos
images: custom-images
---
```


###Article Title
There is no `title` meta tag. Reason being is that your article title is dirived from the filename of your markdown file.


###Author
This should be pretty self explanitory. But the basic idea behind this field is that you can easily set the author so people can contribute the `.markdown` file and it's ready for you to dump on your server whenever you are.


###Published
The `published` variable is used for two things. Denoting when the article was actually published, OR you can set a future date as the "To-be-published" date and it will automatically be "published" when that date occurs.


###Tags
Use the `tags` variable if you want to categorize the content without having to stuff the article into a specific category. This is useful for SEO purposes if your content covers a few disconnected topics, or if it encopmasses information that is collectively beneficial for the category the article is stored under.


###Images
You can define a special location within your designated images directory.




Article Categories
------------------

There are no `category` tags as well. Reason being is your categories are defined by your `/articles` subdirectory structure. This makes it easy to rename a category and move articles to and from a category using your computers native file system. This also ensures it's easy to find your articles later since they're organized in a categorical heirarchy.


###Sub Categories
Subcategories work much in the same way. If you have a directory of `/articles/awesome-tacos` and you place a directory inside of it, making `/articles/awesome-tacos/fillings`, then you get a sub category of `fillings`.

It's there if you need it but prob won't be used too much.




Writing Your Articles
---------------------
The format of choice for me is Markdown, and is parsed using [Michel Fortin]'s [PHP Markdown Extra] plugin (<abbr title="PHP Markdown Extra">PHPMDE</abbr>)however you can rewrite the software to use whatever format you like. I prefer Markdown so it's the default.

If you want an in-depth tutorial on writing Markdown, I suggest reading from the man himself at [Daring Fireball] for his in-depth write up on Markdown's Spec.


###Anchor Tags
`<a>` tags are generated using standard markdown syntax `[link text](link href)` as expected, however I've modified this version of PHP Markdown Extra to automagically add `target="_blank"` to all links to external pages by default.

This provides the best of both worlds I think. URLs are consistent in that the site continuously refers to itself in the same tab, while related content linked in an article is opened in a new tab for the readers viewing without losing the original context. Debate me as you may about this, but if you really don't like it, you can change this in the `config.json` file.


###Headings (h1-h6)
Headings are defined per the spec, however I've modified <abbr title="PHP Markdown Extra">PHPMDE</abbr> even further to include built-in anchors to each heading, similar to how Github does their thing.


Syntax Highlighting
---------------------

Thanks to the awesome work of [Lars Corneliussen] Reference [Awesomeness](#wfoodk) code highlighting is possible by default and all you have to do is define what the language is and configure your install to use a specific syntax highlighting stylesheet.

```html
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Example Code Block</title>
  </head>
  <body>
    <!-- Content here... -->
  </body>
</html>
```




COMING SOON!!!
--------------

###Image Galleries
Image galleries are pretty simple (and awesome :). They work like `/categories`, except you place all your gallery images into a single directory within the `/images` directory and then link to that folder. The software automagically parses the URL to build a gallery view of that directory. Optionally you can define some meta data on the image files themselves to generate meta content viewed in the gallery.

You may also create a `gallery.json` meta file which will provide some basic meta data (eg: tags, description, name, location, copyright, etc)

The meta file can be generated automagically


[YAML Front Matter]: https://github.com/Blaxus/YAML-FrontMatter
[Lars Corneliussen]: http://startbigthinksmall.wordpress.com/2008/10/30/beautyofcode-jquery-plugin-for-syntax-highlighting/
[Daring Fireball]: http://daringfireball.net/projects/markdown/
[Michel Fortin]: http://michelf.ca/home/
[PHP Markdown Extra]: http://michelf.ca/projects/php-markdown/extra/
