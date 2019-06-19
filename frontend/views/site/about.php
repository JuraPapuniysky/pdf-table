<?php

/* @var $this yii\web\View */
/* @var $aboutForm \frontend\models\AboutForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Довідка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'report-form']); ?>

    <?= $form->field($aboutForm, 'data')->textarea() ?>

    <?= $form->field($aboutForm, 'time')->textarea() ?>

    <?php ActiveForm::end(); ?>
</div>
