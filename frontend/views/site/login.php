<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
                                <?=Html::img(Yii::$app->params['logo'],['width'=>50,'height'=>50])?>
				<h7><?=yii::$app->params['name']?></h7>
				<div class="d-flex justify-content-end social_icon">
					<span><i class="fa fa-facebook-square"></i></span>
					<span><i class="fa fa-google-plus-square"></i></span>
					<span><i class="fa fa-twitter-square"></i></span>
				</div>
			</div>
			<div class="card-body">
				<?php $form= ActiveForm::begin([]); ?>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" id="loginform-username" name="LoginForm[username]" aria-required="true" class="form-control" placeholder="nombre usuario">
                                                <p class="help-block help-block-error""></p>
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password"  id="loginform-password" name="LoginForm[password]" aria-required="true" class="form-control" placeholder="contraseña">
                                                <p class="help-block help-block-error""></p>
                                        </div>
					
					<div class="form-group">
						<input type="submit" value="Ingresar" class="btn float-right login_btn">
					</div>
                                        
				<?php  ActiveForm::end([]); ?>
			</div>
			<div class="card-footer">
				
				<div class="d-flex justify-content-center">
					<?=Html::a('Olvidé mi contraseña',Url::to(['/site/request-password-reset']))?>
				</div>
			</div>
		</div>
	</div>
</div>
