/*
 * jQuery Popeye 0.2.1 - http://dev.herr-schuessler.de/jquery/popeye/
 *
 * converts HTML image list in image gallery with inline enlargement
 *
 * Copyright (C) 2008 Christoph Schuessler (schreib@herr-schuessler.de)
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 */
(function ($publisher) {

    
    ////////////////////////////////////////////////////////////////////////////
    //
    // $publisher.fn.popeye
    // popeye definition
    //
    ////////////////////////////////////////////////////////////////////////////
    $publisher.fn.popeye = function (options) {
    
        // set context vars
        //----------------------------------------------------------------------
        var obj = $publisher(this);
        var enPlaceholder = $publisher('<div />');
                   
        
        // build main options before element iteration
        //----------------------------------------------------------------------
        var opts = $publisher.extend({}, $publisher.fn.popeye.defaults, options);
        
        
        // firebug console output
        //----------------------------------------------------------------------
        function debug(text) {
            if (window.console && window.console.log) {
                window.console.log(text);
            }
        };
             

        ////////////////////////////////////////////////////////////////////////
        //
        // -> init
        // apply popeye to all calling instances
        //
        ////////////////////////////////////////////////////////////////////////
        return this.each(function(){
            
            
            ////////////////////////////////////////////////////////////////////////
            //
            // $publisher.fn.popeye.display
            // display thumbnail on stage, update toolbar
            //
            ////////////////////////////////////////////////////////////////////////
            function display(i, transition) {
                                
                // optional parameter transition
                transition = transition || false;
                
                
                // set selected image as background image of stage
                //------------------------------------------------------------------
                var stageIm = {
                    backgroundImage:    'url(' + im.small[i] + ')',
                    backgroundPosition: 'center'
                };
                //if set, show transition on change of image
                if(transition) {
                    ppyStage.fadeTo(100,0,function(){
                        $publisher(this).css(stageIm).fadeTo(100,1);
                    });
                }
                else {
                    ppyStage.css(stageIm);
                }

                
                // update image info area
                //------------------------------------------------------------------

                var light = '<a href="' + im.small[i] + '" rel="item-lightbox"><img src="' + im.small[i] + '" width="'+ im.newWidth[i] +'" height="'+ im.newHeight[i] +'" /></a>';
                ppyStageImg.html(light);

                ppyCap.html(im.title[i]);        // caption
                ppyTotal.text(' ' + tot);        // total images
                ppyCur.text((cur + 1) + ' ');    // current image number

                $publisher('a[rel*=item-lightbox]').lightBox({
                    overlayBgColor: '#000',
                    overlayOpacity: 0.6,
                    imageLoading: 'images/lightbox-ico-loading.gif',
                    imageBtnClose: 'images/close.gif',
                    imageBtnPrev: 'images/prev.gif',
                    imageBtnNext: 'images/next.gif',
                    containerResizeSpeed: 800,
                    fixedNavigation: true,
                    txtImage: 'Image',
                    txtOf: 'of'
	           });
            };
            
            
            ////////////////////////////////////////////////////////////////////////
            //
            // do stuff
            //
            ////////////////////////////////////////////////////////////////////////
            
            
            // popeye vars
            //------------------------------------------------------------------
            //define image object arrays
            var im  = {
                small: [],
                title: [],
                large: [],
                width: [],
                height: [],
                newWidth: [],
                newHeight: []
            };
            
            var maxWidth = 300;
            var maxHeight = 300;
            var ratio = 0;

            if(opts.stageW) {
                maxWidth = opts.stageW;
            }

            if(opts.stageH) {
                maxHeight = opts.stageH;
            }

            obj.find('li').each(function(i){


                im.small[i] = $publisher(this).find('img').attr('src');   // the thumbnail url
                im.title[i] = $publisher(this).find('img').attr('alt');   // the image title
                im.large[i] = $publisher(this).find('a').attr('href');    // the image url


                var img = new Image();
                img.src = im.large[i];
                im.width[i] = img.width;
                im.height[i] = img.height;

                if (im.width[i] == 0) {
                    im.width[i] = $publisher(this).find('img').attr('width');       // the image width
                    im.height[i] = $publisher(this).find('img').attr('height');     // the image height
                }

                if (im.width[i] == 0) {
                    im.width[i] = $publisher(this).find('img').width();      // the image width
                    im.height[i] = $publisher(this).find('img').height();   // the image height
                }

                if (im.width[i] > maxWidth) {
                    im.newWidth[i] = maxWidth;
                    ratio = parseInt(maxWidth/im.width[i]*100);
                } else {
                    im.newWidth[i] = im.width[i];
                    ratio = 100;
                }

                im.newHeight[i] = parseInt(im.height[i] * ratio/100);
                
                if (im.newHeight[i] > maxHeight) {
                    ratio = parseInt(maxHeight/im.newHeight[i]*100);
                    im.newHeight[i] = maxHeight;
                    im.newWidth[i] = parseInt(im.newWidth[i] * ratio/100);
                }

            });

            var cur = 0;                 // array index of currently displayed image
            var tot = im.small.length;   // total number of images
            
            
            // popeye dom setup
            //------------------------------------------------------------------
            
            // dispose of original image list
            obj.find('ul').remove();
            
            // crate html nodes
            var ppyStageWrap = $publisher('<div class="popeye-stagewrap" style="text-align:center;"/>');
            var ppyStage     = $publisher('<div class="popeye-stage" />');
            var ppyStageImg  = $publisher('<div class="popeye-stage-img" style="height:' + maxHeight + 'px; width:' + maxWidth + 'px"/>');
            var ppyToolsWrap = $publisher('<div class="popeye-tools-wrap" />');
            var ppyTools     = $publisher('<div class="popeye-tools" />');
            var ppyCount     = $publisher('<span class="popeye-count" />');
            var ppyCur       = $publisher('<em class="popeye-cur" />');
            var ppyTotal     = $publisher('<em class="popeye-total" />');
            var ppyPrev      = $publisher('<a href="#" class="popeye-prev">&nbsp;</a>');  /*' + opts.plabel + '*/
            var ppyNext      = $publisher('<a href="#" class="popeye-next">&nbsp;</a>');  /*' + opts.nlabel + '  */
            //var ppyEnlarge   = $publisher('<a href="#" class="popeye-enlarge">' + opts.blabel + '</a>');
            var ppyCap       = $publisher('<div class="popeye-cap" />');
            
            // build DOM tree
            obj.append(ppyStageWrap);
            ppyStageWrap.append(ppyStageImg);
            
            ppyStageWrap.after(ppyToolsWrap);

            ppyToolsWrap.append(ppyCap);

            if (tot > 1) {
                ppyToolsWrap.append(ppyTools);
                ppyTools.append(ppyPrev);
                ppyTools.append(ppyCount);
                ppyCount.append(ppyCur);
                ppyCount.append(ppyTotal);
                ppyCur.after(opts.oflabel);
                ppyTools.append(ppyNext);
           }
    
            // popeye css setup
            //------------------------------------------------------------------
            var cssCompactPpy = {
                position:       'relative',
                overflow:       'hidden',
                height:         'auto',         //overwrite fallback height restrictons
                overflow:       'hidden',       //remove scrolling behaviour
                top:            0
            };
            
            // css for right or left orientation
            if (opts.direction == 'left') {
                cssCompactPpy.left = 0;
            }
            else if (opts.direction == 'right') {
                cssCompactPpy.right = 0;
            }
            
            // set stage dims
            var cssCompactStage = {
                width:          maxWidth,
                height:         maxHeight
            };
            
            // set caption width to stage width
            var cssPpyCap = {
                width:          maxWidth 
            };
            
            // set toolbar width to stage width (IE doesn't recognize css auto width...)
            var ppyToolsWidth = parseInt(maxWidth);
            if( !isNaN( parseInt(ppyTools.css('borderLeftWidth'),10))) {
                ppyToolsWidth = ppyToolsWidth - parseInt(ppyTools.css('borderLeftWidth'), 10);
            }
            if( !isNaN( parseInt(ppyTools.css('borderRightWidth'),10))) {
                ppyToolsWidth = ppyToolsWidth - parseInt(ppyTools.css('borderRightWidth'),10);
            }
            ppyToolsWidth = ppyToolsWidth - parseInt(ppyTools.css('paddingLeft'),10);
            ppyToolsWidth = ppyToolsWidth - parseInt(ppyTools.css('paddingRight'),10);
            if( !isNaN( parseInt(ppyTools.css('marginLeft'),10))) {
                ppyToolsWidth = ppyToolsWidth - parseInt(ppyTools.css('marginLeft'),10);
            }
            if( !isNaN( parseInt(ppyTools.css('marginRight'),10))) {
                ppyToolsWidth = ppyToolsWidth - parseInt(ppyTools.css('marginRight'),10);
            }
            ppyToolsWidth = ppyToolsWidth + 'px';
            
            var cssPpyTools = {
                width:       ppyToolsWidth  
            };

            // style popeye
            obj.css(cssCompactPpy);
            if(opts.jclass) {
                obj.addClass(opts.jclass);
            }
            ppyStage.css(cssCompactStage);
            ppyCap.css(cssPpyCap);
            ppyTools.css(cssPpyTools);
            
            // display first image
            display(cur);

            
            // event handlers
            //------------------------------------------------------------------
            
            // previous image button
            ppyPrev.click(function(){
                if( cur <= 0 ) {
                    cur = tot - 1;
                } else {
                    cur--;
                }
                display(cur, true);
                return false;
            });
            // next image button
            ppyNext.click(function(){
                if( cur < ( tot - 1) ) {
                    cur++; 
                } else {
                    cur = 0;
                }
                display(cur, true);
                return false;
            });
            // enlarge image button
           /* ppyEnlarge.click(function(){
                ppyStage.unbind();
                enlarge(cur);
                return false;
            });   */
            
            
        });
    };
    
    ////////////////////////////////////////////////////////////////////////////
    //
    // $publisher.fn.popeye.defaults
    // set default  options
    //
    ////////////////////////////////////////////////////////////////////////////
    $publisher.fn.popeye.defaults = {
        jclass:     'popeye-hasjs',    //class to be applied to popeye-box when the browser has activated JavaScript (to overwrite fallback styling)
        eclass:     'popeye-haspopped', //class to be applied to enlarged popeye-box
        lclass:     'popeye-isloading',  //class to be applied to stage while loading image
        direction:  'left',            //direction that popeye-box opens, can be "left" or "right"
        duration:   400,               //duration of transitional effect when enlarging or closing the box
        easing:     'swing',           //easing type, can be 'swing', 'linear' or any of jQuery Easing Plugin types (Plugin required)
        nlabel:     'next',            //label for next button
        plabel:     'previous',        //label for previous button
        oflabel:    'of',              //label for image count text (e.g. 1 of 14)
        blabel:     'enlarge',         //label for enlarge button
        clabel:     'Click to close'   //tooltip on enlarged image (click image to close)

    };
    
// end of closure, bind to jQuery Object
})(jQuery); 
