<?php global $Itemid;?>

<link href="templates/townwizard/css/mobiscroll-2.4.custom.min.css" rel="stylesheet" type="text/css" />

<script src="templates/townwizard/js/mobiscroll-2.4.custom.min.js" type="text/javascript"></script>

             
                <style type="text/css">
                  .ios .dwo { background:#000; }
                </style>

                <script type="text/javascript">
                  jQuery(document).ready(function() {
jQuery.noConflict();
                    var themeSkinDate = getTheme();
                    var now = new Date();

                    jQuery('#DatePicker input').mobiscroll().date({
                        minDate: new Date(now.getFullYear(), now.getMonth(), now.getDate()), 
                        theme: themeSkinDate, 
                        display: 'modal', 
                        animate: 'pop', 
                        mode: 'scroller'
                    });
                    jQuery('#DatePicker a').click(function(){
                        jQuery('#DatePicker input').mobiscroll('show'); 
                        return false;
                    });
                  });
                </script>
<script type="text/javascript">
	

function redirecturl(val)
{
	url="/index.php?option=com_jevents&view=week&task=week.listevents&Itemid=<?php echo $Itemid;?>&searchdate="+val; 
	window.location=url;
}

</script>

<style>
#DatePicker a {
    background: url("/templates/townwizard/images/header/calBtnLg.png") no-repeat scroll left top transparent;
    cursor: pointer;
    display: block;
    height: 30px;
	border: medium none;
    text-indent: -20000px;
    width: 34px;
}

#DatePicker input {
    display: none;
}

#Find{
	position: relative;
}

#DatePicker{
	  position: absolute;
    right: 57px;
    top: 14px;
}

.dw-in{
	   left:36% !important;
    top: 290px !important;
}

</style>

<div id="DatePicker" class="fl">
                  <a>Select a date...</a>
<input onChange="redirecturl(this.value);" type="text" size="22" id="inputField1" name="searchdate" value="" />
                </div>