<?php

/**
 * Данный action используется для получение дерева через ajax по одной node.
 */
class GetNode extends CAction 
{
	public function run($id = 0) 
	{
		$modelClassName = $this->getController()->modelClassName;
		
		$model = new $modelClassName;
		echo CJSON::encode($model->getJSTreeNode($id));
	}
}