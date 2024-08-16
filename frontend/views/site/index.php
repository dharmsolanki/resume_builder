<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Resume Builder';
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Resume Builder</h1>
            <p class="fs-5 fw-light">Easily create and manage your professional resumes.</p>
            <p><a class="btn btn-lg btn-success" href=<?= Yii::$app->user->isGuest ? Url::to("login") : Url::to("create") ?>>Start Building Your Resume</a></p>
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Create Resume</h2>

                <p>Get started by creating a new resume. Choose from various templates, add your personal information, and create a professional-looking resume in minutes.</p>

                <p><a class="btn btn-outline-secondary" href=<?= Yii::$app->user->isGuest ? Url::to("login") : Url::to("create") ?> >Create Now &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Manage Resumes</h2>

                <p>View and edit your existing resumes. Keep them up-to-date with your latest achievements and skills, ensuring you're always ready to impress.</p>

                <p><a class="btn btn-outline-secondary" href=<?= Yii::$app->user->isGuest ? Url::to("login") : Url::to("manage-resume") ?>>Manage Resumes &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Tips & Resources</h2>

                <p>Browse through our collection of resume writing tips and resources to help you craft the perfect resume that stands out to employers.</p>

                <p><a class="btn btn-outline-secondary" href="/resume/tips">Get Tips &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
