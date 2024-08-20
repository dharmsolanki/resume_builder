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
            'template' => '{update} {delete} {download}', // Custom template to include the download button
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('Edit', $url, [
                        'title' => 'Edit',
                        'class' => 'btn btn-primary btn-sm', // Custom classes for the Edit button
                        'data-method' => 'post'
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('Delete', $url, [
                        'title' => 'Delete',
                        'class' => 'btn btn-danger btn-sm', // Custom classes for the Delete button
                        'data-confirm' => 'Are you sure you want to delete this item?',
                        'data-method' => 'post', // Ensure the delete action is handled via POST
                    ]);
                },
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
