<?php
/*	Project:	EQdkp-Plus
 *	Package:	MediaCenter Plugin
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

if (!defined('EQDKP_INC'))
{
    header('HTTP/1.0 404 Not Found');exit;
}

$lang = array(
	'whatsapp'                  => 'WhatsApp',

 	 // Description
  	'whatsapp_short_desc'       => 'WhatsApp',
  	'whatsapp_long_desc'        => 'Integrates WhatsApp for Notifications and Massmails',
  	'wa_plugin_not_installed'	=> 'The WhatsApp-Plugin is not installed.',
  
	'wa_settings_info'			=> 'The Setup for WhatsApp contains two steps. In the first step, you have to enter your WhatsApp Number. After that, you will get a SMS with a confirmation code you have to enter at the next step.',
	'wa_phonenumber'			=> 'WhatsApp-Number',
	'wa_phonenumber_help'		=> 'Insert here your WhatsApp Number, including the country code (e.g. 49 for Germany), but without the leading +. Example: 49150123456',
		
	'wa_default_country'		=> 'Default Country Code',
	'wa_default_country_help'	=> 'Insert here the default country code (e.g. 49 for Germany) that should be used for user that don\'t have inserted their number with a country code.',
	'wa_step1_error'			=> 'An error occured. Please check your numbers.',
	'wa_phonecode'				=> 'WhatsApp Confirmation Code',
	'wa_phonecode_help'			=> 'Insert here the confirmation code that was sent to you by SMS.',
	'wa_step2_finished'			=> 'WhatsApp was setup successfully.',
	'wa_settings_warning'		=> 'Please note that you can use a WhatApp Number on one device only. That means, if you setup your WhatApp Number in EQdkp Plus, you cannot use it anymore in parallel at your phone (but can be setup again at your phone at any time).',
		
 );

?>
