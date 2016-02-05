<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CommonController {

	public static function CGridViewCommonSettings(){
		return array(
			'template'=>'{items}{summary}{pager}',
			'summaryText' => '<p>Showing <strong>{start} - {end}</strong> of <strong>{count}</strong></p>',
			'emptyText' => 'No records found',
			'itemsCssClass'=>'table table-striped table-bordered bootstrap-datatable',
			'pagerCssClass' => 'dataTables_paginate paging_bootstrap center-block',
			'pager' => array(
				'class' => 'CLinkPager',
				'cssFile'=>false,
				'header' => '',
				'hiddenPageCssClass' => 'disabled',
				'firstPageLabel'=>'← First',
				'prevPageLabel'=>'< Previous',
				'nextPageLabel'=>'Next >',
				'lastPageLabel'=>'Last →',
				'selectedPageCssClass'=>'active',
				'htmlOptions'=>array('class'=>'pagination'),
			),
			'htmlOptions'=>array('style'=>'overflow-x:auto;width:100%;'),
		);
	}
	
	/**
	* Function to send Email
	* @param undefined $codeTxt
	* 
*/
	public static function sendEmailViaTemplate($codeTxt) {
		$to			= $codeTxt['user_email'];
		$subject	= $codeTxt['email_subject'];
		$bodymessage = "
		<html>
		<head>
		<title>HTML email</title>
		</head>
			<body>
				<p>Hi $codeTxt[user_real_name]</p>
				<p>This email is in response to your password request.</p>
				<p>$codeTxt[reset_pass_link]</p>
				<p>If you did not request a new password, please contact us immediately at <a href=mailto:support@townwizard.com>support@townwizard.com</a></p>
				<p>Thanks, The TownWizard Team </p>
			</body>
		</html>
		";

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// More headers
		$headers .= 'From: <no-reply@townwizard.com>' . "\r\n";


		 /*$message = new YiiMailMessage;
		 $message->setBody($bodymessage, 'text/html');
		 $message->subject = $subject;
		 $message->addTo($to);
		 $message->from = Yii::app()->params['adminEmail'];
		 $status = Yii::app()->mail->send($message);*/

		//$status = true;
		$status = mail($to,$subject,$bodymessage,$headers);
		return $status;
		
		
		/*if(isset($codeTxt['user_id']) && $codeTxt['user_id'] > 0) {
			$subject = 'Your new password';
			$from = 'noreply@townwizard.com';
			$to = 'yogi@townwizard.com';
			$body ='Please find your new password is';
			//Send email
			$message = new YiiMailer();
			//$message->setData(array('message' => Yii::app()->name . ' - Message to send', 'description' => $body));
			$message->setSubject($subject);
			$message->setData($body);
			//$message->setData(array('description' => $body));
			$message->setFrom($from);
			$message->setTo($to);
			//$message->setCc($cc);
			//$message->setBcc($bcc);
			//$message->setAttachment($filename);
			$status = $message->send();

			/*if($status && $saveSentEmail->id) {
				$model = SentEmail::model()->findByPk($saveSentEmail->id);
				$model->status = 1;
				$model->updated_on =  date("Y-m-d H:i:s");
				$model->save(false);
			} */
		
		
		/*Yii::import('ext.yii-mail.YiiMailMessage');
		$message = new YiiMailMessage;
		$message->setBody('Message content here with HTML', 'text');
		$message->subject = 'My Subject';
		$message->addTo('yogi.ghorecha@gmail.com');
		$message->from = Yii::app()->params['adminEmail'];
		$status = Yii::app()->mail->send($message);*/
		
	}
	
	public function find_catids_in_set($location_cat_array){
		$location_cat_concat = '';
		if (is_array($location_cat_array)){
			for($i = 0; $i < count($location_cat_array) ; $i++){	
				$location_cat_concat .= '  FIND_IN_SET('.$location_cat_array[$i].',catid_list )';
				if($i < count($location_cat_array)-1 ){
					$location_cat_concat .=' or';
				}
			}
		}else{
			$location_cat_concat = '  FIND_IN_SET('.$location_cat_array.',catid_list )';
		}
		return $location_cat_concat;
	}
	
	public function explode_catids($separator,$cat_string){
		$cat_id_array = array_map("intval",explode($separator,$cat_string));
		return $cat_id_array;
	}
	
	/**
	* 
	* To use the below, call it like a normal function. There are four arguments.
	* The first determines what you want to measure the date difference in - years, months, quarters, etc - and
	* the allowed values of this are listed in the first few lines of the function.
	* The next two are the dates themselves. Any valid date should work just fine.
	* You can also use timestamps as dates, although if you do, you must set the last of the four arguments to "true".
	*
	*	$interval can be:
	*	yyyy - Number of full years
	*	q - Number of full quarters
	*	m - Number of full months
	*	y - Difference between day numbers
	*	    (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
	*	d - Number of full days
	*	w - Number of full weekdays
	*	ww - Number of full weeks
	*	h - Number of full hours
	*	n - Number of full minutes
	*	s - Number of full seconds (default)
    *
	* @return : Result
	**/
	public function datediffyogi($interval, $datefrom, $dateto, $using_timestamps = false) {

    if (!$using_timestamps) {
        $datefrom = strtotime($datefrom, 0);
        $dateto = strtotime($dateto, 0);
    }
    $difference = $dateto - $datefrom; // Difference in seconds
     
    switch($interval) {
     
    case 'yyyy': // Number of full years
        $years_difference = floor($difference / 31536000);
        if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
            $years_difference--;
        }
        if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
            $years_difference++;
        }
        $datediff = $years_difference;
        break;
    case "q": // Number of full quarters
        $quarters_difference = floor($difference / 8035200);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $quarters_difference--;
        $datediff = $quarters_difference;
        break;
    case "m": // Number of full months
        $months_difference = floor($difference / 2678400);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $months_difference--;
        $datediff = $months_difference;
        break;
    case 'y': // Difference between day numbers
        $datediff = date("z", $dateto) - date("z", $datefrom);
        break;
    case "d": // Number of full days
        $datediff = floor($difference / 86400);
        break;
    case "w": // Number of full weekdays
        $days_difference = floor($difference / 86400);
        $weeks_difference = floor($days_difference / 7); // Complete weeks
        $first_day = date("w", $datefrom);
        $days_remainder = floor($days_difference % 7);
        $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
        if ($odd_days > 7) { // Sunday
            $days_remainder--;
        }
        if ($odd_days > 6) { // Saturday
            $days_remainder--;
        }
        $datediff = ($weeks_difference * 5) + $days_remainder;
        break;
    case "ww": // Number of full weeks
        $datediff = floor($difference / 604800);
        break;
    case "h": // Number of full hours
        $datediff = floor($difference / 3600);
        break;
    case "n": // Number of full minutes
        $datediff = floor($difference / 60);
        break;
    default: // Number of full seconds (default)
        $datediff = $difference;
        break;
    }    
    return $datediff;
}



	public function weekday_comma_seprated_list($post_day_array) {
		foreach($post_day_array as $day){
			switch ($day){
				case 1:
					$day_array[] = "MO";
					break;
				case 2:
					$day_array[] = "TU";
					break;
				case 3:
					$day_array[] = "WE";
					break;
				case 4:
					$day_array[] = "TH";
					break;
				case 5:
					$day_array[] = "FR";
					break;
				case 6:
					$day_array[] = "SA";
					break;
				case 7:
					$day_array[] = "SU";
					break;
			}
		}
	    
	    $weekdays_list = implode(',',$day_array); 
	    return $weekdays_list;
	}
	
	public function userinfo($email){
		$location_cat_concat = '';
		$userdata =  Users::model()->findByAttributes(array('email'=>$email));
		return $userdata;
	}
	
	
	
	


}  // End of class
?>