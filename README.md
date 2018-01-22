# Throwdown

Version: `2.0.0 alpha`

> Putting your content into submission

## About Throwdown

Throwdown is a simple flat-file CMS/static site generator that consumes nothing but good ole' wholesome Markdown! Completely extensible and customizable as you see fit.

### Requirements

* Node.js `v7.0.0+`

### Powered by:

* [Node.js](http://nodejs.org/) and [NPM](http://npmjs.org/)
* [jvent](https://github.com/pazguille/jvent)
* SQLite
* JSON & YAML

### App Folder Structure:

```
- /app
    - /app/assets
    - /app/cache
    - /app/middleware
    - /app/migrations
    - /app/utilities
    - /app/views
- /content
- /public
```

* `/app`: Contains all throwdown related components
* `/app/assets`: Contains all CSS, JS, images, etc for the site
* `/app/cache`: A catch-all cache folder for logs and other generated content
* `/app/middleware`: These are the actual components that drive how your site is generated
* `/app/migrations`: Contains all task-based utilities for you to manage your throwdown site
* `/app/utilities`: Contains all generic utility components used throughout the application
* `/app/views`: Contains all your template/view files
* `/content`: Houses your site content files
* `/public`: The folder where your site lives during development _(doubles as a deploy source for FTP upload)_

## Getting started:

> Coming soon!
