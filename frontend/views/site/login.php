<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class='box'>
  <div class='box-form'>
    <div class='box-login-tab'></div>
    <div class='box-login-title'>
      <div class='i i-login'></div><h2>LOGIN</h2>
    </div>
    
    <div class='box-login'>
      <div class='fieldset-body' id='login_form'>
        <button onclick="openLoginInfo();" class='b b-form i i-more' title='Mais Informações'></button>
        <?php $form= ActiveForm::begin([]); ?>	
        <p class='field'>
          <label for='user'>Usuario</label>
          <input type='text' id="loginform-username" name="LoginForm[username]" title='Usuario' />
          <span id='valida' class='i i-warning'></span>
        </p>
      	  <p class='field'>
          <label for='pass'>Contraseña</label>
          <input type='password' id="loginform-password" name="LoginForm[password]" title='Password' />
          <span id='valida' class='i i-close'></span>
        </p>
          <!--
          <label class='checkbox'>
            <input type='checkbox' value='TRUE' title='Keep me Signed in' /> Keep me Signed in
          </label>
            -->
        	<input type='submit' id='do_login' value='INGRESAR' title='Comenzar' />
          <?php  ActiveForm::end([]); ?>
      </div>
    </div>
  
  </div>
  <div class='box-info'>
					    <p><button onclick="closeLoginInfo();" class='b b-info i i-left' title='Regresar'></button><h3>¿Necesita Ayuda?</h3>
    </p>
					    <div class='line-wh'></div>
    					<button onclick="" class='b-support' title='¿Olvidó su contraseña?'>Olvidó su contraseña</button>
    <button onclick="" class='b-support' title='Soporte'> Necesita soporte</button>
    					<div class='line-wh'></div>
    
  				</div>
</div>


 