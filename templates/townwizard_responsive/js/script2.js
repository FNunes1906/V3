(function($) {

$(window).load(function(){
	topSliderPager();
	
});	
	
$(document).ready(function(){
var windowState = "large";	
	
$("#middleColumn").after('<a href="#" id="backToTop">Back to top!</a>');   
	
$('#backToTop').hide();
$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('#backToTop').fadeIn();
			
		} else {
			$('#backToTop').fadeOut();
		}
		
		
	});
	
//Click event to scroll to top
	$('#backToTop').click(function(){
		$('body,html').animate({scrollTop : 0},800);
		return false;
	});

	$('.helpBtn').click(function(){
		$('#HelpTT').fadeIn(300);
		$('#Darkness').fadeIn(300);
	});
	$('#HelpTT .close').click(function(){
		$('#HelpTT').fadeOut(300);
		$('#Darkness').fadeOut(300);
	});
	
	$('.clickrsvp .rsvpBtn').click(function(){
		$('#LoginPanel').fadeIn(300);
		$('#Darkness').fadeIn(300);
	});
	$('#LoginPanel .close').click(function(){
		$('#LoginPanel').fadeOut(300);
		$('#Darkness').fadeOut(300);
	});
	
	$('.checkins .seeAll').click(function(){
		$('#AttendancePanel').fadeIn(300);
		$('#Darkness').fadeIn(300);
	});
	$('#AttendancePanel .close').click(function(){
		$('#AttendancePanel').fadeOut(300);
		$('#Darkness').fadeOut(300);
	});
	
  topSliderPager();
  setInterval(topSliderPager, 1000);
$( ".menuSelected a:first" ).clone().appendTo( "#mainHeader strong" );
	
var url = window.location.href;

$('#mainNav a').filter(function(){
	return this.href === url;
}).addClass('underline');

$("#middleColumn").prepend('<div id="topBannerBackground"></div>');
$("#middleColumn").prepend($("#topBanner"));

if (window.matchMedia("(max-width: 550px)").matches){
	
	smallTouch();
	smartphone();
}

if(window.matchMedia("(min-width:551px) and (max-width:719px)").matches){
	
	smallTouch();
}

if(window.matchMedia("(min-width:720px) and (max-width:837px)").matches){
	
	iPad();
}

if (window.matchMedia("(min-width:838px) and (max-width:989px)").matches){
	
	iPad();
}

if (window.matchMedia("(min-width: 990px)").matches){
	
	desktop();
}

$("#topSlider a").each(function(index) {
		  $("#bottomPager").append('<span class="sliderNavigation"></span>');
		});
		
	$(".sliderNavigation:first").addClass('sliderNavigationSelected');	
		
	
$(".sliderNavigation").click(function() {
		
		var buttonClicked = $(this).index();
		$(".sliderNavigation").removeClass('sliderNavigationSelected');
		$(this).addClass('sliderNavigationSelected');
		
		
		var topEvents = $("#topSlider a").get(buttonClicked);
		$("#topSlider a").removeClass('selected');
		$(topEvents).addClass('selected');
		
		var rightDescription = $('#topSlider.frontPage a').get(buttonClicked); 
	    $("#topSlider.frontPage a").css('background', '#E9E9E9');
        $(rightDescription).css('background', '#D5D5D5'); 
        
		
		});
		
$("#topSlider.otherPages #rightArrow").click(function() {
		slider();
		slidertwo();
		
	});	
	
$("#topSlider.otherPages #leftArrow").click(function() {
		sliderToLeft();
		slidertwoToLeft();
		
	});	
	
	
$("#topSlider.frontPage #rightArrow").click(function() {
		frontPageSlider();
		slidertwo();
		
	});	
$("#topSlider.frontPage #leftArrow").click(function() {
		frontPageSliderToLeft();
		slidertwoToLeft();
		
	});	
	      var intervalSlider = setInterval(slider, 2000);
          var intervalSliderTwo = setInterval(slidertwo, 2000);
          var intervalFrontPageSlider = setInterval(frontPageSlider, 2000);
    
$('#topSlider').hover(function () {
        clearInterval(intervalSlider);
        clearInterval(intervalSliderTwo);
        clearInterval(intervalFrontPageSlider);
    }, function () {
        intervalSlider = setInterval(slider, 2000);
        intervalSliderTwo = setInterval(slidertwo, 2000);
        intervalFrontPageSlider = setInterval(frontPageSlider, 2000);
    });
    
    
    
$("#topSlider.frontPage a").hover(function() {
		
		var eventHovered = $(this).index();
		var actualHoveredItem = eventHovered-3;
		
		$("#topSlider.frontPage a").css('background', '#E9E9E9');
	    $(this).css('background', '#D5D5D5');
	   
		 
	    var topEvents = $("#topSlider.frontPage a").get(actualHoveredItem);
	    var goToLink = $(topEvents).attr("href");
	  
      
		$("#topSlider.frontPage a").removeClass('selected');
		$(topEvents).addClass('selected');
		
		var navigationSelected = $(".sliderNavigation").get(actualHoveredItem);
		$(".sliderNavigation").removeClass('sliderNavigationSelected');
		$(navigationSelected).addClass('sliderNavigationSelected');
		
});
}); 

