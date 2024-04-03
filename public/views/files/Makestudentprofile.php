<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Thesis\controllers\students\Register;

$register = new Register();
$register->findStudents();
