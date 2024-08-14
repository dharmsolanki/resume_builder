<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "resume_data".
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $contact_info
 * @property string $location_info
 * @property string $social_media_info
 * @property string $education_info
 * @property string $skills_info
 * @property string $experience_info
 * @property string $created_at
 * @property string $updated_at
 */
class ResumeData extends \yii\db\ActiveRecord
{
    public $email;
    public $mobile_number;
    public $state;
    public $city;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'contact_info', 'location_info', 'social_media_info', 'education_info', 'skills_info', 'experience_info', 'created_at', 'updated_at'], 'required'],
            [['contact_info', 'location_info', 'social_media_info', 'education_info', 'skills_info', 'experience_info', 'created_at', 'updated_at'], 'safe'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'contact_info' => 'Contact Info',
            'location_info' => 'Location Info',
            'social_media_info' => 'Social Media Info',
            'education_info' => 'Education Info',
            'skills_info' => 'Skills Info',
            'experience_info' => 'Experience Info',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
