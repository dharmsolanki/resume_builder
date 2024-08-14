<?php

use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'first_name') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'middle_name') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'last_name') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'email') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'mobile_number')->textInput(['type' => 'number']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'state')->widget(Select2::class, [
            'data' => $getState,
            'language' => 'de',
            'options' => ['placeholder' => 'Select a state ...', 'id' => 'state'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'city')->widget(DepDrop::class, [
            'options' => ['id' => 'city'],
            'type' => DepDrop::TYPE_SELECT2,
            'pluginOptions' => [
                'depends' => ['state'],
                'placeholder' => 'Select a city...',
                'url' => Url::to(['/resume/get-city'])
            ]
        ]); ?>
    </div>
</div>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>