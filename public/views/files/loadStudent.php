<?php
require_once __DIR__ . '../../../../vendor/autoload.php';
use Thesis\config\CallById;
use Thesis\model\load\StudentLoader;
$callByID = new CallById();
$studentLoader  = new StudentLoader($callByID);
$studentLoader->loadStudent();