<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use Thesis\controllers\subjects\StoreSubjects;
$handle = new StoreSubjects();

$handle->loadTeacher();
           
