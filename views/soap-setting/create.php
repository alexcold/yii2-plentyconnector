<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SoapSetting */

$this->title = Yii::t('app', 'Create Soap Setting');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Soap Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="soap-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
