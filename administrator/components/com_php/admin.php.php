<?php
/**
 * @author gabe@fijiwebdesign.com
 * @copyright (c) fijiwebdesign.com
 * @license http://www.fijiwebdesign.com/
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once($mainframe->getPath('admin_html'));

// load needed HTTP variables
$task = JRequest::getVar('task', 'index');

/**
 * Controller
 */
switch ($task) {
	case 'edit':
	com_php_tasks::edit();
	break;
	case 'save':
	com_php_tasks::save();
	break;
	case 'apply':
	com_php_tasks::apply();
	break;
	case 'delete':
	com_php_tasks::del();
	break;
	case 'new':
	com_php_tasks::add();
	break;
	case 'create':
	com_php_tasks::create();
	break;
	case 'about':
	com_php_tasks::about();
	break;
	case 'help':
	com_php_tasks::help();
	break;
	case 'config':
	com_php_tasks::config();
	break;
	default:
	com_php_tasks::index();
	break;
}

if (!JRequest::getVar('no_html')) {
	com_php_adminHTML::footer();
}

/**
 * Static List of Task methods
 */
class com_php_tasks {
	
	/**
	 * List the PHP Files
	 */
	function index() {
		global $mainframe;
		
		$abs_path = JPATH_ROOT;
		$dir = $abs_path.'/components/com_php/files/';
		
		// retrieve files
		$files = array();
		$dh = opendir($dir);
		while($el = readdir($dh)) {
			$path = $dir.'/'.$el;
			if ($el[0] != '.' && is_file($path)) {
				$files[] = $el;
			}
		}
		
		
		// render html
		com_php_adminHTML::index($files);
	}
	
	/**
	 * Edit a File
	 */
	function edit() {
		global $mainframe;
		
		$abs_path = JPATH_ROOT;
		$file = JRequest::getVar('file', false);
		$path = $abs_path.'/components/com_php/files/'.$file;
		
		
		if (!$file) {
			echo 'File not specified.';
			return;
		}
		
		// this won't handle very large files. todo
		$content = '';
		if ($fp = fopen($path, 'r')) {
			while($buf = fread($fp, 2082)) {
				$content .= $buf;
			}
			fclose($fp);
		}
		
		// render html
		com_php_adminHTML::edit($file, $content);
		
	}
	
	/**
	 * Save a File, return to index
	 */
	function save() {
		global $mainframe;
		
		$file = JRequest::getVar('file', false);
		
		$content = '';
		$raw = file_get_contents('php://input');
		if ($raw) {
			preg_match("/content=([^&]+)/i", $raw, $match);
			$content = urldecode($match[1]);
		}
		
		if (com_php_tasks::_save($file, $content)) {
			$mainframe->redirect('index2.php?option=com_php&task=index', 'Changes Saved');
		} else {
			$mainframe->redirect('index2.php?option=com_php&task=index', 'Error: File Could not be saved.');
		}
	}
	
	/**
	 * Save a File return to File Edit
	 */
	function apply() {
		global $mainframe;
		
		$file = JRequest::getVar('file', false);

		$content = '';
		$raw = file_get_contents('php://input');
		if ($raw) {
			preg_match("/content=([^&]+)/i", $raw, $match);
			$content = urldecode($match[1]);
		}

		if (com_php_tasks::_save($file, $content)) {
			$mainframe->redirect('index2.php?option=com_php&task=edit&file='.$file, 'Changes Applied');
		} else {
			$mainframe->redirect('index2.php?option=com_php&task=edit&file='.$file, 'Error: File Could not be saved.');
		}
	}
	
	/**
	 * Save the File
	 */
	function _save($file, &$content) {
		global $mainframe;

		$path = JPATH_ROOT.'/components/com_php/files/'.$file;

		if (!$file) {
			echo 'File not specified.';
			return;
		}
		
		if ($fp = fopen($path, 'w')) {
			fwrite($fp, $content, strlen($content));
			fclose($fp);
			return true;
		} else {
			return false;
		}

	}
	
	/**
	 * Add a File
	 */
	function add() {
		com_php_adminHTML::add();
	}
	
	/**
	 * create the File
	 */
	function create() {
		global $mainframe;
		
		$file = JRequest::getVar('file', false);
		$path = JPATH_ROOT.'/components/com_php/files/'.$file;
		
		if (!$file) {
			echo 'File not specified.';
			return;
		}
		
		// create the file
		$fp = fopen($path, 'w+');
		if (!$fp) {
			$mainframe->redirect('index2.php?option=com_php', 'Error: The File could not be created.');
		} else {
			fwrite("<?php\n\n/** Some PHP */\n\n?>");
			fclose($fp);
			$mainframe->redirect('index2.php?option=com_php&task=edit&file='.$file);
		}
		
	}
	
	/**
	 * Del a File
	 */
	function del() {
		global $mainframe;
		
		$file = JRequest::getVar('file', false);
		$path = JPATH_ROOT.'/components/com_php/files/'.$file;
		
		if (!$file) {
			echo 'File not specified.';
			return;
		}
		
		$res = unlink($path);
		if (!$res) {
			$mainframe->redirect('index2.php?option=com_php', 'The File could not be deleted.', 'error');
		} else {
			$mainframe->redirect('index2.php?option=com_php', 'File was deleted.');
		}
		
	}
	
	/**
	 * Handles the Saving and deleting of configuration
	 */
	function config() {
		// older php has not json support
		require_once(JPATH_ADMINISTRATOR . '/components/com_php/compat.php');
		
		$config = JRequest::getVar('config');
		$config_path = JPATH_SITE . '/components/com_php/files/.config';
		
		// save the json file, or read it based on passed parameter
		if ($config) {
			file_put_contents($config_path, $config);
		} else {
			$config = file_get_contents($config_path);
		}
		
		echo $config;
		
	}
	
	/**
	 * About the PHP Component
	 */
	function about() {
		com_php_adminHTML::about();
	}
	
	/**
	 * Help
	 */
	function help() {
		com_php_adminHTML::help();
	}
	
}




?>
