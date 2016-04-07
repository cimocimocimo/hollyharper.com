jQuery(function($){
    // get the string of classes from the body element
    $bodyClasses = $('body').attr('class');

    // test for the location based classes that are added by wordpress
    // then run the code for the cycle slideshow on the appropriate page
    if ($bodyClasses.indexOf('home') != -1) {

        $('.listing-title-price').addClass('add-nav-space');

        $('#featured-listings').append(
            '<a href="#" class="prev">&lt;</a><a href="#" class="next">&gt;</a>'
        );

        $('.slideshow').cycle({
            fx: 'fade',
            timeout: '4000',
            speed: '2000',
            next: '.next',
            prev: '.prev',
            pause: 'true',
            fastOnEvent: '200'
        });

    } else if ($bodyClasses.indexOf('single') !== -1) {

        $('.pager').append(
            '<a href="#" class="prev">&lt;</a><a href="#" class="next">&gt;</a>'
        );

        $('.slideshow').cycle({
            fx: 'fade',
            timeout: '4000',
            speed: '2000',
            next: '.next',
            prev: '.prev',
            pager: '.pager-imgs',
            fastOnEvent: '200',
            pause: 1,

            // callback fn that creates a thumbnail to use as pager anchor
            // the order of the thumbs and the slides come from the same object that was sorted earlier
            pagerAnchorBuilder: function(idx, slide) {
                var pagerImg = $('#pager-img-' + idx ).remove().html();

                return '<div id="#pager-img-' + idx + '"><a href="#">' + pagerImg + '</a></div>';
            }
        });

        $('#listing-gallery').hover(
            function(){
                $('.pager').stop(true, true).delay(200).fadeIn();
            },
            function(){
                $('.pager').stop(true, true).fadeOut();
            }
        );

        $('.pager').hover(
            function(){
                $('.slideshow').cycle('pause');
            },
            function(){
                $('.slideshow').cycle('resume');
            }
        );
    } // end if
});
