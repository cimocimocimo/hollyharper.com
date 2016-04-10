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

var mondrian = (function($, windowPageData){

    var pageData = null,
        pageTemplate = null;

    // helper functions
    function extendsObject(child, parent){
        child.prototype = Object.create(parent.prototype);
    }

    // Constructors
    function PageData(data){
        this.data = data;

        // TODO add way for loading in the Handlebars templates and other jQuery objects needed
        // this is something that could be useful for all templates
    }
    PageData.prototype.isSingle = function(){
        return this.data.isSingle;
    }
    PageData.prototype.isArchive = function(){
        return this.data.isArchive;
    }
    PageData.prototype.isHome = function(){
        return this.data.isHome;
    }
    PageData.prototype.isTemplateNameLike = function(searchString){
        var i = -1,
            len = this.data.bodyClasses.length,
            currentClass;

        for(; ++i < len;){
            currentClass = this.data.bodyClasses[i];

            if (currentClass.indexOf(searchString) !== -1){
                // match found
                return true;
            }
        }

        // no mathch
        return false;
    }

    function PageTemplate(){

    }

    function PageTemplateHome(){

    }
    extendsObject(PageTemplateHome, PageTemplate);

    function PageTemplateSingle(){

    }
    extendsObject(PageTemplateSingle, PageTemplate);

    function PageTemplateListingWide(){
        // save self for use inside callbacks
        var self = this;

        // TODO factor this into the PageTemplate prototype
        this.carouselThumbTemplateSource = $('#listing-wide-gallery-pager-thumb-template').html();
        this.carouselPagerTemplateSource = $('#listing-wide-gallery-pager-template').html();
        this.carouselPagerTemplate = Handlebars.compile(this.carouselPagerTemplateSource);
        this.carouselThumbTemplate = Handlebars.compile(this.carouselThumbTemplateSource);

        // save jQuery objects
        this.$carousel = $('.listing-wide-gallery');
        this.$slidesContainer = this.$carousel.find('.listing-wide-gallery-slides');

        // add the pager element to the gallery
        this.$carousel.append(
            this.carouselPagerTemplate()
        );

        // capture the pager element
        this.$pager = this.$carousel.find('.listing-wide-gallery-pager');

        // init the slick carousel
        this.$slidesContainer.slick({
            autoplay: true,
            arrows: false,
            appendDots: this.$pager,
            dots: true,
            fade: true,
            customPaging: function(slider, index){
                var thumbSrc = $(slider.$slides[index]).attr('data-thumb-image-url');
                return self.carouselThumbTemplate({
                    src: thumbSrc,
                    alt: 'thumbnail ' + index
                })
            }
        });
    }
    extendsObject(PageTemplateListingWide, PageTemplateSingle);

    // on DOM ready callback
    function initOnDOMReady(){
        console.log('DOM Ready');

        // init the page template
        if (pageData.isSingle()){
            if (pageData.isTemplateNameLike('listing-wide')){
                pageTemplate = new PageTemplateListingWide();
            } else {
                pageTemplate = new PageTemplateSingle();
            }
        } else if (pageData.isHome()){
            pageTemplate = new PageTemplateHome();
        } else {
            pageTemplate = new PageTemplate();
        }
        console.log('pageTemplate init', pageTemplate);
    }

    // resources loaded event callback
    function initOnResourcesLoaded(event){
        // which page are we on?

        // call the page

        // init the slideshows

        // fade the slideshows in
    }

    // main init function
    function publicInit(){
        // init code

        // load the pageData
        if (windowPageData !== undefined){
            pageData = new PageData(windowPageData);
        }

        // on DOM ready
        $(document).ready(initOnDOMReady);

        // on all resources loaded
        $(window).on('load', initOnResourcesLoaded);
    }

    return {
        init: publicInit
    }

})(jQuery, pageData);

mondrian.init();
