
const Log = require('../utils/log.js');

let label = 'video';

let processor = function(opts) {

    // @sauce: https://developers.google.com/youtube/player_parameters

    let defaults = {
        url:                null,   // required
        fitvids:            true,   // enable/disable responsive videos
        autoplay:           false,  // enable/disable autoplay
        allowfullscreen:    true,   // enable/disable fullscreen
        showinfo:           true,   // enable/disable
        controls:           true,   //
        loop:               false,  //
    };

    opts = Object.assign(defaults, opts);

    // make opts.url required
    if (!opts.url) {
        let msg = `video shortcode is invalid: missing 'url' value`;
        Log.error(msg);
        return `<!-- ${msg} -->`;
    }

    // default template variables
    opts.wrapperStyle   = '';
    opts.videoStyle     = '';

    //
    if (opts.fitvids) {
        opts.wrapperStyle = [
            'position:relative',
            'padding-bottom:56.25%',
            'height: 0',
            'width: 100%',
        ].join(';');

        opts.videoStyle = [
            'height:100%',
            'width:100%',
            'position:absolute',
            'top:0',
        ].join(';');
    }

    //
    !opts.controls
        ? opts.controls = '&controls=0'
        : opts.controls = ''
        ;

    //
    opts.loop
        ? opts.loop = '&loop=1'
        : opts.loop = ''
        ;

    //
    opts.autoplay
        ? opts.autoplay = 'autoplay;'
        : opts.autoplay = ''
        ;

    //
    !opts.showinfo
        ? opts.showinfo = '&showinfo=0'
        : opts.showinfo = ''
        ;

    //
    opts.allowfullscreen
        ? opts.allowfullscreen = 'webkitallowfullscreen mozallowfullscreen allowfullscreen'
        : opts.allowfullscreen = ''
        ;

    //
    let template = [
        `<div class="video-container" style="${opts.wrapperStyle}">`,
            '<iframe',
                `style="${opts.videoStyle}"`,
                `src="${opts.url}?${opts.showinfo}"`,
                'frameborder="0"',
                `allow="${opts.autoplay}; encrypted-media"`,
                `${opts.allowfullscreen}`,
                '>Your browser does not support iframes</iframe>',
        '</div>',
    ].join(' ');


    return template;
}

module.exports = {
    label:     label,
    processor: processor
};
