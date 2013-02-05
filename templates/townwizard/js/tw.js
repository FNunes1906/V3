$(document).ready(function() {
  
  //Bind content resize function to page load and resize
  setTimeout(function() { resizeContent(); updateOrientation(); }, 100);
  $(window).resize(resizeContent);

  document.addEventListener("orientationchange", updateOrientation);

  /*$('.centerCol .sect').click(function() {
    alert("sect: " + $(this).offset().top + " " + $(this).css('margin-top') + "\nleft col bottom: " + ($('#LeftCol').offset().top + $('#LeftCol').height()));
    alert($(this).width());
    alert($(this).attr('class'));
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
  if ($(window).width() < 980) {
    
    //Applies alternate styles for smaller screens
    $('body').addClass('tablet');

    //Set Top Bar and Footer backgrounds to full screen width
    $('#TopBar').css('width',$('#Content').width() + 10);
    $('#Footer').css('width',$('#Content').width() + 10);

    //Move guide text next to logo after upper banner ad is moved to lower ad space 
    if (!$('#UpperBannerAd').hasClass('tabletLayout')) {
      $('#LowerBannerAd').append($('#UpperBannerAd').html());
      $('#UpperBannerAd').addClass('tabletLayout').html('');
      $('#UpperBannerAd').html($('.localCont').html());
      $('.localCont').html('');
    }

    //If home event rotator exists adjust width
    if ($('#EvtRot').length) {
      killTimer1 = setTimeout(function() { 
        $('#EvtRot .gallery, #EvtRot .gallery ul, #EvtRot .gallery ul li').css('width',$('#MainContent').width() - 285).css('height',$('#EvtRot .gallery ul li .event').height());
        $('#EvtRot .gallery ul').parent().css('width',$('#MainContent').width() - 285).css('height',$('#EvtRot .gallery ul li .event').height() + 38);
        $('#EvtRot .gallery .event .rsvp .faces').css('width',$('#MainContent').width() - 360);
        $('#EvtRot .galleryNav').css('width',$('#MainContent').width() - 285);
      }, 100);
    }

    //Else if event page rotator exists adjust width
    else if ($('.rotator').length) {
      killTimer2 = setTimeout(function() {
        $('.rotator .centerCol.gallery, .rotator .gallery ul, .rotator .gallery ul li').css('width',$('#MainContent').width() - 285).css('height',$('.rotator .gallery ul li .event').height());
        $('.rotator .gallery ul').parent().css('width',$('#MainContent').width() - 285).css('height',$('.rotator .gallery ul li .event').height());
      }, 100);
    }

    //Re-align center and right column content
    if ($('#WidgetArea').length) {

      //Adjust width of sections below left column
      killTimer3 = setTimeout(function() {
        $('#WidgetArea .centerCol .sect').not('#WidgetArea #Blog.centerCol .sect').each(function() {
          $(this).parent().removeClass('cb belowCol');
          if ($(this).offset().top > ($('#LeftCol').offset().top + $('#LeftCol').height() + parseFloat($(this).css('margin-top')))) {
            $(this).css('width',$('#Content').width());
            $(this).parent().addClass('cb belowCol').css('width',$('#Content').width());
          }
        });
      }, 100);

      if (!navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
        //Expand center column content to full width
        $('#WidgetArea .centerCol .sect, #WidgetArea .rightCol.spread').not('#WidgetArea #Blog.centerCol .sect').css('width',$('#MainContent').width() - 215);
        $('#WidgetArea #Blog.centerCol .sect').css('width',$('#MainContent').width() - 555);
      }

    }

    //Shrink right column content for screen sizes below 845px
    if ($(window).width() < 845 ) {
      $('.rightCol .sect').not('.rightCol.spread .ad.sect, #BlogCol.rightCol .sect').css('width',$('#MainContent').width() - 529);
      $('#ShareTool .side').css('font-size',0);
      $('body.tablet .sect.list ul li a, body.tablet #PlacesInfo ul li a').not('body.tablet .sect.horiz.list ul li a').css('line-height','15px');
    }
    else {
      $('.rightCol .sect').not('.rightCol .ad.sect').css('width',300);
      $('#ShareTool .side').css('font-size','12px');
      $('body.tablet .sect.list ul li a, body.tablet #PlacesInfo ul li a').not('body.tablet .sect.horiz.list ul li a').css('line-height','25px');
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
  	$('#TopBar').css('width','100%');
    $('#Footer').css('width','100%');
  	
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
      $('.rotator .gallery ul, .rotator .gallery ul li, .rotator .centerCol.gallery').css('height',388);
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
    $('#WidgetArea .centerCol .sect, #WidgetArea .rightCol.spread').not('#WidgetArea #Blog.centerCol .sect').css('width',$('#MainContent').width() - 215);
    $('#WidgetArea #Blog.centerCol .sect').css('width',$('#MainContent').width() - 555);
  }

}

var alertScreenSize = function() {
  alert($(window).width() + "px, " + $('body').height() + "px");
}