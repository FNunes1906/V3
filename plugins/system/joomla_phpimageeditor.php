<?php
    

	    /*
	    Copyright 2008, 2009, 2010, 2011 Patrik Hultgren
	    
	    YOUR PROJECT MUST ALSO BE OPEN SOURCE IN ORDER TO USE THIS VERSION OF PHP IMAGE EDITOR.
	    BUT YOU CAN USE PHP IMAGE EDITOR JOOMLA PRO IF YOUR CODE NOT IS OPEN SOURCE.
	    
	    This file is part of PHP Image Editor Joomla.
	
	    PHP Image Editor Joomla is free software: you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation, either version 3 of the License, or
	    (at your option) any later version.
	
	    PHP Image Editor Joomla is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.
	
	    You should have received a copy of the GNU General Public License
	    along with PHP Image Editor Joomla. If not, see <http://www.gnu.org/licenses/>.
	    */
	

	// no direct access
	defined( '_JEXEC' ) or die( 'Restricted access' );

	function PIE_ShowEditLinks() 
	{
		$show_edit_link = ((isset($_GET['view']) && isset($_GET['option']) && $_GET['option'] == 'com_media' && (
			$_GET['view'] == 'images' || 							//Frontend article
			$_GET['view'] == 'mediaList' || 						//Backend Media Manager
			$_GET['view'] == 'imagesList')) ||						//Backend article 
			(isset($_GET['view']) && $_GET['view'] == 'imagesList')	//Frontend folder click
			); 	

		return $show_edit_link;
	}
	
	function PIE_AddEditJavascript() 
	{
		global $mainframe;
		$admin_path = $mainframe->isAdmin() ? '../' : '';

		$config =& JFactory::getConfig();
		
		$language = $config->getValue('config.language');
		
        $languagePathCurrent = $admin_path."plugins/system/phpimageeditor/language/".$language.".ini";
        
        $languageEnglish = 'en-GB';
        $languagePathEnglish = $admin_path."plugins/system/phpimageeditor/language/".$languageEnglish.".ini";

        $texts = array();

        if (file_exists($languagePathCurrent))
            $texts = PIE_GetTexts($languagePathCurrent);
        else if (file_exists($languagePathEnglish))
        {
            $texts = PIE_GetTexts($languagePathEnglish);
            $language = $languageEnglish;
        }
            
        if (count($texts) > 0)          
        {
            $hostPath = str_replace("administrator/", "", JURI::base());
            
            $version = new JVersion();
            
            $document = &JFactory::getDocument();
            $document->addScript($admin_path.'plugins/system/phpimageeditor/lite/shared/javascript/edit_link.js?a=2');
            $document->addScriptDeclaration("var PIE_SYSTEM_VERSION = '".$version->getShortVersion()."';");
            $document->addScriptDeclaration("window.addEvent('domready', function(){phpimageeditor_add_editlink('".$admin_path."plugins/system/phpimageeditor/index.php?isadmin=".($mainframe->isAdmin() ? "true" : "false")."&imagesrc=','".$admin_path."plugins/system/phpimageeditor/','".$hostPath."','".htmlspecialchars($texts["EDIT IMAGE"], ENT_QUOTES)."','".$language."', '".str_replace("\\", "\\\\", JPATH_SITE.DIRECTORY_SEPARATOR)."');});");
        }
	}
	
	global $mainframe;

	$admin_path = $mainframe->isAdmin() ? '../' : '';
	include_once JPATH_BASE.'/'.$admin_path.'plugins/system/phpimageeditor/lite/shared/includes/constants.php';
	include_once JPATH_BASE.'/'.$admin_path.'plugins/system/phpimageeditor/lite/shared/config.php';
	include_once JPATH_BASE.'/'.$admin_path.'plugins/system/phpimageeditor/lite/shared/includes/acl_functions.php';

	$user =& JFactory::getUser();

	if (PIE_Access($user) && PIE_ShowEditLinks()) 	
	{
		include_once JPATH_BASE.'/'.$admin_path.'plugins/system/phpimageeditor/lite/shared/includes/functions.php';
		jimport('joomla.plugin.plugin');
		$mainframe->registerEvent('onAfterInitialise', 'PIE_AddEditJavascript');
	}

?>