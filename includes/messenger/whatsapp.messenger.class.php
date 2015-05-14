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

class whatsapp_messenger extends generic_messenger {
	
	private $objJabber = null;
	
	public function sendMessage($toUserID, $strSubject, $strMessage){
		if(!$this->isAvailable()) return false;
		
		$intUserID = $toUserID;
		
		$strPhoneNumber = $this->pdh->get('user', 'profilefield_by_name', array($intUserID, 'mobile'));
		
		if($strPhoneNumber && $strPhoneNumber != ""){
			$strPhoneNumber = $this->convert_phonenumber($strPhoneNumber);
			if(!$strPhoneNumber) return false;
			
			include_once $this->root_path.'plugins/whatsapp/includes/lib/chatapi/whatsprot.class.php';
			
			$username = $this->config->get('whatsapp_number');  // Your number with country code, ie: 34123456789
			$nickname = "EQdkp Plus"; // Your nickname, it will appear in push notifications
			$debug = false;  // Shows debug log
			$pw = $this->config->get('whatsapp_password');

			$w = new WhatsProt($username, $nickname, $debug);
			
			$w->connect();
			$w->loginWithPassword($pw);
			
			//$strMessage = strip_tags($strMessage);
			
			$arrMessages = explode('____', $strMessage);
			foreach($arrMessages as $strMessage){
				$w->sendMessage($strPhoneNumber, $strMessage);
			}
			
			$w->disconnect();
			
			return true;
		}
		
		return false;
	}
	
	public function getAdminSettings(){
		return array();
	}
	
	/* 
	 * @see generic_notification::getUserSettings()
	 */
	public function getUserSettings(){
		return array();
	}
	
	/* 
	 * @see generic_notification::isAvailable()
	 */
	public function isAvailable(){
		if($this->config->get('whatsapp_number') != "" && $this->config->get('whatsapp_password') != ""){
			return true;
		}
		
		return false;
	}
	
	private function convert_phonenumber($strNumber){
		if(strpos($strNumber, "0") === 0){
			$strNumber = substr($strNumber, 1);
			if($this->config->get('whatsapp_defaultcountry') != ""){
				$strNumber = $this->config->get('whatsapp_defaultcountry').$strNumber;
			} else return false;
		}
		
		$strNumber = preg_replace("/[^0-9]/", "", $strNumber);
		return $strNumber;
	}
}