<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SoapSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="soap-setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'connection_uri')->textInput(['maxlength' => 255]) ?>

    <?=
        $form->field($model, 'version')
        ->dropDownList(
            [110 => '110', 111 => '111', 112 => '112', 113 => '113', 114 => '114']
        );
    ?>
    
    <?=
        $form->field($model, 'enabled')
        ->dropDownList(
            [0 => 'no', 1 => 'yes']
        );
    ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
