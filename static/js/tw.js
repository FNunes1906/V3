$(document).ready(function() {
  
  //Bind content resize function to page load and resize
  setTimeout(function() { resizeContent(); updateOrientation(); }, 100);
  $(window).resize(resizeContent);

  document.addEventListener("orientationchange", updateOrientation);

  //Bind all modal buttons
  jQuery('a[data-ref-panel]').each(function() {
    jQuery(this).click(showTip);
  });

  //Bind GeoLocation button
  jQuery('#GeoLocateMe .yes').click(geoLocateMe);

  //Bind Menu Button for Mobile Site
  jQuery('#MenuBtn').click(toggleMenu);


  /*$('.centerCol .sect').click(function() {
    alert("sect: " + $(this).offset().top + " " + $(this).css('margin-top') + "\nleft col bottom: " + ($('#LeftCol').offset().top + $('#LeftCol').height()));
    alert($(this).width());
    alert($(this).attr('class'));
  });*/

  $(document).on('click','#LeftCol .swipe',function() {
    toggleMenu();
  });

  $('#LeftCol .swipe').touchwipe({
     wipeLeft: function() { toggleMenu(); },
     wipeRight: function() { },
     min_move_x: 20,
     min_move_y: 20,
     preventDefaultEvents: true
  });

});

var toggleMenu = function() {
  if(jQuery('#TopBar').offset().left > 0) {
    jQuery('#LeftCol').css('z-index',999).removeClass('open');
    jQuery('#TopBar, #WidgetArea').animate({ left: 0 }, 200, function() { 
      jQuery('#WidgetArea').css('position','relative').css('top','-4px');
      window.scrollTo(0,currentTop);
    });
    jQuery('#TopBar').animate({ left: 0 }, 200, function() { 
      jQuery('#Footer').show();
    });
    jQuery('#LeftCol .swipe').hide();
  }
  else {
    jQuery('#Footer').hide();
    jQuery('#LeftCol .swipe').show().css('height',$('#LeftCol').height());
    jQuery('#TopBar').animate({ left: '85%' }, 200, function() { });
    jQuery('#TopBar, #WidgetArea').css('position','fixed').animate({ left: '85%' }, 200, function() { 
      jQuery('#LeftCol').css('z-index',2001).addClass('open');
    });
    currentTop = window.pageYOffset;
    //alert(currentTop + ' ' + (window.pageYOffset + 32));
    jQuery('#WidgetArea').css('top', 32 - currentTop + 'px');
    window.scrollTo(0,0);
    //jQuery('#LeftCol').css('top',window.pageYOffset + 'px');
  }
}

function fb_login() {
  window.open("/townwizard-db-api/fb-login.php", "_blank", "height=200,width=400,status=no,toolbar=no,menubar=no");
}

var killTimer1;
var killTimer2;
var killTimer3;
var refreshResize = true;

