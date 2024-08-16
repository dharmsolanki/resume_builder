<?php

use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;

$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
    'action' => ['resume/create']
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
        <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
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
    <div class="col-md-4">
        <?= $form->field($model, 'pincode')->textInput(['type' => 'number']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'linkdin') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'skills_info')->widget(Select2::class, [
            'data' => $skills,
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [',', ' '],
            ],
        ])->label('Skills'); ?>
    </div>
    <?= $form->field($model, 'education_info')->widget(MultipleInput::class, [
        'max' => 4,
        'addButtonOptions' => [
            'class' => 'btn btn-success',
            'label' => 'add' // also you can use html code
        ],
        'removeButtonOptions' => [
            'class' => 'btn btn-danger',
            'label' => 'remove' // also you can use html code
        ],
        'columns' => [
            [
                'name'  => 'college',
                'title' => 'College/School/University',
                'type' => MultipleInputColumn::TYPE_TEXT_INPUT,
            ],
            [
                'name'  => 'degree',
                'title' => 'Course/Degree (e.g:SSC,HSC,B.Tech)',
                'type' => MultipleInputColumn::TYPE_TEXT_INPUT,
            ],
            [
                'name'  => 'year_of_passing',
                'title' => 'Passout Year',
                'options' => [
                    'type' => 'number',
                ]
            ],
            [
                'name'  => 'percentage',
                'title' => 'Percentage',
            ],
        ]
    ]); ?>

    <?= $form->field($model, 'experience_info')->widget(MultipleInput::className(), [
        'max' => 4,
        'addButtonOptions' => [
            'class' => 'btn btn-success',
            'label' => 'add' // also you can use html code
        ],
        'removeButtonOptions' => [
            'class' => 'btn btn-danger',
            'label' => 'remove' // also you can use html code
        ],
        'columns' => [
            [
                'name'  => 'company',
                'title' => 'Company Name',
                'type' => MultipleInputColumn::TYPE_TEXT_INPUT,
            ],
            [
                'name'  => 'year_of_experience',
                'title' => 'Year Of Experience',
                'options' => [

                    'type' => 'number'

                ]
            ],
            [
                'name'  => 'description',
                'title' => 'Description',
                'type' => MultipleInputColumn::TYPE_TEXTAREA,
            ],
        ]
    ]); ?>
</div>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>