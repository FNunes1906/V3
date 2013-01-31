<?php 
/**
 * Compatibility Functions required by com_php
 * @author gabe@fijiwebdesign.com
 */

// JSON encoding/decoding PHP<5.2
if (!function_exists('json_encode')) {
	// pear json class
	require_once(JPATH_ADMINISTRATOR . '/components/com_php/lib/json/pear_json.php');
	
	function json_encode($object) {
		$JSON = new Services_JSON;
		return $JSON->encode($object);
	}
	function json_decode($object) {
		$JSON = new Services_JSON;
		return $JSON->decode($object);
	}
}







?>