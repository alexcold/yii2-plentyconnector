<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SoapSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Soap Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="soap-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Soap Setting'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'connection_uri',
            'version',
            [
                'label' => 'enabled',
                'value' => function($data){
                    return $data->enabled == 1 ? "yes" : "no";
                }
            ],
            'username',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}{view}{update}{reset}',
                'buttons' => [
                    'reset' => function ($k, $m) {
                        return Html::a('', ['reset-connection-data', 'id' => $m->ID], ['class' => 'glyphicon glyphicon-refresh', 'data-method' => 'post']);
                    } 
                ]
            ],
        ],
    ]); ?>

</div>
