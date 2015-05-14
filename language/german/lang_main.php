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
  'whatsapp'                    => 'WhatsApp',

  // Description
  'whatsapp_short_desc'         => 'WhatsApp',
  'whatsapp_long_desc'          => 'Integriert WhatsApp für Benachrichtigungen und Massenmails',
  
  'wa_plugin_not_installed'		=> 'Das WhatsApp-Plugin ist nicht installiert.',
  
	'wa_settings_info'			=> 'Die Einrichtung von WhatApp besteht aus mehreren Schritten. Im ersten Schritt musst du eine WhatsApp Nummer eingeben, von der aus die Nachrichten gesendet werden soll. Du erhältst eine SMS mit einem Bestätigungscode an diese Nummer, den du im nächsten Schritt eingeben musst.',
	'wa_phonenumber'			=> 'WhatsApp-Nummer',
	'wa_phonenumber_help'		=> 'Trage hier deine WhatApp-Nummer ein, inklusive Länderkennung (z.B. 49 für Deutschland), aber ohne dem führenden +. Beispiel: 49150123456',
		
	'wa_default_country'		=> 'Standard Ländervorwahl',
	'wa_default_country_help'	=> 'Trage hier die Standard Ländervorwahl ein (z.B. 49 für Deutschland, ohne führendes +), die verwendet werden soll, wenn die Benutzer keine Ländervorwahl angegeben haben.',
	'wa_step1_error'			=> 'Es ist ein Fehler aufgetreten. Bitte überprüfe die eingegebenen Nummern.',
	'wa_phonecode'				=> 'WhatsApp Bestätigungscode',
	'wa_phonecode_help'			=> 'Trage hier den Bestätigungscode ein, den WhatsApp dir per SMS an die angegebene Nummer geschickt hat',
	'wa_step2_finished'			=> 'WhatsApp wurde erfolgreich eingerichtet.',
	'wa_settings_warning'		=> 'Bitte beachte, dass du einen WhatsApp-Account nur auf jeweils auf einem Gerät nutzen kannst. Wenn du also den Account hier einrichtest, lässt sich WhatsApp nicht mehr auf deinem Handy etc. nutzen.',
 );

?>
