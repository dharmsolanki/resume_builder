<?php

namespace frontend\controllers;

use common\models\ResumeData;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ResumeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new ResumeData();
        $getState = $this->getState();

        return $this->render('index', [
            'model' => $model,
            'getState' => $getState,
            'skills' => $this->getSkills(),
        ]);
    }

    public function actionCreate()
    {
        $model = new ResumeData();
        $getState = $this->getState();
        $model->template = $this->request->get() ? $this->request->get('template') : "default";

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->identity->id;

            $model->contact_info = [
                'email' => $model->email,
                'mobile_number' => $model->mobile_number
            ];
            // echo '<pre>'; print_r($_POST);exit();
            $model->location_info = [
                'state' => $_POST['ResumeData']['state'],
                'city' => $model->city ?? null,
                'pincode' => $model->pincode ?? null,
            ];


            $model->social_media_info = $model->linkdin ?? '';
            $model->education_info = $model->education_info;
            $model->skills_info = $model->skills_info;
            $model->experience_info = $model->experience_info;
            // $model->template = $_POST['template'];

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                $filePath = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;

                if ($model->file->saveAs($filePath)) {
                    // Save the file path in the database
                    $model->file = $filePath;
                } else {
                    Yii::$app->session->setFlash('error', 'File upload failed.');
                    return $this->render('create', ['model' => $model]);
                }
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Success!');
                return $this->redirect(['resume/manage-resume']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to create!');
                return $this->redirect(['resume/index']);
            }
        }

        return $this->render('index', [
            'model' => $model,
            'getState' => $getState,
            'skills' => $this->getSkills(),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = ResumeData::findOne($id);
        $getState = $this->getState();
        $model->user_id = Yii::$app->user->identity->id;
        // Extract email and mobile number from contact_info
        if (!empty($model->contact_info)) {
            $contactInfo = $model->contact_info;
            $model->email = $contactInfo['email'] ?? null;
            $model->mobile_number = $contactInfo['mobile_number'] ?? null;
        }
        if (!empty($model->location_info)) {
            $locationInfo = $model->location_info;
            $model->state = $locationInfo['state'] ?? null;
            $model->city = $locationInfo['city'] ?? null;
            $model->pincode = $locationInfo['pincode'] ?? null;
        }

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->contact_info = [
                'email' => $model->email,
                'mobile_number' => $model->mobile_number
            ];

            $model->location_info = [
                'state' => $_POST['ResumeData']['state'],
                'city' => $model->city,
                'pincode' => $model->pincode,
            ];

            $model->social_media_info = $model->linkdin ?? '';
            $model->education_info = $model->education_info;
            $model->skills_info = $model->skills_info;
            $model->experience_info = $model->experience_info;

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                $filePath = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;

                if ($model->file->saveAs($filePath)) {
                    // Save the file path in the database
                    $model->file = $filePath;
                } else {
                    Yii::$app->session->setFlash('error', 'File upload failed.');
                    return $this->render('create', ['model' => $model]);
                }
            }
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Resume updated successfully!');
                return $this->redirect(['resume/manage-resume']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update resume!');
            }
        }

        return $this->render('index', [
            'model' => $model,
            'getState' => $getState,
            'skills' => $this->getSkills(),
        ]);
    }

    public function actionGetCity()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['output' => '', 'selected' => ''];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $state_id = $parents[0];
                $cities = $this->getCityByState($state_id);

                $out['output'] = [];
                foreach ($cities as $city) {
                    $out['output'][] = ['id' => $city, 'name' => $city];
                }

                return $out;
            }
        }

        return $out;
    }

    public function actionManageResume()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ResumeData::find()->where(['user_id' => Yii::$app->user->identity->id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('manage_resume', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionDownload($id, $action)
    {
        $data = ResumeData::findOne($id);
        $state = $this->getState()[$data->location_info['state']];
        $html = $this->renderPartial($data->template ? 'templates/' . $data->template : 'templates/default', [
            'data' => $data,
            'state' => $state
        ]);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('Resume.pdf', $action === 'print' ? \Mpdf\Output\Destination::INLINE : \Mpdf\Output\Destination::DOWNLOAD);
    }

    private function getState()
    {
        return [
            'AP' => 'Andhra Pradesh',
            'AR' => 'Arunachal Pradesh',
            'AS' => 'Assam',
            'BR' => 'Bihar',
            'CT' => 'Chhattisgarh',
            'GA' => 'Goa',
            'GJ' => 'Gujarat',
            'HR' => 'Haryana',
            'HP' => 'Himachal Pradesh',
            'JK' => 'Jammu and Kashmir',
            'JH' => 'Jharkhand',
            'KA' => 'Karnataka',
            'KL' => 'Kerala',
            'MP' => 'Madhya Pradesh',
            'MH' => 'Maharashtra',
            'MN' => 'Manipur',
            'ML' => 'Meghalaya',
            'MZ' => 'Mizoram',
            'NL' => 'Nagaland',
            'OR' => 'Odisha',
            'PB' => 'Punjab',
            'RJ' => 'Rajasthan',
            'SK' => 'Sikkim',
            'TN' => 'Tamil Nadu',
            'TG' => 'Telangana',
            'TR' => 'Tripura',
            'UP' => 'Uttar Pradesh',
            'UT' => 'Uttarakhand',
            'WB' => 'West Bengal',
            'AN' => 'Andaman and Nicobar Islands',
            'CH' => 'Chandigarh',
            'DN' => 'Dadra and Nagar Haveli',
            'DD' => 'Daman and Diu',
            'LD' => 'Lakshadweep',
            'DL' => 'National Capital Territory of Delhi',
            'PY' => 'Puducherry',
        ];
    }


    private function getCityByState($state_id)
    {
        $cityByState = [
            'AP' => [
                'Adilabad',
                'Anantapur',
                'Chittoor',
                'Kakinada',
                'Guntur',
                'Hyderabad',
                'Karimnagar',
                'Khammam',
                'Krishna',
                'Kurnool',
                'Mahbubnagar',
                'Medak',
                'Nalgonda',
                'Nizamabad',
                'Ongole',
                'Hyderabad',
                'Srikakulam',
                'Nellore',
                'Visakhapatnam',
                'Vizianagaram',
                'Warangal',
                'Eluru',
                'Kadapa',
            ],
            'AR' => [
                'Anjaw',
                'Changlang',
                'East Siang',
                'Kurung Kumey',
                'Lohit',
                'Lower Dibang Valley',
                'Lower Subansiri',
                'Papum Pare',
                'Tawang',
                'Tirap',
                'Dibang Valley',
                'Upper Siang',
                'Upper Subansiri',
                'West Kameng',
                'West Siang',
            ],
            'AS' => [
                'Baksa',
                'Barpeta',
                'Bongaigaon',
                'Cachar',
                'Chirang',
                'Darrang',
                'Dhemaji',
                'Dima Hasao',
                'Dhubri',
                'Dibrugarh',
                'Goalpara',
                'Golaghat',
                'Hailakandi',
                'Jorhat',
                'Kamrup',
                'Kamrup Metropolitan',
                'Karbi Anglong',
                'Karimganj',
                'Kokrajhar',
                'Lakhimpur',
                'Marigaon',
                'Nagaon',
                'Nalbari',
                'Sibsagar',
                'Sonitpur',
                'Tinsukia',
                'Udalguri',
            ],
            'BR' => [
                'Araria',
                'Arwal',
                'Aurangabad',
                'Banka',
                'Begusarai',
                'Bhagalpur',
                'Bhojpur',
                'Buxar',
                'Darbhanga',
                'East Champaran',
                'Gaya',
                'Gopalganj',
                'Jamui',
                'Jehanabad',
                'Kaimur',
                'Katihar',
                'Khagaria',
                'Kishanganj',
                'Lakhisarai',
                'Madhepura',
                'Madhubani',
                'Munger',
                'Muzaffarpur',
                'Nalanda',
                'Nawada',
                'Patna',
                'Purnia',
                'Rohtas',
                'Saharsa',
                'Samastipur',
                'Saran',
                'Sheikhpura',
                'Sheohar',
                'Sitamarhi',
                'Siwan',
                'Supaul',
                'Vaishali',
                'West Champaran',
                'Chandigarh',
            ],
            'CG' => [
                'Bastar',
                'Bijapur',
                'Bilaspur',
                'Dantewada',
                'Dhamtari',
                'Durg',
                'Jashpur',
                'Janjgir-Champa',
                'Korba',
                'Koriya',
                'Kanker',
                'Kabirdham (Kawardha)',
                'Mahasamund',
                'Narayanpur',
                'Raigarh',
                'Rajnandgaon',
                'Raipur',
                'Surguja',
            ],
            'DN' => [
                'Dadra and Nagar Haveli'
            ],
            'DD' => [
                'Daman',
                'Diu',
            ],
            'DL' => [
                'Central Delhi',
                'East Delhi',
                'New Delhi',
                'North Delhi',
                'North East Delhi',
                'North West Delhi',
                'South Delhi',
                'South West Delhi',
                'West Delhi',
            ],
            'GA' => [
                'North Goa',
                'South Goa'
            ],
            'GJ' => [
                'Ahmedabad',
                'Amreli district',
                'Anand',
                'Banaskantha',
                'Bharuch',
                'Bhavnagar',
                'Dahod',
                'The Dangs',
                'Gandhinagar',
                'Jamnagar',
                'Junagadh',
                'Kutch',
                'Kheda',
                'Mehsana',
                'Narmada',
                'Navsari',
                'Patan',
                'Panchmahal',
                'Porbandar',
                'Rajkot',
                'Sabarkantha',
                'Surendranagar',
                'Surat',
                'Vyara',
                'Vadodara',
                'Valsad',
            ],
            'HR' => [
                'Ambala',
                'Bhiwani',
                'Faridabad',
                'Fatehabad',
                'Gurgaon',
                'Hissar',
                'Jhajjar',
                'Jind',
                'Karnal',
                'Kaithal',
                'Kurukshetra',
                'Mahendragarh',
                'Mewat',
                'Palwal',
                'Panchkula',
                'Panipat',
                'Rewari',
                'Rohtak',
                'Sirsa',
                'Sonipat',
                'Yamuna Nagar',
            ],
            'HP' => [
                'Bilaspur',
                'Chamba',
                'Hamirpur',
                'Kangra',
                'Kinnaur',
                'Kullu',
                'Lahaul and Spiti',
                'Mandi',
                'Shimla',
                'Sirmaur',
                'Solan',
                'Una',
            ],
            'JK' => [
                'Anantnag',
                'Badgam',
                'Bandipora',
                'Baramulla',
                'Doda',
                'Ganderbal',
                'Jammu',
                'Kargil',
                'Kathua',
                'Kishtwar',
                'Kupwara',
                'Kulgam',
                'Leh',
                'Poonch',
                'Pulwama',
                'Rajauri',
                'Ramban',
                'Reasi',
                'Samba',
                'Shopian',
                'Srinagar',
                'Udhampur',
            ],
            'JH' => [
                'Bokaro',
                'Chatra',
                'Deoghar',
                'Dhanbad',
                'Dumka',
                'East Singhbhum',
                'Garhwa',
                'Giridih',
                'Godda',
                'Gumla',
                'Hazaribag',
                'Jamtara',
                'Khunti',
                'Koderma',
                'Latehar',
                'Lohardaga',
                'Pakur',
                'Palamu',
                'Ramgarh',
                'Ranchi',
                'Sahibganj',
                'Seraikela Kharsawan',
                'Simdega',
                'West Singhbhum',
            ],
            'KA' => [
                'Bagalkot',
                'Bangalore Rural',
                'Bangalore Urban',
                'Belgaum',
                'Bellary',
                'Bidar',
                'Bijapur',
                'Chamarajnagar',
                'Chikkamagaluru',
                'Chikkaballapur',
                'Chitradurga',
                'Davanagere',
                'Dharwad',
                'Dakshina Kannada',
                'Gadag',
                'Gulbarga',
                'Hassan',
                'Haveri district',
                'Kodagu',
                'Kolar',
                'Koppal',
                'Mandya',
                'Mysore',
                'Raichur',
                'Shimoga',
                'Tumkur',
                'Udupi',
                'Uttara Kannada',
                'Ramanagara',
                'Yadgir',
            ],
            'KL' => [
                'Alappuzha',
                'Ernakulam',
                'Idukki',
                'Kannur',
                'Kasaragod',
                'Kollam',
                'Kottayam',
                'Kozhikode',
                'Malappuram',
                'Palakkad',
                'Pathanamthitta',
                'Thrissur',
                'Thiruvananthapuram',
                'Wayanad',
            ],
            'MP' => [
                'Alirajpur',
                'Anuppur',
                'Ashok Nagar',
                'Balaghat',
                'Barwani',
                'Betul',
                'Bhind',
                'Bhopal',
                'Burhanpur',
                'Chhatarpur',
                'Chhindwara',
                'Damoh',
                'Datia',
                'Dewas',
                'Dhar',
                'Dindori',
                'Guna',
                'Gwalior',
                'Harda',
                'Hoshangabad',
                'Indore',
                'Jabalpur',
                'Jhabua',
                'Katni',
                'Khandwa (East Nimar)',
                'Khargone (West Nimar)',
                'Mandla',
                'Mandsaur',
                'Morena',
                'Narsinghpur',
                'Neemuch',
                'Panna',
                'Rewa',
                'Rajgarh',
                'Ratlam',
                'Raisen',
                'Sagar',
                'Satna',
                'Sehore',
                'Seoni',
                'Shahdol',
                'Shajapur',
                'Sheopur',
                'Shivpuri',
                'Sidhi',
                'Singrauli',
                'Tikamgarh',
                'Ujjain',
                'Umaria',
                'Vidisha',
            ],
            'MH' => [
                'Ahmednagar',
                'Akola',
                'Amravati',
                'Aurangabad',
                'Bhandara',
                'Beed',
                'Buldhana',
                'Chandrapur',
                'Dhule',
                'Gadchiroli',
                'Gondia',
                'Hingoli',
                'Jalgaon',
                'Jalna',
                'Kolhapur',
                'Latur',
                'Mumbai City',
                'Mumbai suburban',
                'Nandurbar',
                'Nanded',
                'Nagpur',
                'Nashik',
                'Osmanabad',
                'Parbhani',
                'Pune',
                'Raigad',
                'Ratnagiri',
                'Sindhudurg',
                'Sangli',
                'Solapur',
                'Satara',
                'Thane',
                'Wardha',
                'Washim',
                'Yavatmal',
            ],
            'MN' => [
                'Bishnupur',
                'Churachandpur',
                'Chandel',
                'Imphal East',
                'Senapati',
                'Tamenglong',
                'Thoubal',
                'Ukhrul',
                'Imphal West',
            ],
            'ML' => [
                'East Garo Hills',
                'East Khasi Hills',
                'Jaintia Hills',
                'Ri Bhoi',
                'South Garo Hills',
                'West Garo Hills',
                'West Khasi Hills',
            ],
            'MZ' => [
                'Aizawl',
                'Champhai',
                'Kolasib',
                'Lawngtlai',
                'Lunglei',
                'Mamit',
                'Saiha',
                'Serchhip',
            ],
            'NL' => [
                'Dimapur',
                'Kohima',
                'Mokokchung',
                'Mon',
                'Phek',
                'Tuensang',
                'Wokha',
                'Zunheboto',
            ],
            'OR' => [
                'Angul',
                'Boudh (Bauda)',
                'Bhadrak',
                'Balangir',
                'Bargarh (Baragarh)',
                'Balasore',
                'Cuttack',
                'Debagarh (Deogarh)',
                'Dhenkanal',
                'Ganjam',
                'Gajapati',
                'Jharsuguda',
                'Jajpur',
                'Jagatsinghpur',
                'Khordha',
                'Kendujhar (Keonjhar)',
                'Kalahandi',
                'Kandhamal',
                'Koraput',
                'Kendrapara',
                'Malkangiri',
                'Mayurbhanj',
                'Nabarangpur',
                'Nuapada',
                'Nayagarh',
                'Puri',
                'Rayagada',
                'Sambalpur',
                'Subarnapur (Sonepur)',
                'Sundergarh',
            ],
            'PY' => [
                'Karaikal',
                'Mahe',
                'Pondicherry',
                'Yanam',
            ],
            'PB' => [
                'Amritsar',
                'Barnala',
                'Bathinda',
                'Firozpur',
                'Faridkot',
                'Fatehgarh Sahib',
                'Fazilka',
                'Gurdaspur',
                'Hoshiarpur',
                'Jalandhar',
                'Kapurthala',
                'Ludhiana',
                'Mansa',
                'Moga',
                'Sri Muktsar Sahib',
                'Pathankot',
                'Patiala',
                'Rupnagar',
                'Ajitgarh (Mohali)',
                'Sangrur',
                'Nawanshahr',
                'Tarn Taran',
            ],
            'RJ' => [
                'Ajmer',
                'Alwar',
                'Bikaner',
                'Barmer',
                'Banswara',
                'Bharatpur',
                'Baran',
                'Bundi',
                'Bhilwara',
                'Churu',
                'Chittorgarh',
                'Dausa',
                'Dholpur',
                'Dungapur',
                'Ganganagar',
                'Hanumangarh',
                'Jhunjhunu',
                'Jalore',
                'Jodhpur',
                'Jaipur',
                'Jaisalmer',
                'Jhalawar',
                'Karauli',
                'Kota',
                'Nagaur',
                'Pali',
                'Pratapgarh',
                'Rajsamand',
                'Sikar',
                'Sawai Madhopur',
                'Sirohi',
                'Tonk',
                'Udaipur',
            ],
            'SK' => [
                'East Sikkim',
                'North Sikkim',
                'South Sikkim',
                'West Sikkim',
            ],
            'TN' => [
                'Ariyalur',
                'Chennai',
                'Coimbatore',
                'Cuddalore',
                'Dharmapuri',
                'Dindigul',
                'Erode',
                'Kanchipuram',
                'Kanyakumari',
                'Karur',
                'Madurai',
                'Nagapattinam',
                'Nilgiris',
                'Namakkal',
                'Perambalur',
                'Pudukkottai',
                'Ramanathapuram',
                'Salem',
                'Sivaganga',
                'Tirupur',
                'Tiruchirappalli',
                'Theni',
                'Tirunelveli',
                'Thanjavur',
                'Thoothukudi',
                'Tiruvallur',
                'Tiruvarur',
                'Tiruvannamalai',
                'Vellore',
                'Viluppuram',
                'Virudhunagar',
            ],
            'TR' => [
                'Dhalai',
                'North Tripura',
                'South Tripura',
                'Khowai',
                'West Tripura',
            ],
            'UP' => [
                'Agra',
                'Allahabad',
                'Aligarh',
                'Ambedkar Nagar',
                'Auraiya',
                'Azamgarh',
                'Barabanki',
                'Budaun',
                'Bagpat',
                'Bahraich',
                'Bijnor',
                'Ballia',
                'Banda',
                'Balrampur',
                'Bareilly',
                'Basti',
                'Bulandshahr',
                'Chandauli',
                'Chhatrapati Shahuji Maharaj Nagar',
                'Chitrakoot',
                'Deoria',
                'Etah',
                'Kanshi Ram Nagar',
                'Etawah',
                'Firozabad',
                'Farrukhabad',
                'Fatehpur',
                'Faizabad',
                'Gautam Buddh Nagar',
                'Gonda',
                'Ghazipur',
                'Gorakhpur',
                'Ghaziabad',
                'Hamirpur',
                'Hardoi',
                'Mahamaya Nagar',
                'Jhansi',
                'Jalaun',
                'Jyotiba Phule Nagar',
                'Jaunpur district',
                'Ramabai Nagar (Kanpur Dehat)',
                'Kannauj',
                'Kanpur',
                'Kaushambi',
                'Kushinagar',
                'Lalitpur',
                'Lakhimpur Kheri',
                'Lucknow',
                'Mau',
                'Meerut',
                'Maharajganj',
                'Mahoba',
                'Mirzapur',
                'Moradabad',
                'Mainpuri',
                'Mathura',
                'Muzaffarnagar',
                'Panchsheel Nagar district (Hapur)',
                'Pilibhit',
                'Shamli',
                'Pratapgarh',
                'Rampur',
                'Raebareli',
                'Saharanpur',
                'Sitapur',
                'Shahjahanpur',
                'Sant Kabir Nagar',
                'Siddharthnagar',
                'Sonbhadra',
                'Sant Ravidas Nagar',
                'Sultanpur',
                'Shravasti',
                'Unnao',
                'Varanasi',
            ],
            'UK' => [
                'Almora',
                'Bageshwar',
                'Chamoli',
                'Champawat',
                'Dehradun',
                'Haridwar',
                'Nainital',
                'Pauri Garhwal',
                'Pithoragarh',
                'Rudraprayag',
                'Tehri Garhwal',
                'Udham Singh Nagar',
                'Uttarkashi',
            ],
            'WB' => [
                'Birbhum',
                'Bankura',
                'Bardhaman',
                'Darjeeling',
                'Dakshin Dinajpur',
                'Hooghly',
                'Howrah',
                'Jalpaiguri',
                'Cooch Behar',
                'Kolkata',
                'Maldah',
                'Paschim Medinipur',
                'Purba Medinipur',
                'Murshidabad',
                'Nadia',
                'North 24 Parganas',
                'South 24 Parganas',
                'Purulia',
                'Uttar Dinajpur',
            ],
        ];

        return isset($cityByState[$state_id]) ? $cityByState[$state_id] : [];
    }

    private function getSkills()
    {
        return [
            'php' => 'php',
            'react' => 'react',
            'css' => 'css',
            'javascript' => 'javascript',
            'laravel' => 'laravel',
            'yii2' => 'yii2',
            'html' => 'html',
            'git' => 'git',
            'mysql' => 'mysql',
            'nodejs' => 'nodejs',
            'bootstrap' => 'bootstrap',
            'docker' => 'docker'
        ];
    }

    public function actionTemplates()
    {
        return $this->render('pdf_templates');
    }
}
