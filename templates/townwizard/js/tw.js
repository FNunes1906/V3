jQuery(document).ready(function() {
  
  //Bind content resize function to page load and resize
  setTimeout(function() { resizeContent(); updateOrientation(); }, 100);
  jQuery(window).resize(resizeContent);

  document.addEventListener("orientationchange", updateOrientation);

  //Bind Twitter/Facebook help tooltip
  jQuery('.helpBtn').click(showTip);
  //Bind additional modal tootltips
  jQuery('.rsvpBtn').click(showTip);
  jQuery('#LoginPanel .socialLinks a').click(showTip);
  jQuery('.checkins .seeAll').click(showTip);


  /*jQuery('.centerCol .sect').click(function() {
    alert("sect: " + jQuery(this).offset().top + " " + jQuery(this).css('margin-top') + "\nleft col bottom: " + (jQuery('#LeftCol').offset().top + jQuery('#LeftCol').height()));
    alert(jQuery(this).width());
    alert(jQuery(this).attr('class'));
  });*/

});

function fb_login() {
  window.open("/townwizard-db-api/fb-login.php", "_blank", "height=200,width=400,status=no,toolbar=no,menubar=no");
}

var killTimer1;
var killTimer2;
var killTimer3;
var refreshResize = true;

var resizeContent = function() {

  //Update screen layout for smaller screens
  if (jQuery(window).width() < 980) {
    
    //Applies alternate styles for smaller screens
    jQuery('body').addClass('tablet');

    //Set Top Bar and Footer backgrounds to full screen width
    jQuery('#TopBar').css('width',jQuery('#Content').width() + 10);
    jQuery('#Footer').css('width',jQuery('#Content').width() + 10);

    //Move guide text next to logo after upper banner ad is moved to lower ad space 
    if (!jQuery('#UpperBannerAd').hasClass('tabletLayout')) {
      jQuery('#LowerBannerAd').append(jQuery('#UpperBannerAd').html());
      jQuery('#UpperBannerAd').addClass('tabletLayout').html('');
      jQuery('#UpperBannerAd').html(jQuery('.localCont').html());
      jQuery('.localCont').html('');
    }

    //If home event rotator exists adjust width
    if (jQuery('#EvtRot').length) {
      killTimer1 = setTimeout(function() { 
        jQuery('#EvtRot .gallery, #EvtRot .gallery ul, #EvtRot .gallery ul li').css('width',jQuery('#MainContent').width() - 285).css('height',jQuery('#EvtRot .gallery ul li .event').height());
        jQuery('#EvtRot .gallery ul').parent().css('width',jQuery('#MainContent').width() - 285).css('height',jQuery('#EvtRot .gallery ul li .event').height() + 38);
        jQuery('#EvtRot .gallery .event .rsvp .faces').css('width',jQuery('#MainContent').width() - 360);
        jQuery('#EvtRot .galleryNav').css('width',jQuery('#MainContent').width() - 285);
      }, 100);
    }

    //Else if event page rotator exists adjust width
    else if (jQuery('.rotator').length) {
      killTimer2 = setTimeout(function() {
        jQuery('.rotator .centerCol.gallery, .rotator .gallery ul, .rotator .gallery ul li').css('width',jQuery('#MainContent').width() - 285).css('height',jQuery('.rotator .gallery ul li .event').height());
        jQuery('.rotator .gallery ul').parent().css('width',jQuery('#MainContent').width() - 285).css('height',jQuery('.rotator .gallery ul li .event').height());
      }, 100);
    }

    //Re-align center and right column content
    if (jQuery('#WidgetArea').length) {

      //Adjust width of sections below left column
      killTimer3 = setTimeout(function() {
        jQuery('#WidgetArea .centerCol .sect').not('#WidgetArea #Blog.centerCol .sect').each(function() {
          jQuery(this).parent().removeClass('cb belowCol');
          if (jQuery(this).offset().top > (jQuery('#LeftCol').offset().top + jQuery('#LeftCol').height() + parseFloat(jQuery(this).css('margin-top')))) {
            jQuery(this).css('width',jQuery('#Content').width());
            jQuery(this).parent().addClass('cb belowCol').css('width',jQuery('#Content').width());
          }
        });
      }, 100);

      if (!navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
        //Expand center column content to full width
        jQuery('#WidgetArea .centerCol .sect, #WidgetArea .rightCol.spread').not('#WidgetArea #Blog.centerCol .sect').css('width',jQuery('#MainContent').width() - 285);
        jQuery('#WidgetArea #Blog.centerCol .sect').css('width',jQuery('#MainContent').width() - 555);
      }

    }

    //Shrink right column content for screen sizes below 845px
    if (jQuery(window).width() < 845 ) {
      //jQuery('body').addClass('min');
      jQuery('.rightCol .sect').not('.rightCol.spread .ad.sect, #BlogCol.rightCol .sect').css('width',jQuery('#MainContent').width() - 529);
      jQuery('#ShareTool .side').css('font-size',0);
      jQuery('body.tablet .sect.list ul li a, body.tablet #PlacesInfo ul li a').not('body.tablet .sect.horiz.list ul li a').css('line-height','15px');
      //jQuery('#LowerBannerAd').addClass('min');
    }
    else {
      //jQuery('body').removeClass('min');
      jQuery('.rightCol .sect').not('.rightCol .ad.sect').css('width',300);
      jQuery('#ShareTool .side').css('font-size','12px');
      jQuery('body.tablet .sect.list ul li a, body.tablet #PlacesInfo ul li a').not('body.tablet .sect.horiz.list ul li a').css('line-height','25px');
      //jQuery('#LowerBannerAd').removeClass('min');
    }
  }

  //Update layout for larger screens
  else {

    //Kill Timeouts
    clearTimeout(killTimer1);
    clearTimeout(killTimer2);
    clearTimeout(killTimer3);

    //Removes alternate styles for smaller screens
  	jQuery('body').removeClass('tablet');

    //Sets Top Bar and Footer backgrounds to full site width
  	jQuery('#TopBar').css('width','100%');
    jQuery('#Footer').css('width','100%');
  	
    //Moves upper banner ad back to header spot and places guide text below
    if (jQuery('#UpperBannerAd').hasClass('tabletLayout')) {
      jQuery('.localCont').append(jQuery('#UpperBannerAd').html());
      jQuery('#UpperBannerAd').removeClass('tabletLayout').html('');
      jQuery('#UpperBannerAd').append(jQuery('#LowerBannerAd').html());
      jQuery('#LowerBannerAd').html('');
    }

    //If event rotator exists set to full site width
    if (jQuery('#EvtRot').length) {
      jQuery('#EvtRot .gallery, #EvtRot .gallery ul, #EvtRot .gallery ul li').css('width',420).css('height',268);
      jQuery('#EvtRot .gallery .event .rsvp .faces').css('width','345px');
      jQuery('#EvtRot .galleryNav').css('width','auto');
    }

    //Else if event page rotator exists adjust width
    else if (jQuery('.rotator').length) {
      jQuery('.rotator .gallery ul, .rotator .gallery ul li').css('width',420);
      jQuery('.rotator .gallery ul, .rotator .gallery ul li, .rotator .centerCol.gallery').css('height',268);
      jQuery('.rotator .gallery ul').parent().css('width',420);
    }

    //Re-align center and right column content into 2 column layout
    if (jQuery('#WidgetArea').length) {

      //Set center and right column content to full site widths
      jQuery('#WidgetArea .rightCol .sect').not('.rightCol .ad.sect').css('width',300);
      jQuery('#WidgetArea .centerCol .sect').css('width',420);

      //Remove formatting for items below left column in narrow view
      if (jQuery('#WidgetArea .centerCol .sect').parent().hasClass('belowCol')) {
        jQuery('#WidgetArea .centerCol .sect').parent().removeClass('cb belowCol');
      }
    }

    //Fix list item line heights
    jQuery('.sect.list ul li a, #PlacesInfo ul li a').not('.sect.horiz.list ul li a').css('line-height','13px');
  
  }

  //Correct any quirks with a quick refresh after each change
  if (refreshResize == true) {
    refreshResize = false;
    setTimeout("resizeContent()", 100);
  }
  else {
    refreshResize = true;
  }
  
}

