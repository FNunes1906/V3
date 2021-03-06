<?php
/**
 * @package AkeebaBackup
 * @subpackage BackupIconModule
 * @copyright Copyright (c)2009-2010 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @since 2.2
 * @version $Id: mod_akadmin.php 74 2010-02-28 18:47:28Z nikosdion $
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Make sure Akeeba Backup is installed, or quit
$akeeba_installed = @file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_akeeba'.DS.'akeeba'.DS.'factory.php');
if(!$akeeba_installed) return;

// Make sure Akeeba Backup is enabled
jimport('joomla.application.component.helper');
if (!JComponentHelper::isEnabled('com_akeeba', true))
{
	JError::raiseError('E_JPNOTENABLED', JText('AKEEBA_NOT_ENABLED'));
	return;
}

// Set default parameters
$params->def('enablewarnings', 0); // Enable warnings
$params->def('warnfailed', 0); // Warn if backup is failed
$params->def('maxbackupperiod', 24); // Maximum time between backups, in hours

// Load custom CSS
$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::base().'modules/mod_akadmin/css/mod_akadmin.css');

// Initialize defaults
$lang =& JFactory::getLanguage();
$image = "akeeba-48.png";
$label = JText::_('LBL_AKEEBA');

if( $params->get('enablewarnings', 0) == 0 )
{
	// Process warnings
	$warning = false;

	// Get latest backup ID
	$db =& JFactory::getDBO();
	$query = 'SELECT max(id) FROM #__ak_stats';
	$db->setQuery($query);
	$id = $db->loadResult();
	unset($query);

	// Only proceed if there is a latest backup entry!
	if(!empty($id))
	{
		$query = "SELECT * FROM #__ak_stats WHERE `id`".
				" = ".$id;
		$db->setQuery($query);
		$db->query();
		$record = $db->loadObject();
	}
	else
	{
		$record = null;
	}
	unset($query, $db);

	// Process "failed backup" warnings, if specified
	if( $params->get('warnfailed', 0) == 0 )
	{
		if(!empty($id))
		{
			$warning = (($record->status == 'fail') || ($record->status == 'run'));
		}
	}

	// Process "stale backup" warnings, if specified
	if(empty($id))
	{
		$warning = true;
	}
	else
	{
		$maxperiod = $params->get('maxbackupperiod', 24);
		jimport('joomla.utilities.date');
		$lastBackupRaw = $record->backupstart;
		$lastBackupObject = new JDate($lastBackupRaw);
		$lastBackup = $lastBackupObject->toUnix(false);
		$maxBackup = time() - $maxperiod * 3600;
		if(!$warning) $warning = ($lastBackup < $maxBackup);
	}

	if($warning)
	{
		$image = 'akeeba-warning-48.png';
		$label = JText::_('LBL_BACKUPREQUIRED');
	}
}

// Load the Akeeba Backup configuration and check user access permission
define('AKEEBAENGINE', 1); // Required for accessing Akeeba Engine's factory class
define('AKEEBAPLATFORM', 'joomla15'); // So that platform-specific stuff can get done!
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_akeeba'.DS.'akeeba'.DS.'factory.php';
$registry =& AEFactory::getConfiguration();
$user =& JFactory::getUser();
$gid = $user->gid;
$showModule = true;
unset($registry);
unset($user);

// Administrator access allowed
if( ($gid != 25) && ($gid != 24) )
{
	$showModule = false;
}

if($showModule):
?>
<div class="akcpanel">
<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
<div class="icon"><a href="index.php?option=com_akeeba&view=backup">
<img src="components/com_akeeba/assets/images/<?php echo $image ?>" />
<span><?php echo $label; ?></span> </a></div>
</div>
</div>
<?php endif; ?>