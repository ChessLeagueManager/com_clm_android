<?php

/**
 * @CLM Android Component
 * @Copyright (C) 2013 Fred Baumgarten. All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.fishpoke.de
 * @author Fred Baumgarten
 * @email dc6iq@gmx.de
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class CLM_ANDROIDViewInfo extends JViewLegacy {

	function display ($tpl = NULL) {
		JToolBarHelper::title(JText::_('CLM Android Komponente'), 'generic.png');
		JToolBarHelper::help('screen.clm_ext.info' );
	?>
<fieldset class="adminform">
	<legend>Informationen</legend>
	<style type="text/css">table { width:90%; }</style>
	<table class="admintable">
		<tbody>
			<tr>
			<td>
			<h2>Eine Komponente zur Darstellung von CLM Turnierdaten zur Nutzung von Android-Programmen</h2>
			<br>von Fred Baumgarten - dc6iq@gmx.de
			<br><br>
			<b>Projekt Homepage :  </b> http://www.fishpoke.de<br>
			</td>
			</tr>
		</tbody>
	</table>
</fieldset>

<?php }} ?>
