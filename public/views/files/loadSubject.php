<?php
use Thesis\config\CallById;
use Thesis\model\load\SubjectLoader;
require_once __DIR__ . '/../../../vendor/autoload.php';
$callByID = new CallById();
$loadSubject = new SubjectLoader($callByID);
$loadSubject->loadSubject();
