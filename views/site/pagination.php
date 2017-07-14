<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::toRoute('/site/pagination/');
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
        <?php foreach ($torr as $item): ?>
			<tr>
				<td class="active"><?= $item[0] ?></td>
				<td class="info"><?= $item[4] ?></td>
				<td class="success"><?= $item[2] ?></td>
				<td class="danger"><?= $item[3] ?></td>
				<td class="bg-warning"><a href="<?= $item[1] ?>" class="btn btn-default">Download</a>
					<a href="/site/view/<?= $item->id ?>"><?php echo $item->title ?></a></td>
			</tr>
        <?php endforeach ?>
	</table>

	<a href="<?= $url ?>" class="btn btn-primary btn-lg">Еще результаты</a>
	
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