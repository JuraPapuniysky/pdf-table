<?php

/** @var \frontend\models\ReportForm $reportForm */
/** @var \common\models\DataTime[] $dataModels */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['id' => 'report-form']); ?>

<?= $form->field($reportForm, 'text')->textarea() ?>

<div class="form-group">
    <?= Html::submitButton('Конвертувати', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
