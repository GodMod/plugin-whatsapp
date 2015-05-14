<?php
/*	Project:	EQdkp-Plus
 *	Package:	EQdkp-plus
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2015 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class whatsapp_notification extends generic_notification {
		
	public function sendNotification($arrNotificationData){
		if(!$this->isAvailable()) return false;
		
		$intUserID = $arrNotificationData['to_userid'];
		$strPhoneNumber = $this->pdh->get('user', 'profilefield_by_name', array($intUserID, 'mobile'));
		
		if(!$strPhoneNumber|| $strPhoneNumber == "") return false;

		$strSubject = $this->user->lang('new_notification', false, false, $this->pdh->get('user', 'lang', array($arrNotificationData['to_userid']))).': '.$arrNotificationData['type_lang'];
		$strMessage = $strSubject."\n\n".$arrNotificationData['name']."____".$arrNotificationData['link'];
		
		$this->messenger->sendMessage('whatsapp', $intUserID, "", $strMessage);
	}
	
	public function getAdminSettings(){
		return $this->messenger->getMethodAdminSettings('whatsapp');
	}
	
	/* 
	 * @see generic_notification::getUserSettings()
	 */
	public function getUserSettings(){
		return $this->messenger->getMethodUserSettings('whatsapp');
	}
	
	/* 
	 * @see generic_notification::isAvailable()
	 */
	public function isAvailable(){
		return $this->messenger->isAvailable('whatsapp');
	}
}