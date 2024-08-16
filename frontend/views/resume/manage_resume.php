<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'first_name',
        'last_name',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{download}', // Custom template to include the download button
            'buttons' => [
                'download' => function ($url, $model, $key) {
                    return Html::a('Download', Url::to(['resume/download', 'id' => $model->id]), [
                        'title' => 'Download',
                        'class' => 'btn btn-success btn-sm', // Add your desired classes here
                    ]);
                },
            ],
        ],
    ],
]) ?>
