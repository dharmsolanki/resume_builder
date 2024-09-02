<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Select Resume Template';
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="resume-templates">
        <div class="template-option">
            <?= Html::a('Professional Template', ['resume/create', 'template' => 'professional'], [
                'class' => 'btn btn-primary',
                'role' => 'button'
            ]) ?>
        </div>
        <div class="template-option">
            <?= Html::a('Creative Template', ['resume/create', 'template' => 'creative'], [
                'class' => 'btn btn-secondary',
                'role' => 'button'
            ]) ?>
        </div>
        <div class="template-option">
            <?= Html::a('Minimal Template', ['resume/create', 'template' => 'minimal'], [
                'class' => 'btn btn-info',
                'role' => 'button'
            ]) ?>
        </div>
        <div class="template-option">
            <?= Html::a('Skip', ['resume/create'], [
                'class' => 'btn btn-success',
                'role' => 'button',
                'id' => 'btnSkip'
            ]) ?>
        </div>
    </div>
</div>