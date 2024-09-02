<?php

use yidas\yii\fontawesome\FontawesomeAsset;

$location = $data->location_info;
$contact = $data->contact_info;
FontawesomeAsset::register($this);
?>
<div class="resume" style="
    font-family: 'Arial', sans-serif;
    max-width: 850px;
    margin: 30px auto;
    padding: 20px;
    background: #ffffff; /* Clean white background */
    border-radius: 12px;
    border: 1px solid #e0e0e0;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
">
    <div class="header" style="display: flex; align-items: center; margin-bottom: 30px; border-bottom: 3px solid #007BFF; padding-bottom: 20px;">
        <div class="photo" style="flex: 0 0 150px; margin-right: 20px;">
            <img src="<?= $data->file ?>" alt="Profile Picture" style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover; border: 4px solid #007BFF;">
        </div>
        <div class="contact-info" style="flex: 1;">
            <h1 style="margin: 0; font-size: 36px; color: #333;"><?= ucfirst($data->first_name) . " " . ucfirst($data->last_name) ?></h1>
            <p style="margin: 5px 0; color: #777; font-size: 16px;"><?= $location['city'] . ', ' . $location['state'] . ', ' . $location['pincode'] ?></p>
            <p style="margin: 5px 0; color: #777; font-size: 16px;"><?= $contact['mobile_number'] ?></p>
            <p style="margin: 5px 0; color: #777; font-size: 16px;"><?= $contact['email'] ?></p>
        </div>
    </div>

    <div class="section" style="margin-bottom: 30px;">
        <h2 style="border-bottom: 3px solid #28a745; padding-bottom: 10px; font-size: 28px; color: #28a745;">Education</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr>
                    <th style="border-bottom: 2px solid #ddd; padding: 12px; text-align: left; background-color: #f5f5f5; color: #333; font-size: 14px;">College</th>
                    <th style="border-bottom: 2px solid #ddd; padding: 12px; text-align: left; background-color: #f5f5f5; color: #333; font-size: 14px;">Degree</th>
                    <th style="border-bottom: 2px solid #ddd; padding: 12px; text-align: left; background-color: #f5f5f5; color: #333; font-size: 14px;">Year of Passing</th>
                    <th style="border-bottom: 2px solid #ddd; padding: 12px; text-align: left; background-color: #f5f5f5; color: #333; font-size: 14px;">Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->education_info as $education) { ?>
                    <tr>
                        <td style="border-bottom: 1px solid #ddd; padding: 12px;"><?= $education['college'] ?></td>
                        <td style="border-bottom: 1px solid #ddd; padding: 12px;"><?= $education['degree'] ?></td>
                        <td style="border-bottom: 1px solid #ddd; padding: 12px;"><?= $education['year_of_passing'] ?></td>
                        <td style="border-bottom: 1px solid #ddd; padding: 12px;"><?= $education['percentage'] ?>%</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="section" style="margin-bottom: 30px;">
        <h2 style="border-bottom: 3px solid #28a745; padding-bottom: 10px; font-size: 28px; color: #28a745;">Skills</h2>
        <p style="font-size: 16px; color: #333; margin-top: 10px;">
            <?php
            $skills = $data->skills_info;
            echo implode(', ', array_map('ucfirst', $skills));
            ?>
        </p>
    </div>

    <div class="section" style="margin-bottom: 30px;">
        <h2 style="border-bottom: 3px solid #28a745; padding-bottom: 10px; font-size: 28px; color: #28a745;">Experience</h2>
        <div class="experience-list" style="margin-top: 15px;">
            <?php foreach ($data->experience_info as $experience) { ?>
                <div class="experience-item" style="margin-bottom: 20px; border-left: 6px solid #28a745; padding-left: 15px;">
                    <h3 style="margin: 0; font-size: 22px; color: #333;"><?= ucfirst($experience['company']) ?></h3>
                    <p style="margin: 5px 0; font-size: 16px; color: #555;">
                        <?= $experience['year_of_experience'] . ($experience['year_of_experience'] > 1 ? " Years of Experience" : " Year of Experience") ?>
                    </p>
                    <p style="font-size: 16px; color: #333;"><?= nl2br($experience['description']) ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
