<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$url = Url::toRoute('/site/pagination/');
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
    if ($torr != 0 && $torr != 1) {
        ?>
		<table class="table table-condensed table-hover">
			<thead>
			<tr>
				<th>Название</th>
				<th>Сиды</th>
				<th>Личи</th>
				<th>Ссылка</th>
			</tr>
			</thead>
			<tbody>
            <?php foreach ($torr as $item): ?>
				<tr>
					<td><?= $item[0] ?></td>
					<td><?= $item[2] ?></td>
					<td><?= $item[3] ?></td>
					<td><a href="<?= $item[1] ?>"><?php echo "Download" ?>
							<a href="/site/view/<?= $item->id ?>"><?php echo $item->title ?></a></td>
				</tr>
            <?php endforeach ?>
		</table>

		<a href="<?= $url ?>" class="btn btn-primary">Следующая страница</a>

        <?php
    } elseif ($torr == 1) {
        ?>
		<strong> </strong>
        <?php
    } else {
        ?>
		<strong>Результатов не найдено</strong>
        <?php
    }
    ?>
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
