<p>Главная страница</p>

<p>Имя: <b><?= $name ?></b></p>
<p>Возраст: <b><?= $age ?></b></p>


<?php foreach ($news as $val): ?>
	<h3><?= $val['title'] ?></h3>
	<p><?= $val['description'] ?></p>
	<hr>
<?php endforeach; ?>