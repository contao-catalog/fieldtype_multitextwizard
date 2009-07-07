<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that 
 * specializes in accessibility and generates W3C-compliant HTML code. It 
 * provides a wide range of functionality to develop professional websites 
 * including a built-in search engine, form generator, file and user manager, 
 * CSS engine, multi-language support and many more. For more information and 
 * additional TYPOlight applications like the TYPOlight MVC Framework please 
 * visit the project website http://www.typolight.org.
 *
 * This is the enhancement to the data container array for table tl_catalog_fields 
 * to allow the custom field type for multiTextWizard.
 *
 * PHP version 5
 * @copyright  Christian Schiffler 2009
 * @author     Christian Schiffler  <c.schiffler@cyberspectrum.de> 
 * @package    Catalog
 * @license    GPL 
 * @filesource
 */


/**
 * Table tl_catalog_fields 
 */

// Palettes
$GLOBALS['TL_DCA']['tl_catalog_fields']['palettes']['multitextwizard'] = 'name,description,colName,type;multiTextWizard';

// register our fieldtype editor to the catalog Fields
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['multiTextWizard'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_catalog_fields']['multiTextWizard'],
	'inputType'     => 'multitextWizard',
	'save_callback' => array(array('tl_catalog_fields_multiTextWizard', 'onSaveColumns')),
	'load_callback' => array(array('tl_catalog_fields_multiTextWizard', 'onLoadColumns')),
	'eval'      => array
	(
		'title' => &$GLOBALS['TL_LANG']['tl_catalog_fields']['multiTextWizard'],
		'mandatory' => true,
		'doNotSaveEmpty'=>true,
		'columns' => 1,
	)
);

// register to catalog module that we provide the multitextwizard as field type.
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['type']['options'][] = 'multitextwizard';

class tl_catalog_fields_multiTextWizard extends Backend {
	
	public function onSaveColumns($varValue, DataContainer $dc) {
		return $varValue;
	}
	public function onLoadColumns($varValue, DataContainer $dc) {
		return $varValue;
	}
}

?>