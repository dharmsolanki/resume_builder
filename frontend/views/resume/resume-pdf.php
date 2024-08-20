<div class="resume" style="font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 20px; background-color: #fff;">
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div class="photo">
            <img src="path_to_dummy_photo.jpg" alt="Adeline Palmerston" style="border-radius: 50%; width: 150px; height: 150px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        </div>
        <div class="contact-info" style="text-align: left;">
            <h1 style="margin: 0; font-size: 32px; color: #333;"><?= ucfirst($data->first_name) . " " . ucfirst($data->last_name) ?></h1>
            <p style="margin: 5px 0; color: #666; font-size: 16px;">📍 <?= json_decode($data->location_info)->city . ', ' . json_decode($data->location_info)->state . ', ' . json_decode($data->location_info)->pincode ?></p>
            <p style="margin: 5px 0; color: #666; font-size: 16px;">📞 <?= json_decode($data->contact_info)->mobile_number ?></p>
            <p style="margin: 5px 0; color: #666; font-size: 16px;">✉️ <?= json_decode($data->contact_info)->email ?></p>
        </div>
    </div>

    <div class="section" style="margin-bottom: 30px;">
        <h2 style="border-bottom: 2px solid #000; padding-bottom: 5px; font-size: 24px; color: #444;">Education</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f9f9f9; color: #333;">College</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f9f9f9; color: #333;">Degree</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f9f9f9; color: #333;">Year of Passing</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f9f9f9; color: #333;">Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (json_decode($data->education_info) as $education) { ?>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 12px;"><?= $education->college ?></td>
                        <td style="border: 1px solid #ddd; padding: 12px;"><?= $education->degree ?></td>
                        <td style="border: 1px solid #ddd; padding: 12px;"><?= $education->year_of_passing ?></td>
                        <td style="border: 1px solid #ddd; padding: 12px;"><?= $education->percentage ?>%</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="section" style="margin-bottom: 30px;">
        <h2 style="border-bottom: 2px solid #000; padding-bottom: 5px; font-size: 24px; color: #444;">Skills</h2>
        <p style="font-size: 16px; color: #333; margin-top: 15px;">
            <?php
            $skills = json_decode($data->skills_info);
            echo implode(', ', array_map('ucfirst', $skills));
            ?>
        </p>
    </div>

    <div class="section" style="margin-bottom: 30px;">
        <h2 style="border-bottom: 2px solid #000; padding-bottom: 5px; font-size: 24px; color: #444;">Experience</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f9f9f9; color: #333;">Company Name</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f9f9f9; color: #333;">Years of Experience</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f9f9f9; color: #333;">Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (json_decode($data->experience_info) as $experience) { ?>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 12px;"><?= ucfirst($experience->company) ?></td>
                        <td style="border: 1px solid #ddd; padding: 12px;">
                            <?= $experience->year_of_experience . ($experience->year_of_experience > 1 ? " Years" : " Year") ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 12px;"><?= nl2br($experience->description) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>