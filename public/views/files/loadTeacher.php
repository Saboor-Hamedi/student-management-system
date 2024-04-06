<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use Thesis\config\CallById;
use Thesis\model\load\TeacherLoader;
$callByID = new CallById();
$loadTeacher = new TeacherLoader($callByID);
$loadTeacher->loadTeacher();
           
