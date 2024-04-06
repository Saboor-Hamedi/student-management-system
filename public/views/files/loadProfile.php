<?php
/**
 * * this function loads the student profile or the student id on views/student/register.php
 */
require_once __DIR__ . '/../../../vendor/autoload.php';
use Thesis\controllers\students\Register;
$register = new Register();
$register->loadProfiles();
