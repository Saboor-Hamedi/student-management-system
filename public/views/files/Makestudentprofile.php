<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
use Thesis\controllers\profile\Register;
$studentprofile = new Register();
$studentprofile->search_for_students_profile();
