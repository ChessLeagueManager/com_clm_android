<?php

/**
 * @clm Android component
 * @Copyright (C) 2013 Fred Baumgarten. All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.fishpoke.de
 * @author Fred Baumgarten
 * @email dc6iq@gmx.de
*/

// kein direkter Zugriff
defined('_JEXEC') or die('Restricted access');

if (!defined("DS")) {
	define('DS', DIRECTORY_SEPARATOR);
}

// laden des Joomla! Basis Controllers
require_once (JPATH_COMPONENT.DS.'controller.php');
// require_once (JPATH.DS.'libraries'.DS.'legacy'.DS.'application'.DS.'application.php');

$controller = JRequest::getVar('controller');

// laden von weiteren Controllern
if($controller = JRequest::getVar('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}
// Erzeugen eines Objekts der Klasse controller
$classname = 'CLM_ANDROIDController'.ucfirst($controller);
$controller = new $classname();

$mainframe = JFactory::getApplication();
$format = JRequest::getString('format');
if ($format == "raw") {
  $user = JRequest::getString('user');
  $pass = JRequest::getString('pass');
  if (($user != null) && ($pass != null)) {
    if (($user != "") && ($pass != "")) {
      $cred = Array('username' => $user, 'password' => $pass);
      $options = Array('remember' => false);
      $x = $mainframe->login($cred, $options);
    }
  }
}

// den request task ausleben
$controller->execute(JRequest::getCmd('task'));

if ($format == "raw") {
  $mainframe->logout();
}

// Redirect aus dem controller
$controller->redirect();

?>
