<?php

use yidas\yii\fontawesome\FontawesomeAsset;

$location = $data->location_info;
$contact = $data->contact_info;
FontawesomeAsset::register($this);
?>
<div class="resume" style="font-family: 'Arial', sans-serif; max-width: 900px; margin: 10px auto; padding: 15px; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <div class="header" style="display: flex; align-items: center; margin-bottom: 20px;">
        <div class="photo" style="flex: 0 0 150px; margin-right: 10px;">
            <img src="<?= $data->file ?>" alt="Profile Picture" style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        </div>
        <div class="contact-info" style="flex: 1;">
            <h1 style="margin: 0; font-size: 30px; color: #333;"><?= ucfirst($data->first_name) . " " . ucfirst($data->last_name) ?></h1>
            <p style="margin: 3px 0; color: #555; font-size: 16px;"><?= $location['city'] . ', ' . $state . ', ' . $location['pincode'] ?></p>
            <p style="margin: 3px 0; color: #555; font-size: 16px;"><?= $contact['mobile_number'] ?></p>
            <p style="margin: 3px 0; color: #555; font-size: 16px;"><?= $contact['email'] ?></p>
        </div>
    </div>

    <div class="section" style="margin-bottom: 20px;">
        <h2 style="border-bottom: 2px solid #007BFF; padding-bottom: 5px; font-size: 24px; color: #007BFF;">Education</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f9f9f9; color: #333; font-size: 14px;">College</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f9f9f9; color: #333; font-size: 14px;">Degree</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f9f9f9; color: #333; font-size: 14px;">Year of Passing</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f9f9f9; color: #333; font-size: 14px;">Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->education_info as $education) { ?>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;"><?= $education['college'] ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px;"><?= $education['degree'] ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px;"><?= $education['year_of_passing'] ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px;"><?= $education['percentage'] ?>%</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="section" style="margin-bottom: 20px;">
        <h2 style="border-bottom: 2px solid #007BFF; padding-bottom: 5px; font-size: 24px; color: #007BFF;">Skills</h2>
        <p style="font-size: 14px; color: #333; margin-top: 10px;">
            <?php
            $skills = $data->skills_info;
            echo implode(', ', array_map('ucfirst', $skills));
            ?>
        </p>
    </div>

    <div class="section" style="margin-bottom: 20px;">
        <h2 style="border-bottom: 2px solid #007BFF; padding-bottom: 5px; font-size: 24px; color: #007BFF;">Experience</h2>
        <div class="experience-list" style="margin-top: 10px;">
            <?php foreach ($data->experience_info as $experience) { ?>
                <div class="experience-item" style="margin-bottom: 15px; border-left: 4px solid #007BFF; padding-left: 10px;">
                    <h3 style="margin: 0; font-size: 18px; color: #333;"><?= ucfirst($experience['company']) ?></h3>
                    <p style="margin: 3px 0; font-size: 14px; color: #555;">
                        <?= $experience['year_of_experience'] . ($experience['year_of_experience'] > 1 ? " Years" : " Year") ?>
                    </p>
                    <p style="font-size: 14px; color: #333;"><?= nl2br($experience['description']) ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>