$(window).resize(function(){
	
 topSliderPager();
 setInterval(topSliderPager, 1000);
 	
   
if (window.matchMedia("(max-width: 550px)").matches && windowState !== "smallTouch"){
	
	smallTouch();
	smartphone();
	
		
}

	
if(window.matchMedia("(min-width:551px) and (max-width:719px)").matches && windowState !== "smallTouch"){
	
	smallTouch();
}

if(window.matchMedia("(min-width:720px) and (max-width:837px)").matches && windowState !== "iPad"){
	
	iPad();
}

if (window.matchMedia("(min-width:838px) and (max-width:989px)").matches && windowState !== "iPad"){
	
	iPad();
}

if (window.matchMedia("(min-width: 990px)").matches && windowState !== "large"){
	
	desktop();
}

});

function smartphone () {
 removeFrontPageClass();
 

 
  windowState = "smallTouch"; 
}

function smallTouch(){
	
	removeFrontPageClass();
	
	
	
		j$("#mobileMenuBttn").off('click');
		
		if(j$("#mainNav").css("display") == "none"){
			j$("#mainNav").css("display", "block");
		}
	      var newValue = j$("#mobileMenuBttn").find('.indicator').text() == '-' ? '+': '+';
			// set the new value of the indicator
		j$("#mobileMenuBttn").find('.indicator').text(newValue);
			
		if(j$("#leftColumn").css("display") == "block"){
			j$("#leftColumn").css("display", "none");
		}

		j$( "#mobileMenuBttn" ).click(function() {
			j$( "#leftColumn" ).toggle("slow");
			var newValue = $(this).find('.indicator').text() == '+' ? '-' : '+';
			// set the new value of the indicator
			j$(this).find('.indicator').text(newValue);
			windowState = "smallTouch";	
		});
	
}
function iPad(){
	
	
   removeFrontPageClass();
	
	j$("#mainNav").css("display", "none");

j$("#mobileMenuBttn").off('click');
    if(j$("#mainNav").css("display") == "block"){
	j$("#mainNav").css("display", "none");
}

    if(j$("#leftColumn").css("display") == "none"){
	j$("#leftColumn").css("display", "block");
}
 var newValue = j$("#mobileMenuBttn").find('.indicator').text() == '-' ? '+': '+';
		// set the new value of the indicator
		j$("#mobileMenuBttn").find('.indicator').text(newValue);
	
	
j$( "#mobileMenuBttn" ).click(function() {
j$( "#mainNav" ).toggle( "slow");
 var newValue = j$(this).find('.indicator').text() == '+' ? '-' : '+';
		// set the new value of the indicator
		j$(this).find('.indicator').text(newValue);

});	
	
	windowState = 'iPad';

}
function desktop(){
	$("#topSlider.frontPage h2").css("top", 0);
	removeTempararyClass();
	
	$("#mobileMenuBttn").off('click');	
	  
	$("#mainNav").css("display", "block");

   if($("#leftColumn").css("display") == "none"){
	$("#leftColumn").css("display", "block");
}	
	
	 windowState = 'large';
	
}

  	function sliderToLeft () {
        
        var selectedImage = $("#topSlider a.selected");
        var nextImage = selectedImage.prev("#topSlider a");
      
     
      if(nextImage.length == 0 ){
      	nextImage = $("#topSlider a:last");
      }
      
      
      selectedImage.removeClass('selected').addClass('previous');
        nextImage.css({ opacity: 0.0 }).addClass('selected').animate({ opacity: 1.0 }, 1000,
                function() {
                    selectedImage.removeClass('previous');
                });
}  
function frontPageSliderToLeft() {
        var selectedImage = $("#topSlider.frontPage a.selected");
        var nextImage = selectedImage.prev("#topSlider.frontPage a");
      
     
      if(nextImage.length == 0 ){
      	nextImage = $("#topSlider.frontPage a:last");
      }
      
      
      
      selectedImage.removeClass('selected').addClass('previous');
        nextImage.addClass('selected').children('img, .description, h3').css({ opacity: 0.0 }).animate({ opacity: 1.0 }, 1000,
                function() {
                    selectedImage.removeClass('previous');
                });
} 
     
     
     	function slider () {
        var selectedImage = $("#topSlider.otherPages a.selected");
        var nextImage = selectedImage.next("#topSlider.otherPages a");
      
     
      if(nextImage.length == 0 ){
      	nextImage = $("#topSlider.otherPages a:first");
      }
      
      
      
      selectedImage.removeClass('selected').addClass('previous');
        nextImage.css({ opacity: 0.0 }).addClass('selected').animate({ opacity: 1.0 }, 1000,
                function() {
                    selectedImage.removeClass('previous');
                });
}

	function frontPageSlider() {
        var selectedImage = $("#topSlider.frontPage a.selected");
        var nextImage = selectedImage.next("#topSlider.frontPage a");
      
     
      if(nextImage.length == 0 ){
      	nextImage = $("#topSlider.frontPage a:first");
      }
      
      
      
      selectedImage.removeClass('selected').addClass('previous');
        nextImage.addClass('selected').children('img, .description, h3').css({ opacity: 0.0 }).animate({ opacity: 1.0 }, 1000,
                function() {
                    selectedImage.removeClass('previous');
                });
}

     
  function slidertwoToLeft (){
   	    var navigationSelected = $("#bottomPager span.sliderNavigationSelected");
	    var nextNavigationSelect = navigationSelected.prev("#bottomPager span");
        if(nextNavigationSelect.length == 0){
        	nextNavigationSelect = $("#bottomPager span:last");
        }
      
        navigationSelected.removeClass('sliderNavigationSelected');
        nextNavigationSelect.addClass('sliderNavigationSelected');
      
        var activeNavigation = nextNavigationSelect.index();
        
        var leftDescription = $('#topSlider.frontPage a').get(activeNavigation); 
        
        
        
        
        $("#topSlider.frontPage a").css('background', '#E9E9E9');
        $(leftDescription).css('background', '#D5D5D5');  	
   }   
    
     
   function slidertwo (){
   	    var navigationSelected = $("#bottomPager span.sliderNavigationSelected");
	    var nextNavigationSelect = navigationSelected.next("#bottomPager span");
        if(nextNavigationSelect.length == 0){
        	nextNavigationSelect = $("#bottomPager span:first");
        }
      
        navigationSelected.removeClass('sliderNavigationSelected');
        nextNavigationSelect.addClass('sliderNavigationSelected');
      
        var activeNavigation = nextNavigationSelect.index();
        
        var rightDescription = $('#topSlider.frontPage a').get(activeNavigation); 
        
        
        
        
        $("#topSlider.frontPage a").css('background', '#E9E9E9');
        $(rightDescription).css('background', '#D5D5D5');  	
   }
   
 

   
   
   function removeFrontPageClass () {
   	j$("#topSlider.frontPage a").css("background", "FFFFFF");
   	j$("#topSlider.frontPage").addClass('temparary').addClass('otherPages').removeClass('frontPage');
     
   }
    function removeTempararyClass () {
   	$("#topSlider.temparary").addClass('frontPage').removeClass('temparary').removeClass('otherPages');
     
   }

 function topSliderPager(){
 	
 	$("#topSlider.frontPage #bottomPager").removeClass('dinamicMargin');
 	$("#topSlider.frontPage #bottomPager").css('margin-top', 0);
 	var imageHeight = $("#topSlider.otherPages a img").height();
 	var headerHeight = $("#topSlider.otherPages a h3").height();
 	var descriptionHeight = $("#topSlider.otherPages a p.description").height();
 	var timePlaceHeight = $("#topSlider.otherPages a p.timePlace").height();
 	var sumOfHeight = imageHeight + headerHeight + descriptionHeight + timePlaceHeight + 20;
 	$("#topSlider.otherPages #bottomPager").addClass('dinamicMargin');
 	$("#topSlider.otherPages #bottomPager.dinamicMargin").css('margin-top', sumOfHeight);
 	var headerPosition = imageHeight -22;
 	
 	
    
 }  	
   
   })(jQuery);
   

