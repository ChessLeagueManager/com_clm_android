<?php

/**
  * @CLM Android Component
  * @Copyright (C) 2013 Fred Baumgarten. All rights reserved
  * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
  * @link http://www.fishpoke.de
  * @author Fred Baumgarten
  * @email dc6iq@gmx.de
  */

class CLM_ANDROIDViewCLM_ANDROID extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->msg = $this->get('Msg');
		parent::display($tpl);
	}	
}
?>
