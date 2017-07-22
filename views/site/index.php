<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<h1 class="text-center">Торрент Парсер</h1><br>

<?php
if ($status == "success") {
    ?>

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($search, 'path')->label(false) ?>
    <?= Html::submitButton('Искать', ['class' => 'btn btn-success btn-lg']) ?>
    <?php ActiveForm::end() ?>

    <?php
} else {
    ?>

	<h3 class="text-center">Для успешного продолжения работы, введите символы расположенные ниже</h3>
	<p class="text-center"><?php echo $captcha->cap_image ?></p>
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($captcha, 'captcha') ?>
    <?= $form->field($captcha, 'cap_sid')->hiddenInput()->label(false) ?>
    <?= $form->field($captcha, 'cap_code')->hiddenInput()->label(false) ?>
    <?= Html::submitButton('Ввести', ['class' => 'btn btn-success btn-lg']) ?>
    <?php ActiveForm::end() ?>

    <?php
}
?>
