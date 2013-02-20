<?php

/**
 * Виджет JSTreeWidget это wrapper для javascripn библиотеки jsTree
 */
class JSTreeWidget extends CInputWidget
{
	public $htmlOptions;
	
	public $settings = array('themes');
	
	public function init()
	{
		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$id = $this->htmlOptions['id'] = $this->getId();
		
		$dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'jstree' . DIRECTORY_SEPARATOR . 'dist';
		$assets = Yii::app()->getAssetManager()->publish($dir);
		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($assets . '/jstree.min.js');
		
		$js = '$("#' . $id . '").jstree(' . CJavaScript::encode($this->settings) . ');';
		$cs->registerScript('Yii.' . get_class($this) . '#' . $id, $js);
	}
	
	public function run()
	{
		$html = CHtml::openTag("div", array("id" => $this->htmlOptions['id']));
		$html .= CHtml::closeTag("div");
		echo $html;
	}
}
