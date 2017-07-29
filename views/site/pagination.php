<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
	<h1 class="text-center">Торрент Парсер</h1>

	<h2 class="text-center">Поиск по запросу:<?php echo $inquiry ?></h2>
<?php
if ($torr != 0 && $torr != 1) {
    ?>
	<table class="table .success table-condensed table-hover">
		<thead>
		<tr>
			<th>Название</th>
			<th>Размер</th>
			<th>Сиды</th>
			<th>Личи</th>
			<th>Ссылка</th>
		</tr>
		</thead>
		<tbody>
        <?php $id = 0; foreach ($torr as $item): ?>
			<tr>
				<td class="active"><?= $item[0] ?></td>
				<td class="info"><?= $item[4] ?></td>
				<td class="success"><?= $item[2] ?></td>
				<td class="danger"><?= $item[3] ?></td>

				<?php
				$session = Yii::$app->session;
				$session["download[$id]"] = $item[1];
				?>

				<td class="bg-warning"><a href="<?= Url::to(['site/download', 'id' => $id]) ?>" class="btn btn-default">Download</a>
				<?php $id++; ?>
			</tr>
        <?php endforeach ?>
	</table>

	<a href="<?= Url::toRoute('/site/pagination/') ?>" class="btn btn-primary btn-lg">Еще результаты</a>
	
    <?php
} elseif ($torr == 1) {
    ?>
	<strong> </strong>
    <?php
} else {
    ?>
	<h2 class="text-center">Торрентов нет!</h2>
	<br><br>
	<a href="/" class="btn btn-primary btn-lg btn-block ">Начать новый поиск</a>
    <?php
}
?>