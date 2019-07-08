<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'PhoneReport';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-phone-report">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <button class="btn btn-primary">Генерація звіту</button>

    <?php ActiveForm::end() ?>
</div>
