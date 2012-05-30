<?php

/**
 * Данное поведение формирует данные для использования их в javascripn библиотеке jsTree
 */
class JSTreeAjaxBehavior extends CActiveRecordBehavior
{
	public $identifiAttribute = 'id';
	public $titleAttribute = 'title';
	public $name = 'JSTreeList';
	
	/**
	 * Создаёт массив для скрипта jsTree
	 * @param type $nodeId
	 * @return type 
	 */
	public function getJSTreeNode($nodeId = 0)
	{
		if ($nodeId) {
			$root = $this->getOwner()->findByPk($nodeId);
			$node = $root->children()->findAll();
		} else {
			$node = $this->getOwner()->roots()->findAll();
		}

		$nodeList = array();
		foreach($node as $nodeItem)
		{
			$nodeList[] = array(
				'li_attr' => array('data-id' => $nodeItem->getAttribute($this->identifiAttribute)),
				'title' => $nodeItem->getAttribute($this->titleAttribute),
				'data' => array(
					'jstree' => 
						array('checkbox' => 
							array(
								'name' => $this->name . '[]',
								//'checked' => true,
								'value' => $nodeItem->getAttribute($this->identifiAttribute),
							)
						)
				),
				'children' => ($nodeItem->children()->count() ? array() : false)
			);
		}
		
		return $nodeList;
	}
}