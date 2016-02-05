<?php
/* @var $this BannersController */
/* @var $model Banners  */

$this->breadcrumbs=array(
	'Languages'=>array('languages'),
	'Manage',
);

?>

<!--INCLUDE LEFT PANEL MENUS-->
<?php include(Yii::app()->basePath . '/views/leftPanel.php'); ?>

<!-- MESSAGE ALERT BOX START -->
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="tw_success">
		 <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button>
        <?php echo Yii::app()->user->getFlash('success'); ?>
		<?php Yii::app()->clientScript->registerScript(
			   'myHideEffect',
			   '$(".tw_success").animate({opacity: 1.0}, 5000).fadeOut("slow");',
			   CClientScript::POS_READY
			);?>
    </div>
<?php endif; ?>
<!-- MESSAGE ALERT BOX END -->

<!-- TABLE HEADING START -->
<div class="row">
<div class="box col-md-12">
<div class="box-inner">
<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
)); ?>
<div class="box-header well" data-original-title="">
    <h2><i class="glyphicon glyphicon glyphicon-flag"></i>&nbsp; Languages</h2>

   <div class="navbar-right event-btn">
	<a href="#"><i class="glyphicon glyphicon-star"></i> 
	<?php echo CHtml::ajaxSubmitButton('Make Default',array('templates/langupdate','act'=>'doActive'), array('beforeSend'=>'function() {if($("#Language-grid").find("input:checked").length ==0){alert("Please make a selection from the list to make default");}else{return true;}}','success'=>'reloadGrid')); ?>
	</a>
    </div>
</div>
<!-- TABLE HEADING END -->

<div class="box-content" id="Language-grid" style="padding: 15px 10px;overflow-x:auto;width:100%;">

<table class="table table-striped table-bordered  bootstrap-datatable">
	<thead>
		<tr>
			<th>#</th>
			<th></th>
			<th>Language Name</th>
			<th>Default</th>
			<th>Creation Date</th>
			<th>Version</th>
			<!--<th>Author</th>-->
		</tr>
	</thead>
	<tbody>
	<?php 
	$path = $_SERVER['DOCUMENT_ROOT'].'/language/';
	$files = scandir($path);
	$lists = array_slice($files,2);
	$count = 0;
	
	foreach($lists as $directory){
		$file = $_SERVER['DOCUMENT_ROOT'].'/language/'.$directory.'/'.$directory.'.xml';
	    if(is_dir($path . '/' . $directory) AND file_exists($file)){ 
	      $xml=simplexml_load_file($file);
		  $count++; 
	?>
		  <tr>
			<td class="center">
				<label><?php echo $count;?></label>
			</td>
			<td class="center">
				<input type="radio" name="language" id="language" value="<?php echo $directory;?>">
			</td>
			<td><?php  echo $xml->name; ?></td>
	       	<td class="center">
			<?php 
				$def = Components::model()->findByAttributes(array('option'=>'com_languages'));
				$fetch_lang = explode('site=',$def['params']);
				$lang = rtrim($fetch_lang[1]);
				if($lang==$directory){
					echo '<i class="glyphicon glyphicon-star yellow"></i>';
				}
				?>	
	        </td>
			<td class="center"><?php echo $xml->creationDate; ?></td>
			<td class="center"><?php echo $xml->version;?></td>
			<!--<td class="center"><?php echo $xml->author;?></td>-->
   		 </tr>
	   <?php }
	} 
	?>	
		
	</tbody>
</table>
</div>
<script>

function reloadGrid(data) {
  // alert(data);
   window.location.reload();
}
</script>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>
