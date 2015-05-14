<?php
/*	Project:	EQdkp-Plus
 *	Package:	Local Itembase Plugin
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

// EQdkp required files/vars
define('EQDKP_INC', true);
define('IN_ADMIN', true);
define('PLUGIN', 'localitembase');

$eqdkp_root_path = './../../../';
include_once($eqdkp_root_path.'common.php');


/*+----------------------------------------------------------------------------
  | WhatsappSettings
  +--------------------------------------------------------------------------*/
class WhatsappSettings extends page_generic
{
  /**
   * __dependencies
   * Get module dependencies
   */
  public static function __shortcuts()
  {
    $shortcuts = array('pm', 'user', 'config', 'core', 'in', 'jquery', 'html', 'tpl');
    return array_merge(parent::$shortcuts, $shortcuts);
  }

  /**
   * Constructor
   */
  public function __construct()
  {
    // plugin installed?
    if (!$this->pm->check('whatsapp', PLUGIN_INSTALLED))
      message_die($this->user->lang('wa_plugin_not_installed'));

    $handler = array(
      'reset' => array('process' => 'reset', 'csrf' => true),
    );
	
	$this->user->check_auth('a_config_man');  
	
    parent::__construct(null, $handler);

    $this->process();
  }
  
  private $arrData = false;
  
  public function reset(){
  	$this->config->del('whatsapp_password');
  	$this->config->del('whatsapp_number');
  }


  /**
   * display
   * Display the page
   *
   * @param    array  $messages   Array of Messages to output
   */
  public function display($messages=array())
  {
    // -- Messages ------------------------------------------------------------
    if ($messages)
    {
      foreach($messages as $name)
        $this->core->message($name, $this->user->lang('localitembase'), 'green');
    }

    
    $step = "finished";
    if(!$this->config->get('whatsapp_password') || $this->config->get('whatsapp_password') == "" || !$this->config->get('whatsapp_number') || $this->config->get('whatsapp_number') == ""){
    	$step = 1;
    }
    
    //Process Step 1
    if($this->in->exists('step1')){
    	$strPhoneNumber = $this->in->get('phone');
    	$strPhoneNumber = $this->convert_phonenumber($strPhoneNumber, $this->in->get('default_country'));
    	
		$strDefaultCountry = $this->in->get('default_country');
		$strDefaultCountry = $this->convert_phonenumber($strDefaultCountry, " ");
		
		if($strPhoneNumber != "" && $strDefaultCountry != ""){
			//Save Settings
			$this->config->set('whatsapp_number', $strPhoneNumber);
			$this->config->set('whatsapp_defaultcountry', $strDefaultCountry);
			
			$username = $strPhoneNumber;
			$nickname = "EQdkp Plus";
			$debug = (DEBUG > 2) ? true : false;  // Shows debug log
			
			$step = 2;
						
			include_once $this->root_path.'plugins/whatsapp/includes/lib/chatapi/whatsprot.class.php';
			try {
				$w = new WhatsProt($username, $nickname, $debug);
				$a = $w->codeRequest('sms');
				
				$pw = $a->pw;
				
				if($pw){
					$this->config->set('whatsapp_password', $pw);
					$step = "finished";
					$this->core->message($this->user->lang('wa_step2_finished'), $this->user->lang('success'), 'green');
				}
				
				
			} catch(Exception $e){
				$this->core->message($e->getMessage(), $this->user->lang('error'), 'red');
				$step = 1;
    		}
			
		} else {
			$this->core->message($this->user->lang('wa_step1_error'), $this->user->lang('error'), 'red');
			$step = 1;
		}

    }
    
    //Process Step 2
    if($this->in->exists('step2')){
    	$username = $this->config->get('whatsapp_number');
    	$nickname = "EQdkp Plus";
    	$debug = (DEBUG > 2) ? true : false;  // Shows debug log
    		
    	include_once $this->root_path.'plugins/whatsapp/includes/lib/chatapi/whatsprot.class.php';
    	$w = new WhatsProt($username, $nickname, $debug);
    	
    	$code = $this->in->get('code');
    	try {
    		$a = $w->codeRegister($code);
    		$pw = $a->pw;
    		
    		if($pw){
    			$this->config->set('whatsapp_password', $pw);
    			$step = "finished";
    			$this->core->message($this->user->lang('wa_step2_finished'), $this->user->lang('success'), 'red');
    		}
    		
    	} catch(Exception $e){
    		$this->core->message($e->getMessage(), $this->user->lang('error'), 'red');
    		$step = 1;
    	}
    	
    }
    
    if($step == 1){
    	$this->tpl->assign_vars(array(
    		'S_STEP1' => true,
    	));
    } elseif($step == 2){
    	$this->tpl->assign_vars(array(
    		'S_STEP2' => true,
    	));
    } else {
    	$this->tpl->assign_vars(array(
    		'S_CONFIGURED' 			=> true,
    		'WA_PHONENUMBER' 		=> $this->config->get('whatsapp_number'),
    		'WA_DEFAULT_COUNTRY'	=> $this->config->get('whatsapp_defaultcountry'),
    	));
    }
    

	
    // -- EQDKP ---------------------------------------------------------------
    $this->core->set_vars(array(
      'page_title'    => $this->user->lang('whatsapp').' '.$this->user->lang('settings'),
      'template_path' => $this->pm->get_data('whatsapp', 'template_path'),
      'template_file' => 'admin/settings.html',
      'display'       => true
    ));
  }
  
  private function convert_phonenumber($strNumber, $defaultCountry){
  	if(strpos($strNumber, "0") === 0){
  		$strNumber = substr($strNumber, 1);
  		if($defaultCountry != ""){
  			$strNumber = $defaultCountry.$strNumber;
  		} else return false;
  	}
  
  	$strNumber = preg_replace("/[^0-9]/", "", $strNumber);
  	return $strNumber;
  }
  
}

registry::register('WhatsappSettings');

?>