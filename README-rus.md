Yii jsTree Widget
=================

Данный виджет является обёрткой для jQuery плагина [jsTree](https://github.com/vakata/jstree).

## Требования
* Модель должна иметь поведение [Nested Set](https://github.com/yiiext/nested-set-behavior)

## Установка и настройка

1. Получить код можно следующими способами:
	* [Зарузить](https://github.com/smaknsk/yii-jstree-widget/tags) последнюю версию и 
	  разместить её в папке `extensions/yii-jstree-widget`
	* Добавить этот репозиторий как git submodule в ваш репозиторий
	  `git submodule add https://github.com/smaknsk/yii-jstree-widget.git extensions/yii-jstree-widget`

2. Вывод дерева через Ajax

Для вывода дерева в jsTree существует несколько способов. Рассмотрим вывод через ajax.
В шаблоне подключим видджет:
~~~php
<?php 
	$this->widget("ext.yii-jstree-widget.JSTreeWidget", array(
		'settings' => array(
				'plugins' => array('themes', 'json'),
				'json' => array(
					'ajax' => array(
						'url' => '/admin/category/getnode',
						'data' => 'js:function (n) { return { id : n.attr ? n.attr("data-id") : 0 }; }'
					)
				)
			)
		)
	));
?>
~~~
В настройках плагина надо указать путь к вашему контроллеру.

Далее в контроллере который вы указали в json.ajax.url прописываем дополнительные action.
У казываем в свойстве modelClassName модель с которой будет работать action getnode.
~~~php
public $modelClassName = 'Category';
	
public function actions() 
{
	return array(
		'getnode' => 'ext.yii-jstree-widget.actions.GetNode'
	);
}

~~~

И наконец в модели $modelClassName нужно подключить поведение JSTreeAjaxBehavior
~~~php
public function behaviors()
{
	return array(
			'nestedSetBehavior'=>array(
				'class'=>'ext.nested-set-behavior.NestedSetBehavior',
				'hasManyRoots'=> true,
				'leftAttribute'=>'lft',
				'rightAttribute'=>'rgt',
				'levelAttribute'=>'level',
			),
			'JSTreeAjaxBehavior' => array(
				'class' => 'ext.yii-jstree-widget.JSTreeAjaxBehavior',
				'titleAttribute' => 'name'
			)
	);
}
~~~
