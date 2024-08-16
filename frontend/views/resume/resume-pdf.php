<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My Page Title';
$this->registerCssFile("@web/css/bootstrap.min.css", ['depends' => [\yii\bootstrap5\BootstrapAsset::class]]);
?>

<div class="container">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <p class="text-center">Hello, world!</p>
</div>
