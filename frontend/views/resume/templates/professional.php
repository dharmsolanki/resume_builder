<?php

use yidas\yii\fontawesome\FontawesomeAsset;

$location = $data->location_info;
$contact = $data->contact_info;
FontawesomeAsset::register($this);
?>
<div class="resume" style="font-family: 'Arial', sans-serif; max-width: 900px; margin: 20px auto; padding: 20px; background-color: #f8f9fa; border-radius: 12px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);">
    <div class="header" style="display: flex; align-items: center; margin-bottom: 30px;">
        <div class="photo" style="flex: 0 0 160px; margin-right: 20px;">
            <img src="<?= $data->file ?>" alt="Profile Picture" style="border-radius: 50%; width: 160px; height: 160px; object-fit: cover; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);">
        </div>
        <div class="contact-info" style="flex: 1;">
            <h1 style="margin: 0; font-size: 32px; color: #343a40;"><?= ucfirst($data->first_name) . " " . ucfirst($data->last_name) ?></h1>
            <p style="margin: 5px 0; color: #495057; font-size: 18px;"><?= $location['city'] . ', ' . $state . ', ' . $location['pincode'] ?></p>
            <p style="margin: 5px 0; color: #495057; font-size: 18px;"><?= $contact['mobile_number'] ?></p>
            <p style="margin: 5px 0; color: #495057; font-size: 18px;"><?= $contact['email'] ?></p>
        </div>
    </div>

    <div class="section" style="margin-bottom: 30px;">
        <h2 style="border-bottom: 3px solid #007BFF; padding-bottom: 8px; font-size: 26px; color: #007BFF;">Education</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #dee2e6; padding: 10px; text-align: left; background-color: #e9ecef; color: #495057; font-size: 16px;">College</th>
                    <th style="border: 1px solid #dee2e6; padding: 10px; text-align: left; background-color: #e9ecef; color: #495057; font-size: 16px;">Degree</th>
                    <th style="border: 1px solid #dee2e6; padding: 10px; text-align: left; background-color: #e9ecef; color: #495057; font-size: 16px;">Year of Passing</th>
                    <th style="border: 1px solid #dee2e6; padding: 10px; text-align: left; background-color: #e9ecef; color: #495057; font-size: 16px;">Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->education_info as $education) { ?>
                    <tr>
                        <td style="border: 1px solid #dee2e6; padding: 10px;"><?= $education['college'] ?></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px;"><?= $education['degree'] ?></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px;"><?= $education['year_of_passing'] ?></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px;"><?= $education['percentage'] ?>%</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="section" style="margin-bottom: 30px;">
        <h2 style="border-bottom: 3px solid #007BFF; padding-bottom: 8px; font-size: 26px; color: #007BFF;">Skills</h2>
        <p style="font-size: 16px; color: #343a40; margin-top: 10px;">
            <?php
            $skills = $data->skills_info;
            echo implode(', ', array_map('ucfirst', $skills));
            ?>
        </p>
    </div>

    <div class="section" style="margin-bottom: 30px;">
        <h2 style="border-bottom: 3px solid #007BFF; padding-bottom: 8px; font-size: 26px; color: #007BFF;">Experience</h2>
        <div class="experience-list" style="margin-top: 15px;">
            <?php foreach ($data->experience_info as $experience) { ?>
                <div class="experience-item" style="margin-bottom: 20px; border-left: 6px solid #007BFF; padding-left: 15px; background-color: #ffffff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 6px;">
                    <h3 style="margin: 0; font-size: 20px; color: #343a40;"><?= ucfirst($experience['company']) ?></h3>
                    <p style="margin: 5px 0; font-size: 16px; color: #6c757d;">
                        <?= $experience['year_of_experience'] . ($experience['year_of_experience'] > 1 ? " Years of Experience" : " Year of Experience") ?>
                    </p>
                    <p style="font-size: 16px; color: #343a40;"><?= nl2br($experience['description']) ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
