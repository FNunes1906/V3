<?php
/**
 * JEvents Component for Joomla 1.5.x
 *
 * @version     $Id: view.html.php 1576 2009-09-23 09:11:04Z geraint $
 * @package     JEvents
 * @copyright   Copyright (C) 2008-2009 GWE Systems Ltd
 * @license     GNU/GPLv2, see http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.jevents.net
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

// setup document
$doc =& JFactory::getDocument();

$doc->setLink($this->info['link']);
$doc->setBase($this->info['base']);
$doc->setTitle($this->info['title']);
$doc->setDescription($this->info['description']);

$docimage =new JFeedImage();
$docimage->set('description', $this->info['description']);
$docimage->set('title', $this->info['title']);
$docimage->set('url', $this->info['image_url']);
$docimage->set('link', $this->info['imagelink']);
$doc->set('image', $docimage);

foreach ($this->eventsByRelDay as $relDay => $ebrd) {
	foreach ($ebrd as $row) {
		// title for particular item
		$item_title = htmlspecialchars( $row->title() );
		$item_title = html_entity_decode( $item_title );

		// url link to article
		$startDate = $row->publish_up();
		//$eventDate = mktime(substr($startDate,11,2),substr($startDate,14,2), substr($startDate,17,2),$this->jeventCalObject->now_m,$this->jeventCalObject->now_d + $relDay,$this->jeventCalObject->now_Y);
		$eventDate = strtotime($startDate);


		$targetid = $this->modparams->get("target_itemid",0);
		$link = $row->viewDetailLink(date("Y", $eventDate),date("m", $eventDate),date("d", $eventDate),false,$targetid);
		$item_link  = JRoute::_($link.$this->jeventCalObject->datamodel->getCatidsOutLink());

		// removes all formating from the intro text for the description text
		$item_description = $row->content();
		$item_description = JFilterOutput::cleanText( $item_description );
		if ( $this->info[ 'limit_text' ] ) {
			if ( $this->info[ 'text_length' ] ) {
				// limits description text to x words
				$item_description_array = explode( ' ', $item_description );
				$count = count( $item_description_array );
				if ( $count > $this->info[ 'text_length' ] ) {
					$item_description = '';
					for ( $a = 0; $a < $this->info[ 'text_length' ]; $a++ ) {
						$item_description .= $item_description_array[$a]. ' ';
					}
					$item_description = trim( $item_description );
					$item_description .= '...';
				}
			} else  {
				// do not include description when text_length = 0
				$item_description = NULL;
			}
		}

		// type for particular item - category name
		$item_type = $row->getCategoryName();
		/*
		// You could incorporate these fields into the description for the RSS output
		// organizer for particular item
		$item_organizer = htmlspecialchars( $row->contact_info() );
		$item_organizer = html_entity_decode( $item_organizer );
		// location for particular item
		$item_location = htmlspecialchars( $row->location() );
		$item_location = html_entity_decode( $item_location );
		// start date for particular item
		$item_startdate = htmlspecialchars( $row->publish_up());
		// end date for particular item
		$item_enddate = htmlspecialchars( $row->publish_down() );
		*/

		// load individual item creator class
		$item =new JFeedItem();
		// item info
		if ($row->alldayevent()) {
			$temptime = new JDate($eventDate);
			$item->set('title', $temptime->toFormat(JText::_('JEV_RSS_DATE')) ." : " .$item_title);
		} else {
			$temptime = new JDate($eventDate);
			$item->set('title', $temptime->toFormat(JText::_('JEV_RSS_DATETIME')) ." : " .$item_title);
		}
		$item->set('link', $item_link);
		$item->set('description', $item_description);
		$item->set('category', $item_type);
		$t_datenow = JEVHelper::getNow();
		$item->set('date', $t_datenow->toUnix(true));

		// add item info to RSS document
		$doc->addItem( $item );
	}
}