var updateOrientation = function() {

  if (jQuery(window).width() < 980) {
    //Expand center column content to full width
    jQuery('#WidgetArea .centerCol .sect, #WidgetArea .rightCol.spread').not('#WidgetArea #Blog.centerCol .sect').css('width',jQuery('#MainContent').width() - 215);
    jQuery('#WidgetArea #Blog.centerCol .sect').css('width',jQuery('#MainContent').width() - 555);
  }

}

var getTheme = function() {
  //Sniff user platform and set most appropriate skin for mobiscroll datepicker

  if (navigator.userAgent.match(/(Linux|arm)/)) {
    return "android-ics";
  }
  else if (navigator.userAgent.match(/(Windows|MSIE)/)) {
    return "wp";
  }
  else if (navigator.userAgent.match(/(AppleWebKit|iPad|Macintosh)/)) {
    return "ios";
  }
  else {
    return "default";
  }

}

var showTip = function(refPanel) {
  if (typeof(refPanel) != "string") {
    var refPanel = '#' + jQuery(this).data('ref-panel');
  }
  jQuery('#Darkness').fadeIn('fast',function() {
    jQuery(refPanel).fadeIn();
    jQuery(refPanel + ' .close, #Darkness, ' + refPanel + ' .socialLinks a').click(function() {
      hideTip(refPanel);
    });
    if (refPanel == "#LoginPanel") {
      jQuery(refPanel + ' .socialLinks a').unbind('click').click(passLoginGate);
    }
  });
}

var hideTip = function(refPanel) {
  jQuery(refPanel).fadeOut('fast',function() {
    jQuery('#Darkness').fadeOut();
  });
}

var passLoginGate = function() {
  var refPanel = '#' + jQuery(this).data('ref-panel');
  jQuery('.takeOverlay').fadeOut('fast', function() {
    showTip(refPanel);
  });
}

var alertScreenSize = function() {
  alert(jQuery(window).width() + "px, " + jQuery('body').height() + "px");
}
