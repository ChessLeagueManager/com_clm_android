<?php

/**
  * @CLM Android Component
  * @Copyright (C) 2013 Fred Baumgarten. All rights reserved
  * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
  * @link http://www.fishpoke.de
  * @author Fred Baumgarten
  * @email dc6iq@gmx.de
  **/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );

class CLM_ANDROIDControllerInfo extends JControllerLegacy {
	function display($cachable = false, $urlparams = array()) {
		require_once(JPATH_COMPONENT.DS.'views'.DS.'info.php');
		$view = $this->getView( 'info', 'html' );
     		$view->display();
		//CLM_ANDROIDViewInfo::display( );
	}
	function cancel () {
		$this->setRedirect('index.php?option=com_clm_android' );
	}
}

