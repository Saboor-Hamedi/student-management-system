<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use Thesis\controllers\subjects\StoreSubjects;
$req = new StoreSubjects();
$req->loadSubject();