var resizeContent = function() {

  //Update screen layout for smaller screens
  if ($(window).width() < 980) {
    
    //Applies alternate styles for smaller screens
    $('body').addClass('tablet');

    //Set Top Bar and Footer backgrounds to full screen width
    //$('#TopBar').css('width',$('#Content').width() + 10);
    //$('#Footer').css('width',$('#Content').width() + 10);

    //Move guide text next to logo after upper banner ad is moved to lower ad space 
    if (!$('#UpperBannerAd').hasClass('tabletLayout')) {
      $('#LowerBannerAd').append($('#UpperBannerAd').html());
      $('#UpperBannerAd').addClass('tabletLayout').html('');
      $('#UpperBannerAd').html($('.localCont').html());
      $('.localCont').html('');
    }

    //If home event rotator exists adjust width
    if ($('#EvtRot').length) {
      if ($(window).width() > 733) {
        killTimer1 = setTimeout(function() { 
          $('#EvtRot .gallery, #EvtRot .gallery ul, #EvtRot .gallery ul li').css('width',$('#MainContent').width() - 285).css('height',$('#EvtRot .gallery ul li .event').height());
          $('#EvtRot .gallery ul').parent().css('width',$('#MainContent').width() - 285).css('height',$('#EvtRot .gallery ul li .event').height() + 38);
          $('#EvtRot .gallery .event .rsvp .faces').css('width',$('#MainContent').width() - 360);
          $('#EvtRot .galleryNav').css('width',$('#MainContent').width() - 285);
        }, 100);
      }
      else {
        $('#EvtRot .gallery, #EvtRot .gallery ul, #EvtRot .gallery ul li').css('width','100%').css('height',$('#EvtRot .gallery ul li .event').height());
        $('#EvtRot .galleryNav').css('width','auto');
      }
    }

    //Else if event page rotator exists adjust width
    else if ($('.rotator').length) {
      if($(window).width() < 733) {
        killTimer2 = setTimeout(function() {
          $('.rotator .centerCol.gallery, .rotator .gallery ul, .rotator .gallery ul li').css('width',$('#MainContent').width()).css('height',$('.rotator .gallery ul li .event').height());
          $('.rotator .gallery ul').parent().css('width',$('#MainContent').width()).css('height',$('.rotator .gallery ul li .event').height());
          $('.rotator .galleryNav').css('width',$('#MainContent').width());
        }, 100);
      }
      else {
        killTimer2 = setTimeout(function() {
          $('.rotator .centerCol.gallery, .rotator .gallery ul, .rotator .gallery ul li').css('width',$('#MainContent').width() - 285).css('height',$('.rotator .gallery ul li .event').height());
          $('.rotator .gallery ul').parent().css('width',$('#MainContent').width() - 285).css('height',$('.rotator .gallery ul li .event').height());
          $('.rotator .galleryNav').css('width','auto');
        }, 100);
      }
    }

    //Re-align center and right column content
    if ($('#WidgetArea').length) {

      //Adjust width of sections below left column
      killTimer3 = setTimeout(function() {
        $('#WidgetArea .centerCol .sect').not('#WidgetArea #Blog.centerCol .sect').each(function() {
          $(this).parent().removeClass('cb belowCol');
          if ($(this).offset().top > ($('#LeftCol').offset().top + $('#LeftCol').height() + parseFloat($(this).css('margin-top')))) {
            //$(this).css('width',$('#Content').width());
            //$(this).parent().addClass('cb belowCol').css('width',$('#Content').width());
          }
        });
      }, 100);

      if (!navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
        if($(window).width() < 733) {
          //Expand center column content to full width
          $('#WidgetArea .centerCol .sect, #WidgetArea .rightCol.spread').css('width',$('#MainContent').width());
          //$('#WidgetArea #Blog.centerCol .sect').css('width',$('#MainContent').width());
        }
        else {
          $('#WidgetArea .centerCol .sect, #WidgetArea .rightCol.spread').css('width',$('#MainContent').width() - 215);
          //$('#WidgetArea #Blog.centerCol .sect').css('width',$('#MainContent').width() - 555);
        }
      }

    }

    //Shrink content for screen sizes below 768px
    if ($(window).width() < 733 ) {
      //$('body').addClass('min');
      $('.rightCol .sect').not('.rightCol.spread .ad.sect, #BlogCol.rightCol .sect').css('width',$('#MainContent').width());
      //$('#ShareTool .side').css('font-size',0);
      $('body.tablet .sect.list ul li a, body.tablet #PlacesInfo ul li a').not('body.tablet .sect.horiz.list ul li a').css('line-height','15px');

        //$('#LowerBannerAd').addClass('min');
        //Move upper banner ad to mobile ad space 
        if (!$('#LowerBannerAd').hasClass('mobileLayout')) {
          $('#MobileBannerAd').append($('#LowerBannerAd').html());
          $('#LowerBannerAd').addClass('mobileLayout').html('').hide();
        }


    }
    else {
      //$('body').removeClass('min');
      //Below line modified for responsive design - actual app does not have side by side widgets so we need to be full width, not 300px
      $('.rightCol .sect').not('.rightCol .ad.sect').css('width','100%');
      $('#ShareTool .side').css('font-size','12px');
      $('body.tablet .sect.list ul li a, body.tablet #PlacesInfo ul li a').not('body.tablet .sect.horiz.list ul li a').css('line-height','25px');
    
      //$('#LowerBannerAd').removeClass('min');
        //Moves upper banner ad back to lower spot
        if ($('#LowerBannerAd').hasClass('mobileLayout')) {
          $('#LowerBannerAd').removeClass('mobileLayout').html('').show();
          $('#LowerBannerAd').append($('#MobileBannerAd').html());
          $('#MobileBannerAd').html('');
        }

      //Close mobile menu if open when making screen larger
      if (jQuery('#LeftCol').hasClass('open')) {
        toggleMenu();
      }

    }
  }

  //Update layout for larger screens
  else {

    //Kill Timeouts
    clearTimeout(killTimer1);
    clearTimeout(killTimer2);
    clearTimeout(killTimer3);

    //Removes alternate styles for smaller screens
  	$('body').removeClass('tablet');

    //Sets Top Bar and Footer backgrounds to full site width
  	//$('#TopBar').css('width','100%');
    //$('#Footer').css('width','100%');
  	
    //Moves upper banner ad back to header spot and places guide text below
    if ($('#UpperBannerAd').hasClass('tabletLayout')) {
      $('.localCont').append($('#UpperBannerAd').html());
      $('#UpperBannerAd').removeClass('tabletLayout').html('');
      $('#UpperBannerAd').append($('#LowerBannerAd').html());
      $('#LowerBannerAd').html('');
    }

    //If event rotator exists set to full site width
    if ($('#EvtRot').length) {
      $('#EvtRot .gallery, #EvtRot .gallery ul, #EvtRot .gallery ul li').css('width',420).css('height',268);
      $('#EvtRot .gallery .event .rsvp .faces').css('width','345px');
      $('#EvtRot .galleryNav').css('width','auto');
    }

    //Else if event page rotator exists adjust width
    else if ($('.rotator').length) {
      $('.rotator .gallery ul, .rotator .gallery ul li').css('width',420);
      $('.rotator .gallery ul, .rotator .gallery ul li, .rotator .centerCol.gallery').css('height',288);
      $('.rotator .gallery ul').parent().css('width',420);
    }

    //Re-align center and right column content into 2 column layout
    if ($('#WidgetArea').length) {

      //Set center and right column content to full site widths
      $('#WidgetArea .rightCol .sect').not('.rightCol .ad.sect').css('width',300);
      $('#WidgetArea .centerCol .sect').css('width',420);

      //Remove formatting for items below left column in narrow view
      if ($('#WidgetArea .centerCol .sect').parent().hasClass('belowCol')) {
        $('#WidgetArea .centerCol .sect').parent().removeClass('cb belowCol');
      }
    }

    //Fix list item line heights
    $('.sect.list ul li a, #PlacesInfo ul li a').not('.sect.horiz.list ul li a').css('line-height','13px');
  
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

  if ($(window).width() < 980) {
    //Expand center column content to full width
    $('#WidgetArea .centerCol .sect, #WidgetArea .rightCol.spread').not('#WidgetArea #Blog.centerCol .sect').css('width',$('#MainContent').width());
    $('#WidgetArea #Blog.centerCol .sect').css('width',$('#MainContent').width());
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

    //Dynamically add YouTube embed code and description to VidPanel overlay
    if (refPanel == "#VidPanel") {
      jQuery('.vidModalHolder').html('<iframe width="420" height="315" src="https://www.youtube.com/embed/RfrueeBmfXo?rel=0" frameborder="0" allowfullscreen></iframe><p>Video description goes here</p>');
    }

  });
}

var hideTip = function(refPanel) {
  jQuery(refPanel).fadeOut('fast',function() {
    
    //If there is a YouTube player, remove it when modal is closed so it does not continue to play
    if (jQuery('.vidModalHolder').length) {
      jQuery('.vidModalHolder').html('');
    }
    
    jQuery('#Darkness').fadeOut();
  });
}

var passLoginGate = function() {
  var refPanel = '#' + jQuery(this).data('ref-panel');
  jQuery('.takeOverlay').fadeOut('fast', function() {
    showTip(refPanel);
  });
}

function geoSuccess(position) {
  var latlng = position.coords.latitude + ", " + position.coords.longitude;
  alert("Thank you for checking in with Town Wizard! You are located at:\n\n" + latlng);
}

function geoError(msg) {
  alert("We're sorry, there was an error finding your location.");
  
  // console.log(arguments);
}

var geoLocateMe = function() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(geoSuccess, geoError);
  } else {
    error('not supported');
  }
}

var alertScreenSize = function() {
  alert($(window).width() + "px, " + $('body').height() + "px");
}
