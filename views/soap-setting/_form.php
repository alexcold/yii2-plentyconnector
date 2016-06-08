<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\SoapSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="soap-setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'connection_uri')->textInput(['maxlength' => 255]) ?>

    <?= 
    $form->field($model, 'version')->widget(Select2::classname(), [
        'data' => [110 => '110', 111 => '111', 112 => '112', 113 => '113', 114 => '114'],
        'language' => 'de',
        'options' => ['placeholder' => 'Select a version ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= 
    $form->field($model, 'enabled')->widget(Select2::classname(), [
        'data' => [0 => 'no', 1 => 'yes'],
        'language' => 'de',
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); 
    ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
