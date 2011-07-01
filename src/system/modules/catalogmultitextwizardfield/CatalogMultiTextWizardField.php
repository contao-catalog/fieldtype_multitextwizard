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
 * This is the catalog multitextwizardfield extension file.
 *
 * PHP version 5
 * @copyright  Christian Schiffler 2009
 * @author     Christian Schiffler  <c.schiffler@cyberspectrum.de> 
 * @package    Catalog
 * @license    GPL 
 * @filesource
 */

// class to manipulate the field info to be as we want it to be, to render it and to make editing possible.
// Note that we use XML for data storage in the backend in favor of serializing the data arrays in order to be 
// able to search over the data more easily.
class CatalogMultiTextWizardField extends Backend {

	public function generateFieldEditor(&$field, $objRow) {
		$columns=deserialize($objRow->multiTextWizard);
		$labels=array();
		foreach($columns as $column)
		{
			$labels[]=$column[0];
		}
		
		$field=@array_merge_recursive($field, array
		(
			'label'     => &$objRow->name,
			'title'     => &$objRow->description,
			'eval'      => array
			(
				'columns' => count($labels),
				'labels' => $labels,
				'style' => 'width: auto;'
			),
		));
	}

	public function decodeEntries($varValue) {
		// we have to split up the xml to an array.
		$rows=array();
		if($varValue)
		{
			try {
				$xml = new SimpleXMLElement($varValue);
				foreach ($xml->children() as $key=>$row)
				{
					if((string)$key=='row')
					{
						$rowvalues=array();
						foreach ($row->children() as $key2=>$field)
						{
							if((string)$key2=='entry')
								$rowvalues[]=(string)$field;
						}
						$rows[]=$rowvalues;
					}
				}
			}
			catch (Exception $e) {
				// ignore exception silently...
			}
		}
		return $rows;
	}
	
	public function encodeEntries($varValue) {
		try {
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?><data></data>');
			if(is_array($varValue))
			{
				foreach($varValue as $row)
				{
					$xmlrow=$xml->addChild('row');
					foreach($row as $field)
					{
						$xmlrow->addChild('entry', $field);
					}
				}
			}
			return $xml->asXML();
		}
		catch (Exception $e) {
			return '<data></data>';
		}
	}
	
	public function onSaveColumns($varValue, DataContainer $dc) {
		return $this->encodeEntries(deserialize($varValue));
	}
	
	
	public function onLoadColumns($varValue, DataContainer $dc) {
		return serialize($this->decodeEntries($varValue));
	}
	
	public function parseValue($id, $k, $raw, $blnImageLink, $objCatalog, $objModule)
	{
		$rows=$this->decodeEntries($raw);
		// TODO: we need a summary here, add as new field.
		$html = '<table class="tl_multitexttable">';
		$html .= '<thead><tr class="head">';
		$objTable=$this->Database->prepare("SELECT tableName FROM tl_catalog_types WHERE id=?")
							->execute($objCatalog->pid);
		$labelcount = count($GLOBALS['TL_DCA'][$objTable->tableName]['fields'][$k]['eval']['labels']);
		foreach($GLOBALS['TL_DCA'][$objTable->tableName]['fields'][$k]['eval']['labels'] as $f=>$label)
		{
			$html .= '<th class="head_'.$f.($f%2==0?' even':' odd').($f==0?' col_first':($f==$labelcount?' col_last':'')).'">' . $label . '</th>';
		}
		$html .= '</tr></thead><tbody>';
		foreach($rows as $k=>$row)
		{
			$html .= '<tr class="row_'.$k.($k%2==0?' even':' odd').($k==0?' row_first':($k==count($rows)?' row_last':'')).'">';
			foreach($row as $f=>$field)
			{
				$html .= '<td class="col_'.$f.($f%2==0?' even':' odd').($f==0?' col_first':($f==count($row)?' col_last':'')).'">' . $field . '</td>';
			}
			$html .= '</tr>';
		}
		$html .= '</tbody></table>';
		return array
				(
				 	'items'	=> $rows,
					'values' => $rows,
				 	'html'  => $html,
				);
	}

	public function generateFilter($field, $fieldConf, $strSearch) {
		return array
				(
					 'procedure' => '(' . $field . ' LIKE ?)',
					 'search' => '%' . specialchars($strSearch, ENT_COMPAT, 'UTF-8', false) . '%',
				);
	}
}
?>