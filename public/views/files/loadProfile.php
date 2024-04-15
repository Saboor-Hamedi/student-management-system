<?php
/**
 * * this function loads the student profile or the student id on views/student/register.php
 */
require_once __DIR__ . '/../../../vendor/autoload.php';

use Thesis\config\CallById;
use Thesis\config\Database;
use Thesis\config\Validation;
use Thesis\controllers\students\Register;
$database = Database::GetInstance();
$callByID = new CallById();
$validation = new Validation();
$register = new Register($database, $callByID, $validation);
$register->loadProfiles();
