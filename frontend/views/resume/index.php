<?php

use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;

$form = ActiveForm::begin([
    'id' => 'resume-form',
    'options' => ['class' => 'form-horizontal'],
    'action' => ['resume/create']
]) ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Create Your Resume</h2>
        </div>

        <!-- Personal Information -->
        <div class="col-md-12 mb-3">
            <h4>Personal Information</h4>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'First Name']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'middle_name')->textInput(['placeholder' => 'Middle Name']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Last Name']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['type' => 'email', 'placeholder' => 'Email Address']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'mobile_number')->textInput(['type' => 'number', 'placeholder' => 'Mobile Number']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'file')->fileInput() ?>
        </div>

        <!-- Location Information -->
        <div class="col-md-12 mt-4 mb-3">
            <h4>Location Information</h4>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'state')->widget(Select2::class, [
                'data' => $getState,
                'language' => 'en',
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
            <?= $form->field($model, 'pincode')->textInput(['type' => 'number', 'placeholder' => 'Pincode']) ?>
        </div>

        <!-- Social Links -->
        <div class="col-md-12 mt-4 mb-3">
            <h4>Social Links</h4>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'linkdin')->textInput(['placeholder' => 'LinkedIn Profile']) ?>
        </div>

        <!-- Skills -->
        <div class="col-md-12 mt-4 mb-3">
            <h4>Skills</h4>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'skills_info')->widget(Select2::class, [
                'data' => $skills,
                'options' => ['multiple' => true, 'placeholder' => 'Add your skills...'],
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                ],
            ])->label(false); ?>
        </div>

        <!-- Education -->
        <div class="col-md-12 mt-4 mb-3">
            <h4>Education</h4>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'education_info')->widget(MultipleInput::class, [
                'max' => 4,
                'addButtonOptions' => [
                    'class' => 'btn btn-success btn-sm',
                    'label' => '<i class="fas fa-plus"></i> Add Education'
                ],
                'removeButtonOptions' => [
                    'class' => 'btn btn-danger btn-sm',
                    'label' => '<i class="fas fa-trash"></i> Remove'
                ],
                'columns' => [
                    [
                        'name' => 'college',
                        'title' => 'College/University',
                        'type' => MultipleInputColumn::TYPE_TEXT_INPUT,
                    ],
                    [
                        'name' => 'degree',
                        'title' => 'Course/Degree',
                        'type' => MultipleInputColumn::TYPE_TEXT_INPUT,
                    ],
                    [
                        'name' => 'year_of_passing',
                        'title' => 'Passout Year',
                        'options' => [
                            'type' => 'number',
                        ]
                    ],
                    [
                        'name' => 'percentage',
                        'title' => 'Percentage',
                    ],
                ]
            ]); ?>
        </div>

        <!-- Experience -->
        <div class="col-md-12 mt-4 mb-3">
            <h4>Experience</h4>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'experience_info')->widget(MultipleInput::class, [
                'max' => 4,
                'addButtonOptions' => [
                    'class' => 'btn btn-success btn-sm',
                    'label' => '<i class="fas fa-plus"></i> Add Experience'
                ],
                'removeButtonOptions' => [
                    'class' => 'btn btn-danger btn-sm',
                    'label' => '<i class="fas fa-trash"></i> Remove'
                ],
                'columns' => [
                    [
                        'name' => 'company',
                        'title' => 'Company Name',
                        'type' => MultipleInputColumn::TYPE_TEXT_INPUT,
                    ],
                    [
                        'name' => 'year_of_experience',
                        'title' => 'Years of Experience',
                        'options' => [
                            'type' => 'number'
                        ]
                    ],
                    [
                        'name' => 'description',
                        'title' => 'Description',
                        'type' => MultipleInputColumn::TYPE_TEXTAREA,
                    ],
                ]
            ]); ?>
        </div>

        <!-- Submit Button -->
        <div class="col-md-12 mt-4 text-center">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-lg']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end() ?>