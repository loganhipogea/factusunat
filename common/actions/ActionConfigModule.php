<?php
namespace common\actions;
class ActionConfigModule extends \yii\base\Action
{
	
	public function run()
	{
	return \Yii::$app->controller->redirect(\yii\helpers\Url::toRoute([
            '/config/settings-module','module'=>\Yii::$app->controller->module->id
             ]));
          }
}