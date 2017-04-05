<?php
/*
 *      User Mail Restriction Plug-in
 *      @package User Mail Restriction Plug-in
 *      @subpackage Content
 *      @author José António Cidre Bardelás
 *      @copyright Copyright (C) 2013 José António Cidre Bardelás and Joomla Empresa. All rights reserved
 *      @license GNU/GPL v3 or later
 *      
 *      Contact us at info@joomlaempresa.com (http://www.joomlaempresa.es)
 *      
 *      This file is part of User Mail Restriction Plug-in.
 *      
 *          User Mail Restriction Plug-in is free software: you can redistribute it and/or modify
 *          it under the terms of the GNU General Public License as published by
 *          the Free Software Foundation, either version 3 of the License, or
 *          (at your option) any later version.
 *      
 *          User Mail Restriction Plug-in is distributed in the hope that it will be useful,
 *          but WITHOUT ANY WARRANTY; without even the implied warranty of
 *          MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *          GNU General Public License for more details.
 *      
 *          You should have received a copy of the GNU General Public License
 *          along with User Mail Restriction Plug-in.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgUserMailRestriction extends JPlugin {
    function onUserBeforeSave($user, $isnew, $new) {
        JFactory::getLanguage()->load('plg_user_mailrestriction', JPATH_ADMINISTRATOR);
        $app = JFactory::getApplication();
        // New user or admin
        if (!$isnew || $app->isAdmin())
            return;
		$domains = explode(',', str_replace(array("\r\n", "\r", "\n", " "), '', $this->params->get('domains')));
		$emails = explode(',', str_replace(array("\r\n", "\r", "\n", " "), '', $this->params->get('emails')));
        $email = trim($new['email']);
        list(,$domain) = explode('@', strtolower($email));
        if (in_array($email, $emails) || in_array($domain, $domains)) {
            jexit(JText::_('PLG_USER_MAILRESTRICTION_DENY'));
        }
        $usernames = explode(',', str_replace(array("\r\n", "\r", "\n", " "), '', $this->params->get('usernames')));
        $username = trim($new['username']);
        if(in_array($username, $usernames)) {
            jexit(JText::_('PLG_USER_MAILRESTRICTION_DENY'));
        }
		return true;
	}
    function onBeforeStoreUser($user, $isnew) {
        JFactory::getLanguage()->load('plg_user_mailrestriction', JPATH_ADMINISTRATOR);
        $app = JFactory::getApplication();
        // New user or admin
        if (!$isnew || $app->isAdmin())
            return;

		$domains = explode(',', str_replace(array("\r\n", "\r", "\n", " "), '', $this->params->get('domains')));
		$emails = explode(',', str_replace(array("\r\n", "\r", "\n", " "), '', $this->params->get('emails')));

        $email = trim(JRequest::getVar('email'));
        list(,$domain) = explode('@', strtolower($email));
        if (in_array($email, $emails) || in_array($domain, $domains)) {
            jexit(JText::_('PLG_USER_MAILRESTRICTION_DENY'));
        }
        $usernames = explode(',', str_replace(array("\r\n", "\r", "\n", " "), '', $this->params->get('usernames')));
        $username = trim(JRequest::getVar('username'));
        if(in_array($username, $usernames)) {
            jexit(JText::_('PLG_USER_MAILRESTRICTION_DENY'));
        }
		return true;
    }
}
