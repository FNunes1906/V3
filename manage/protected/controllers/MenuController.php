<?php

class MenuController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','updatestatus','ajaxupdate','findchildren'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Menu;
		$model->published = 1;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Menu']))
		{
			/*PAGE RELATED CODE START*/
			if(isset($_POST['article_page']) && $_POST['article_page'] == '1'){
				$model_contents				= new Contents;
   				$model_contents->title		= $_POST['Menu']['name'];
   				$model_contents->alias		= strtolower($_POST['Menu']['name']);
   				$model_contents->state		= 1;
   				$model_contents->sectionid	= 11;
   				$model_contents->catid		= 214;
   				$model_contents->introtext	= $_POST['Contents']['introtext'];
   				$model_contents->fulltext	= $_POST['Contents']['introtext'];
   				$model_contents->created	= date('Y-m-d H:i:s');
   				$model_contents->publish_up	= date('Y-m-d H:i:s');

				$model_contents->save();
				$last_article_page_id = 	$model_contents->id;
				$_POST['Menu']['link'] = "index.php?option=com_content&view=article&id=$last_article_page_id";
			}
			/*PAGE RELATED CODE END*/
			
			$_POST['Menu']['alias']   = strtolower(str_replace(' ','-',$_POST['Menu']['name']));
			//inserting page-title,meta description and keywords
			if(isset($_POST['Pagemeta']) AND $_POST['Pagemeta']!='')
			{
				if($_POST['Menu']['alias'] == 'home') {
					$menu_alias = 'index.php';
				}else{
					$menu_alias = $_POST['Menu']['alias'];
				}
				if($_POST['Menu']['parent']!='0'){
					$get_parent_name = Menu::model()->findByAttributes(array('id'=>$_POST['Menu']['parent']));
					if(isset($get_parent_name) AND $get_parent_name!='')
					{
						$parent_name = $get_parent_name->alias;
					}
				}
				if(isset($parent_name) AND $parent_name!=''){
					$page_metas = Pagemeta::model()->findByAttributes(array('uri'=>'/'.$parent_name.'/'.$menu_alias));
				}else{
					$page_metas = Pagemeta::model()->findByAttributes(array('uri'=>'/'.$menu_alias));
				}
				
				if(isset($page_metas) AND $page_metas!=''){
					if(isset($parent_name) AND $parent_name!=''){
						$page_metas->uri 		= '/'.$parent_name.'/'.$menu_alias;
					}else{
						$page_metas->uri 		= '/'.$menu_alias;
					}
					$page_metas->title 		= $_POST['Pagemeta']['title'];
					$page_metas->metadesc 	= $_POST['Pagemeta']['metadesc'];
					$page_metas->keywords 	= $_POST['Pagemeta']['keywords'];
					$page_metas->save();
				}else{
					$new_page_metas = new Pagemeta;
					if(isset($parent_name) AND $parent_name!=''){
						$new_page_metas->uri 		= '/'.$parent_name.'/'.$menu_alias;
					}else{
						$new_page_metas->uri 		= '/'.$menu_alias;
					}
					$new_page_metas->title 		= $_POST['Pagemeta']['title'];
					$new_page_metas->metadesc 	= $_POST['Pagemeta']['metadesc'];
					$new_page_metas->keywords 	= $_POST['Pagemeta']['keywords'];
					$new_page_metas->save();
				}
			}
			
			$_POST['Menu']['parent']  = empty($_POST['Menu']['parent'])?0:$_POST['Menu']['parent'];
			
if(isset($_POST['intro']) && $_POST['intro']!=''){ //For creating frontpage/section menu
$_POST['Menu']['params']  =
"show_description=0
show_description_image=0
num_leading_articles=0
num_intro_articles=".$_POST['intro']."
num_columns=1
num_links=0
orderby_pri=
orderby_sec=".$_POST['orderby_sec']."
multi_column_order=1
show_pagination=2
show_pagination_results=1
show_feed_link=1
show_noauth=
show_title=
link_titles=1
show_intro=1
show_section=
link_section=
show_category=
link_category=
show_author=
show_create_date=0
show_modify_date=0
show_item_navigation=
show_readmore=
show_vote=
show_icons=
show_pdf_icon=
show_print_icon=
show_email_icon=
show_hits=
feed_summary=
page_title=
show_page_title=1
pageclass_sfx=
menu_image=".$_POST['menu_icon']."
secure=0";

}else if(isset($_POST['article_page']) && $_POST['article_page']== '1'){ //For creating article menu
$_POST['Menu']['params'] =
"show_noauth=
show_title=
link_titles=
show_intro=
show_section=
link_section=
show_category=
link_category=
show_author=
show_create_date=0
show_modify_date=0
show_item_navigation=
show_readmore=
show_vote=
show_icons=
show_pdf_icon=
show_print_icon=
show_email_icon=
show_hits=
feed_summary=
page_title=
show_page_title=1
pageclass_sfx=
menu_image=".$_POST['menu_icon']."
secure=0";

}else if(isset($_POST['article_id']) && $_POST['article_id']!=NULL){ 
$_POST['Menu']['params'] =
"show_noauth=
show_title=
link_titles=
show_intro=
show_section=
link_section=
show_category=
link_category=
show_author=
show_create_date=0
show_modify_date=0
show_item_navigation=
show_readmore=
show_vote=
show_icons=
show_pdf_icon=
show_print_icon=
show_email_icon=
show_hits=
feed_summary=
page_title=
show_page_title=1
pageclass_sfx=
menu_image=".$_POST['menu_icon']."
secure=0";

}else if(isset($_POST['catid_list']) && $_POST['catid_list'] != ''){ //For creating location menu
	$_POST['catid_list']	= implode('|',$_POST['catid_list']);
	$_POST['Menu']['link']	= 'index.php?option=com_jevlocations&task=locations.locations';
	$_POST['Menu']['params']=
"catfilter=".$_POST['catid_list']."
menu_image=".$_POST['menu_icon'];

}else if($_POST['Menu']['componentid']==50) { //For updating photos menu
	if(array_key_exists('hide_categories', $_POST)) {
		$_POST['hide_categories'] = implode(';',$_POST['hide_categories']);
	}else{ 
		$_POST['hide_categories'] ='';
	}
	if(isset($_POST['phoca_cat_id']) && $_POST['phoca_cat_id']!=''){ //For updating vidoes menu
	$_POST['Menu']['params'] =
"show_pagination_categories=0
show_pagination_category=0
show_pagination_limit_categories=0
show_pagination_limit_category=0
display_image_categories=1
detail_window=4
menu_image=".$_POST['menu_icon'];
	}else{
		$_POST['Menu']['params'] =
"image=-1
image_align=right
show_pagination_categories=0
show_pagination_category=0
show_pagination_limit_categories=0
show_pagination_limit_category=0
display_image_categories=1
hide_categories=".$_POST['hide_categories']."
detail_window=6
menu_image=".$_POST['menu_icon'];
}

}else if($_POST['Menu']['componentid']==126) {
	if($_POST['relative']=='week'){ //For creating Event week listing menu
	$_POST['Menu']['link'] = 'index.php?option=com_jevents&view=week&task=week.listevents';
	$_POST['Menu']['params'] =
"com_calViewName=geraint
com_calUseIconic=
catid0=".$_POST['EventcatData']."
catid1=0
catid2=0
catid3=0
catid4=0
catid5=0
catid6=0
catid7=0
catid8=0
catid9=0
catid10=0
extras0=
extras1=
extras2=
extras3=
showyearpast=
layout=
page_title=".$_POST['Pagemeta']['title']."
show_page_title=0
pageclass_sfx=
menu_image=".$_POST['menu_icon']."
secure=0";
	}elseif($_POST['relative']=='strtotime' || $_POST['relative']=='rel'){ //For creating Event monthly listing menu
			$_POST['Menu']['params'] =
"relative=".$_POST['relative']."
absstart=
absend=
relstart=".$_POST['relstart']."
relend=".$_POST['relend']."
strstart=".$_POST['strstart']."
strend=".$_POST['strend']."
com_calViewName=geraint
com_calUseIconic=
catid0=".$_POST['EventcatData']."
catid1=0
catid2=0
catid3=0
catid4=0
catid5=0
catid6=0
catid7=0
catid8=0
catid9=0
catid10=0
extras0=
extras1=
extras2=
extras3=
showyearpast=0
layout=
page_title=".$_POST['Pagemeta']['title']."
show_page_title=0
pageclass_sfx=
menu_image=".$_POST['menu_icon']."
secure=0";
}

}else{
	$_POST['Menu']['params'] = "menu_image=".$_POST['menu_icon'];
}
			
			$model->attributes=$_POST['Menu'];
			
			if($model->save()){
				// remove addloation session after add event
				if(Yii::app()->session['addCatFromMenu']){
					unset(Yii::app()->session['addCatFromMenu']);
				}
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Your Menu created successfully.');
				$this->redirect(array('/menu'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Menu']))
		{
			
			if($model->home == 1 && $_POST['Menu']['published'] == 0){
				Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="color:#d9534f;font-size:16px;"></i><strong> Sorry!! </strong> You can not unpublished default menu.');
				$this->redirect(array('/menu'));
			}else{
							$_POST['Menu']['alias']   = strtolower(str_replace(' ','-',$_POST['Menu']['name']));
							//Updating page-title,meta description and keywords
							if(isset($_POST['Pagemeta']) AND $_POST['Pagemeta']!='')
							{
								if($_POST['Menu']['alias'] == 'home') {
									$menu_alias = 'index.php';
								}else{
									$menu_alias = $_POST['Menu']['alias'];
								}
								if($_POST['Menu']['parent']!='0'){
									$get_parent_name = Menu::model()->findByAttributes(array('id'=>$_POST['Menu']['parent']));
									if(isset($get_parent_name) AND $get_parent_name!='')
									{
										$parent_name = $get_parent_name->alias;
									}
								}
								if(isset($parent_name) AND $parent_name!=''){
									$page_metas = Pagemeta::model()->findByAttributes(array('uri'=>'/'.$parent_name.'/'.$menu_alias));
								}else{
									$page_metas = Pagemeta::model()->findByAttributes(array('uri'=>'/'.$menu_alias));
								}
								
								if(isset($page_metas) AND $page_metas!=''){
									if(isset($parent_name) AND $parent_name!=''){
										$page_metas->uri 		= '/'.$parent_name.'/'.$menu_alias;
									}else{
										$page_metas->uri 		= '/'.$menu_alias;
									}
									$page_metas->title 		= $_POST['Pagemeta']['title'];
									$page_metas->metadesc 	= $_POST['Pagemeta']['metadesc'];
									$page_metas->keywords 	= $_POST['Pagemeta']['keywords'];
									$page_metas->save();
								}else{
									$new_page_metas = new Pagemeta;
									if(isset($parent_name) AND $parent_name!=''){
										$new_page_metas->uri 		= '/'.$parent_name.'/'.$menu_alias;
									}else{
										$new_page_metas->uri 		= '/'.$menu_alias;
									}
									$new_page_metas->title 		= $_POST['Pagemeta']['title'];
									$new_page_metas->metadesc 	= $_POST['Pagemeta']['metadesc'];
									$new_page_metas->keywords 	= $_POST['Pagemeta']['keywords'];
									$new_page_metas->save();
								}
							}
							
							if(isset($_POST['Menu']['parent']) AND $_POST['Menu']['parent']!='')
							{
								$_POST['menu_icon']='';
							}else{
								$_POST['menu_icon'] = $_POST['menu_icon'];
							}
							$_POST['Menu']['parent']  = empty($_POST['Menu']['parent'])?0:$_POST['Menu']['parent'];
							$_POST['menu_icon']  =	isset($_POST['Menu']['parent'])?$_POST['menu_icon']:'';
							
if(isset($_POST['intro']) && $_POST['intro']!=''){ //For updating frontpage/section menu
$_POST['Menu']['params']  =
"show_description=0
show_description_image=0
num_leading_articles=0
num_intro_articles=".$_POST['intro']."
num_columns=1
num_links=0
orderby_pri=
orderby_sec=".$_POST['orderby_sec']."
multi_column_order=1
show_pagination=2
show_pagination_results=1
show_feed_link=1
show_noauth=
show_title=
link_titles=1
show_intro=1
show_section=
link_section=
show_category=
link_category=
show_author=
show_create_date=0
show_modify_date=0
show_item_navigation=
show_readmore=
show_vote=
show_icons=
show_pdf_icon=
show_print_icon=
show_email_icon=
show_hits=
feed_summary=
page_title=
show_page_title=1
pageclass_sfx=
menu_image=".$_POST['menu_icon'];

}else if(isset($_POST['article_id']) && $_POST['article_id']!=''){ //For updating article menu
$_POST['Menu']['params'] =
"show_noauth=
show_title=
link_titles=
show_intro=
show_section=
link_section=
show_category=
link_category=
show_author=
show_create_date=0
show_modify_date=0
show_item_navigation=
show_readmore=
show_vote=
show_icons=
show_pdf_icon=
show_print_icon=
show_email_icon=
show_hits=
feed_summary=
page_title=
show_page_title=1
pageclass_sfx=
menu_image=".$_POST['menu_icon']."
secure=0";

}else if(isset($_POST['catid_list']) && $_POST['catid_list']!=''){ //For updating location menu
$_POST['catid_list'] = implode('|',$_POST['catid_list']);
$_POST['Menu']['params'] =
"catfilter=".$_POST['catid_list']."
menu_image=".$_POST['menu_icon'];

}else if($_POST['Menu']['componentid']==50) { //For updating photos menu
	if(array_key_exists('hide_categories', $_POST)) {
		$_POST['hide_categories'] = implode(';',$_POST['hide_categories']);
	}else{ 
		$_POST['hide_categories'] ='';
	}
	if(isset($_POST['phoca_cat_id']) && $_POST['phoca_cat_id']!=''){ //For updating vidoes menu
	$_POST['Menu']['params'] =
"show_pagination_categories=0
show_pagination_category=0
show_pagination_limit_categories=0
show_pagination_limit_category=0
display_image_categories=1
detail_window=4
menu_image=".$_POST['menu_icon'];
	}else{
	$_POST['Menu']['params'] =
"image=-1
image_align=right
show_pagination_categories=0
show_pagination_category=0
show_pagination_limit_categories=0
show_pagination_limit_category=0
display_image_categories=1
hide_categories=".$_POST['hide_categories']."
detail_window=6
menu_image=".$_POST['menu_icon'];
}

}else if($_POST['Menu']['componentid']==126) {
	if($_POST['relative']=='week'){ //For creating eEvent week listing menu
	$_POST['Menu']['link'] = 'index.php?option=com_jevents&view=week&task=week.listevents';
	$_POST['Menu']['params'] = 
"com_calViewName=geraint
com_calUseIconic=
catid0=".$_POST['EventcatData']."
catid1=0
catid2=0
catid3=0
catid4=0
catid5=0
catid6=0
catid7=0
catid8=0
catid9=0
catid10=0
extras0=
extras1=
extras2=
extras3=
showyearpast=0
layout=
page_title=".$_POST['Pagemeta']['title']."
show_page_title=0
pageclass_sfx=
menu_image=".$_POST['menu_icon']."
secure=0";
	}else if($_POST['relative']=='strtotime' || $_POST['relative']=='rel'){
	$_POST['Menu']['params'] =
"relative=".$_POST['relative']."
absstart=
absend=
relstart=".$_POST['relstart']."
relend=".$_POST['relend']."
strstart=".$_POST['strstart']."
strend=".$_POST['strend']."
com_calViewName=geraint
com_calUseIconic=
catid0=".$_POST['EventcatData']."
catid1=0
catid2=0
catid3=0
catid4=0
catid5=0
catid6=0
catid7=0
catid8=0
catid9=0
catid10=0
extras0=
extras1=
extras2=
extras3=
showyearpast=0
layout=
page_title=".$_POST['Pagemeta']['title']."
show_page_title=0
pageclass_sfx=
menu_image=".$_POST['menu_icon']."
secure=0";
}

}else{
	$_POST['Menu']['params'] = "menu_image=".$_POST['menu_icon'];
}

if($_POST['Menu']['alias'] == 'home'){
	$_POST['Menu']['alias'] = 'index.php';
}
$page_metas = Pagemeta::model()->findByAttributes(array('uri'=>'/'.$_POST['Menu']['alias']));
if(isset($page_metas) AND $page_metas!=''){
	$page_metas->title = $_POST['Pagemeta']['title'];
}
							
							$model->attributes=$_POST['Menu'];
							if($model->save()){
								Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i><strong>Success!</strong> Your Menu updated successfully.');
								$this->redirect(array('/menu'));
							}
			} // If defualt menu is not unpublished then allow to save data
			
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		# IF default menu is set then you can not delete
		if($model->home == 1){
			 echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><span style="color:#d9534f;"><strong> Sorry!! </strong> You can not delete default menu.</span>';
		}elseif(strpos($model->link,'view=frontpage') !== false){
			 echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><span style="color:#d9534f;"><strong> Sorry!! </strong> You can not delete front page menu.</span>';
		}elseif($this->actionFindChildren($id)){
			$menuName = $model->name;
			echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><span style="color:#d9534f;"><strong> Sorry!! </strong> Category(ies): '.$menuName.' cannot be removed as they contain Articles. There may currently be Articles within the Article Trash Manager which you must delete first..</span>';
		}else{
			try{
			    $this->loadModel($id)->delete();
			    if(!isset($_GET['ajax']))
			        Yii::app()->user->setFlash('success','<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Menu deleted successfully.');
			    else
			        echo '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Menu deleted successfully.';
			}catch(CDbException $e){
				    if(!isset($_GET['ajax']))
				        Yii::app()->user->setFlash('error','Normal - error message');
				    else
				        echo "<div class='flash-error'>Ajax - error message</div>"; //for ajax
			}
		}
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		# CODE FOR SET PAGE SIZE START
		if ( isset( $_GET[ 'pageSize' ] ) )
		{
			Yii::app()->user->setState( 'pageSizeMenu', (int) $_GET[ 'pageSize' ] );
			unset( $_GET[ 'pageSize' ] );
		}
		# CODE FOR SET PAGE SIZE END
		
		$model=new Menu('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Menu']))
			$model->attributes=$_GET['Menu'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->redirect(array('index'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Menu the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Menu::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Menu $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	* Function to change Menu status from Active to Inactive and Vice versa
	* Developer: Rinkal 
	*/	
	 public function actionUpdatestatus($id) {
		$newStatus = ($_REQUEST['status'] == 1)?0:1;
        $model = Menu::model()->findByPk($id);
		
		if($model->home == 1 && $newStatus == 0){
			Yii::app()->user->setFlash('fail', '<i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><strong> Sorry!! </strong> You can not unpublishe default menu.');
		}else{
			$model->published = $newStatus;
        	$model->save();
        	Yii::app()->user->setFlash('success', '<i class="glyphicon glyphicon-circle-exclamation-mark"></i><strong> Success! </strong> Menu status updated successfully.');
		}
		$this->redirect(array('/menu'));
        
    }
	/**
	* Function To modify menu via CHECKBOX SELECTION
	* Developer: rinkal 
	*/
	public function actionAjaxupdate(){

		$act = $_GET['act'];
		if($act == 'doSortOrder'){
	
		    $sortOrderAll = $_POST['ordering'];
		    
		    if(count($sortOrderAll) > 0){
		        foreach($sortOrderAll as $id => $ordering){
		            $model = $this->loadModel($id);
		            $model->ordering = $ordering;
		            $model->save();
		        }
		       echo $msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Menu order updated successfully.';
		    }
		}else{           
		    $autoIdAll = $_POST['autoId'];
		    if(count($autoIdAll)>0){
		        foreach($autoIdAll as $autoId){
		            $model = $this->loadModel($autoId);
		            if($act == 'doDelete'){
						if($model->home == 1){
							$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><span style="color:#d9534f;"><strong> Sorry!! </strong> You can not delete default menu.</span>';
						}elseif(strpos($model->link,'view=frontpage') !== false){
							$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><span style="color:#d9534f;"><strong> Sorry!! </strong> You can not delete front page menu.</span>';
						}elseif($this->actionFindChildren($autoId)){
							$menuName = $model->name;
							$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><span style="color:#d9534f;"><strong> Sorry!! </strong> Category(ies): '.$menuName.' cannot be removed as they contain Articles. There may currently be Articles within the Article Trash Manager which you must delete first..</span>';
						}else{
							$model->delete();
							$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Menu deleted successfully.';
						}
					}
		            if($act == 'doActive'){
		                $model->published = '1';
						$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Menu published successfully.';					
					}
		            if($act == 'doInactive'){
						if($model->home == 1){
							$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-circle-exclamation-mark" style="color:#d9534f;font-size: 16px;"></i><strong> Sorry!! </strong> You can not unpublished default menu.';
						}else{
							$model->published = '0';                     
							$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Menu unpublished successfully.';
						}
					}
					if($act=='default'){
						$default_id = Menu::model()->findByAttributes(array('home'=>1));
						if(isset($default_id) && $default_id!=''){
							$default_id->home=0;
							$default_id->save();
							$model->home = 1;
							$msg = '<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&nbsp;×</span><span class="sr-only">Close</span></button><i class="glyphicon glyphicon-ok-sign" style="font-size: 16px;"> </i>&nbsp;<strong>Success!</strong> Your Menu is default successfully.';
						}
					}
		            if($model->save())
		               echo '';
		            else
		                throw new Exception("Sorry",500);
		        }
				echo $msg;
		    }
		}
	} // Ending Function
	
	/**
	* check menu if it has child cat or not
	* @param int $id
	* @param int $level
	* 
	* @return bool true if child else false
	*/
	public function actionFindChildren($id,$level = 0)
	{
		$return = FALSE;
		if((int)$level > 0){
			$return = true;
		}
		if((int)$level == 0){
			$criteria = new CDbCriteria;
	        $criteria->condition='parent=:id';
	        $criteria->params=array(':id'=>$id);
	        $model = Menu::model()->findAll($criteria);
			foreach ($model as $key) {
				$return = $this->actionFindChildren($key->id, (int)$level+1);
			}
		}
		return $return;
	}

}
