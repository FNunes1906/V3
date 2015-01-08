<?php
/* @var $this LocationsController */
/* @var $model Locations */

$this->breadcrumbs=array(
	'Locations'=>array('admin'),
	'Manage',
);

# COMMENT THIS TO HIDE CREATE LOCATION AND LIST LOCATION LINK DEFAULT BY Yii
$this->menu=array(
//	array('label'=>'List Locations', 'url'=>array('admin')),
//	array('label'=>'Create Locations', 'url'=>array('create')),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#locations-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<div class="row">
	<ul class="nav navbar-nav nav-pills loc_menu main-menu">
		<li title="Locations" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('locations/admin'); ?>"><i class="glyphicon glyphicon-map-marker"></i></a></li>
		<li title="Categories" data-placement="bottom" data-toggle="tooltip"><a href="<?php echo Yii::app()->createAbsoluteUrl('categories/admin'); ?>"><i class="glyphicon glyphicon-list"></i></a></li>
		<!--<li title="Settings" data-placement="bottom" data-toggle="tooltip"><a href="Settings.html"><i class="glyphicon glyphicon-cog"></i></a></li>-->
	</ul>
</div>
		
<div class="row">
	<div class="box col-md-12">
		<div class="box-inner">		
			<div class="box-header well" data-original-title="">
			    <h2><i class="glyphicon glyphicon-map-marker"></i> Locations</h2>

			    <div class="navbar-right event-btn">
					<a href="#mapmodals" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>
<!--					<a href="<?php echo Yii::app()->createAbsoluteUrl('locations/create'); ?>" data-toggle="modal" role="button"><i class="glyphicon glyphicon-plus-sign"></i> ADD NEW</a>-->
					<a href="#" class=""><i class="glyphicon glyphicon-trash icon-white"></i> DELETE</a>
			    </div>
			</div>
			

<div class="box-content ">
<!--<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>-->
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array('model'=>$model,)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(

	'template'=>'{items}{summary}{pager}',
	'pagerCssClass' => 'dataTables_paginate paging_bootstrap center-block',
	'pager' => array(
		'class' => 'CLinkPager',
		'cssFile'=>false,
		'header' => '',
	  	'hiddenPageCssClass' => 'disabled',
	    'firstPageLabel'=>'<< First',
	    'prevPageLabel'=>'< Previous',
	    'nextPageLabel'=>'Next >',
	    'lastPageLabel'=>'Last >>',
		'selectedPageCssClass'=>'active',
		'htmlOptions'=>array(
	            'class'=>'pagination',
	            //'style'=>'text-align:center !important;',
	        ),
	),
	'itemsCssClass'=>'table table-striped table-bordered bootstrap-datatable responsive',
//	'filterPosition'=>false,
//	'enableSorting' => false,	
//	'summaryText' => false,

	'id'=>'locations-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'loc_id',
		'title',
		'catid_list',
		'published',
		/*
		'state',
		'country',
		'description',
		'postcode',
		'street',
		'city',
		'geolon',
		'alias',
		'geolat',
		'geozoom',
		'pcode_id',
		'image',
		'phone',
		'url',
		'loccat',
		'catid',
		'global',
		'priority',
		'ordering',
		'access',
		'created',
		'created_by',
		'created_by_alias',
		'modified_by',
		'checked_out',
		'checked_out_time',
		'params',
		'anonname',
		'anonemail',
		'imagetitle',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
			'buttons' => array(
				'update' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Update')),
					'label' => '<i class="glyphicon glyphicon-edit icon-white" style="padding-right: 10px"></i>',
					'imageUrl' => false,
					
				),
				'delete' => array(
					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
					'label' => '<i class="glyphicon glyphicon-trash icon-white"></i>',
					'imageUrl' => false,
					'csrf'=>true,
				),
			)	
		),
		
	),

)); ?>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="mapmodals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>New Location</h3>
                </div>
                <div class="modal-body">
				<?php $this->renderPartial('_form', array('model'=>$model)); ?>	</div>
                    
                </div>
<!--                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Save changes</a>
                </div>
-->            </div>
        </div>
		
<!--SCRIPT FOR MAP START-->
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
var var_map;
     var var_location = new google.maps.LatLng(45.430817,12.331516);
     function map_init() {	
            var var_mapoptions = {
              center: var_location,
              zoom: 14
            };
            var_map = new google.maps.Map(document.getElementById("map-container"),
                var_mapoptions);
      
          var contentString =
'<div id="mapInfo">'+
'<p><strong>Peggy Guggenheim Collection</strong><br><br>'+
'Dorsoduro, 701-704<br>' +
'30123<br>Venezia<br>'+
'P: (+39) 041 240 5411</p>'+
'<a href="http://www.guggenheim.org/venice" target="_blank">Plan your visit</a>'+
'</div>';
 
          var var_infowindow = new google.maps.InfoWindow({
            content: contentString
          });
          
          var var_marker = new google.maps.Marker({
            position: var_location,
            map: var_map,
            title:"Click for information about the Guggenheim museum in Venice",
                  maxWidth: 200,
                  maxHeight: 200
          });
 
          google.maps.event.addListener(var_marker, 'click', function() {
             var_infowindow.open(var_map,var_marker);
          });
      }
 
          google.maps.event.addDomListener(window, 'load', map_init);
      
      //start of modal google map
      $('#mapmodals').on('shown.bs.modal', function () {
          google.maps.event.trigger(var_map, "resize");
          var_map.setCenter(var_location);
      });
</script>	
<!--SCRIPT FOR MAP END-->		