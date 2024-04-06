<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use Thesis\config\CallById;
use Thesis\model\load\GradeLoader;
$callByID = new CallById();
$loadGrade = new GradeLoader($callByID);
// $loadGrade->loadSubject();