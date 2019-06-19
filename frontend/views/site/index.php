<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Ковертер</h1>
        <p><?= Html::a('Використані одиниці часу', ['site/convert-time'], ['class' => 'btn btn-lg btn-success']) ?></p>
        <p><?= Html::a('Використаний трафік', ['site/convert-data'], ['class' => 'btn btn-lg btn-success']) ?></p>
    </div>
</div>
