<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<h2>Для того, что-бы изменить логин и пароль сайта RuTracker, введите их в форму ниже и подтвердите.</h2>
<h2>Рекомендуется внимательно проверять правильность введенных данных, иначе программа работать не будет!</h2>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-md-6">
        <?= $form->field($identification, 'login')->textInput() ?>
	</div>
	<div class="col-md-6">
        <?= $form->field($identification, 'password')->textInput() ?>
	</div>
	<div class="col-md-12">
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-success']) ?>
	</div>
</div>
<?php ActiveForm::end(); ?>

<h3>Если ваш логин и пароль не работают, можно установить:</h3>
<h3>Login:TrackerProgg</h3>
<h3>Password:12325809</h3>



