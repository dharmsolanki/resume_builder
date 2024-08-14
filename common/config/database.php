<?php
$dbhostx = "localhost";
$dbport = "3306";
$dbUser = "dharm";
$dbPass = "Drc@1234";
$db = "resume_builder";
return
    [
        'class' => 'yii\db\Connection',
        'dsn' => "mysql:host=$dbhostx;port=3306;dbname=$db",
        'emulatePrepare' => true,
        'username' => "$dbUser",
        'password' => "$dbPass",
        'charset' => 'utf8',
    ];
