<?php
/**
* @version 1.4.0
* @package RSform!Pro 1.4.0
* @copyright (C) 2007-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class RSFormViewRSForm extends JView
{
	function display($tpl = null)
	{		
		JToolBarHelper::title('RSForm! Pro','rsform');	
		$user	 = & JFactory::getUser();
		$usertype = $user->get('usertype');	
		
		//if (RSFormProHelper::isJ16())
		//{
			$lang =& JFactory::getLanguage();
			
			$lang->load('com_rsform.sys', JPATH_ADMINISTRATOR);
			
			JSubMenuHelper::addEntry(JText::_('COM_RSFORM_MANAGE_FORMS'), 'index.php?option=com_rsform&task=forms.manage');
			JSubMenuHelper::addEntry(JText::_('COM_RSFORM_MANAGE_SUBMISSIONS'), 'index.php?option=com_rsform&task=submissions.manage');
			JSubMenuHelper::addEntry(JText::_('COM_RSFORM_BACKUP_RESTORE'), 'index.php?option=com_rsform&task=backup.restore');
			if($usertype != 'TW_Admin'){
			JSubMenuHelper::addEntry(JText::_('COM_RSFORM_CONFIGURATION'), 'index.php?option=com_rsform&task=configuration.edit', true);
			JSubMenuHelper::addEntry(JText::_('COM_RSFORM_UPDATES'), 'index.php?option=com_rsform&task=updates.manage');
			JSubMenuHelper::addEntry(JText::_('COM_RSFORM_PLUGINS'), 'index.php?option=com_rsform&task=goto.plugins');
			}
			if (RSFormProHelper::isJ16() && $user->authorise('core.admin', 'com_rsform'))
				JToolBarHelper::preferences('com_rsform');
		//}
		
		$this->assign('code', RSFormProHelper::getConfig('global.register.code'));
		
		parent::display($tpl);
	}
}