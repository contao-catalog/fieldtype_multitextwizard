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
 * This is the catalog multitextwizardfield extension configuration file.
 *
 * PHP version 5
 * @copyright  Christian Schiffler 2009
 * @author     Christian Schiffler  <c.schiffler@cyberspectrum.de> 
 * @package    Catalog
 * @license    GPL 
 * @filesource
 */


/**
 * Back-end module
 */
 
// Register field type editor to catalog module.
$GLOBALS['BE_MOD']['content']['catalog']['fieldTypes']['multitextwizard'] = array
(
	'typeimage'    => 'system/modules/catalogmultitextwizardfield/html/multitextwizard.gif',
	'fieldDef'     => array
	(
		'inputType' => 'multitextWizard',
		'eval'      => array
		(
			'doNotSaveEmpty'=>true,
		),
		'save_callback' => array(array('CatalogMultiTextWizardField', 'onSaveColumns')),
		'load_callback' => array(array('CatalogMultiTextWizardField', 'onLoadColumns')),
	),
	'sqlDefColumn' => "text NULL",
	'generateFieldEditor' => array(array('CatalogMultiTextWizardField', 'generateFieldEditor')),
	'parseValue' => array(array('CatalogMultiTextWizardField', 'parseValue')),
	'generateFilter' => array(array('CatalogMultiTextWizardField', 'generateFilter')),
);

$GLOBALS['BE_MOD']['content']['catalog']['typesMatchFields'][] = 'multitextwizard';
$GLOBALS['BE_MOD']['content']['catalog']['typesEditFields'][] = 'multitextwizard';
$GLOBALS['BE_MOD']['content']['catalog']['typesLinkFields'][] = 'multitextwizard';
$GLOBALS['BE_MOD']['content']['catalog']['typesCatalogFields'][] = 'multitextwizard';
$GLOBALS['BE_MOD']['content']['catalog']['typesFilterFields'][] = 'multitextwizard';

?>