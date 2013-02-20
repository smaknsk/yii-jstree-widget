Yii jsTree Widget
=================

This is a widget wrapper for jQuery plugin [jsTree](https://github.com/vakata/jstree).

Your model *must* have the [Nested Set](https://github.com/yiiext/nested-set-behavior) behaviour.

## Configuration

There are number of ways to print a tree using jsTree, but we're going to do it using simple AJAX way.

First, insert the widget:

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
`json.ajax.url` is the url to your contoller, obviously.

Then you'll need the controller action. You should set `$modelClassName` to your tree model class name.

~~~php
public $modelClassName = 'Category';
	
public function actions() 
{
	return array(
		'getnode' => 'ext.yii-jstree-widget.actions.GetNode'
	);
}

~~~

And don't forget to turn on JSTreeAjaxBehavior model behaviour.
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

That's all for displaying the trees.

##Events
jsTree is picky about some of its events (especially `before.jstree`), so now you can set them in your widget too! Here's the excerpt from widget data array:
~~~php
'events' => array(
	'before.jstree' => 'console.log("Timber!");',
),
~~~
`events` is a simple array of `event_name => event_function`. You don't need to wrap the function in `js:` prefix and `function()` code, it's done already. Just write the callback.
