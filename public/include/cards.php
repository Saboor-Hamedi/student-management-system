<?php

use Thesis\config\Database;

$database = Database::GetInstance();
$connection = $database->connect();
?>
<?php require_once __DIR__ . '/getsession.php'; ?>
<div class="container-fluid">
    <div class="row mb-2"></div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1">
                    <i class="fas fa-screwdriver-wrench" style="font-size:30px"></i>
                </span>
                <div class="info-box-content">
                    <?php
                    $admin_count = $database->getUserCountByRole(0);
                    $admin_string = "";
                    if ($admin_count == 0) {
                        $admin_string = "Admin";
                    } else if ($admin_count == 1) {
                        $admin_string = "Admin";
                    } else {
                        $admin_string = "Admins";
                    }
                    ?>
                    <span class="info-box-number"><?php echo $admin_count; ?></span>
                    <p><?php echo $admin_string; ?></p>
                </div>
            </div>

        </div>
        <!-- ./col -->
        <div class="col-12 col-sm-6 col-md-3">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-users" style="font-size:30px"></i>
                </span>
                <div class="info-box-content">
                    <?php
                    $student_count = $database->getUserCountByRole(1);
                    $student_string = "";
                    if ($student_count == 0) {
                        $student_string = "Student";
                    } else if ($student_count == 1) {
                        $student_string = "Student";
                    } else {
                        $student_string = "Students";
                    }
                    ?>
                    <span class="info-box-number"><?php echo $student_count; ?></span>
                    <p><?php echo $student_string; ?></p>
                </div>
            </div>

        </div>
        <!-- ./col -->
        <div class="col-12 col-sm-6 col-md-3">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1">
                    <i class="fas fa-user" style="font-size:30px"></i>
                </span>
                <div class="info-box-content">
                    <?php
                    $teacher_count = $database->getUserCountByRole(2);
                    $teacher_string = "";
                    if ($teacher_count == 0) {
                        $teacher_string = "Teacher";
                    } else if ($teacher_count == 1) {
                        $teacher_string = "Teacher";
                    } else {
                        $teacher_string = "Teachers";
                    }
                    ?>
                    <span class="info-box-number"><?php echo $teacher_count; ?></span>
                    <p><?php echo $teacher_string; ?></p>
                </div>
            </div>

        </div>
        <!-- ./col -->
        <div class="col-12 col-sm-6 col-md-3">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-warning elevation-1">
                    <i class="fas fas-people" style="font-size:30px"></i>
                    <i class="fas fa-person-dress" style="font-size:30px"></i>
                </span>
                <div class="info-box-content">
                    <?php
                    $parents_count = $database->getUserCountByRole(3);
                    $parents_string = "";
                    if ($parents_count == 0) {
                        $parents_string = "Parent";
                    } else if ($parents_count == 1) {
                        $parents_string = "Parent";
                    } else {
                        $parents_string = "Parents";
                    }
                    ?>
                    <span class="info-box-number"><?php echo $parents_count; ?></span>
                    <p><?php echo $parents_string; ?></p>
                </div>
            </div>

        </div>
    </div>
</div>
<!--  -->