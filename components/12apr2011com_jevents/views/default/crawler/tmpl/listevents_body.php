<?php 
defined('_JEXEC') or die('Restricted access');

$data = $this->data;

$Itemid = JEVHelper::getItemid();

$num_events = count($data['rows']);
if( $num_events > 0 ){
	for( $r = 0; $r < $num_events; $r++ ){
		$row = $data['rows'][$r];

		$rowlink = $row->viewDetailLink($row->yup(),$row->mup(),$row->dup(),true);

		?>
		<a class="ev_link_row" href="<?php echo $rowlink; ?>"  title="<?php echo JEventsHTML::special($row->title()) ;?>"><?php echo $row->title() ;?></a>
		<br/>
		<?
	}
}
// Create the pagination object
if ($data["total"]>$data["limit"]){
	$this->paginationForm($data["total"], $data["limitstart"], $data["limit"]);
}
