<?php
/** 
 *  Read: 
 *  * The file is on: views/profile/profiles.php
 *  - This file belongs to both teachers & studetns
 *  - This file enables teachers and students to update their profiles, the attributes as follows:
 *    1- country 
 *    2- post code (zip-code)
 *    3- the current address (address)
 *    4- phone number
 *  - Both teachers & students has full control over this file, but none can edit, delete each 
 *     others information. 
 *  Todo:
 *  ? By no mean this documentation is perfetc, I tried my best to explain everything which helps 
 *  ? to understand the project flow. 
 */
?>
<?php require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header'); ?>
<?php 
use Thesis\config\Auth;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\controllers\profile\UserInformation;
use Thesis\functions\Roles;
?>
<?php
$insert_information = new UserInformation();
?>
<?php Auth::authenticate([Roles::getRole('isStudent'), Roles::getRole('isTeacher')]); ?>
<?php

$user_country_errors = '';
$user_address_errors = '';
$uuser_post_code_errors = '';
$phone_number_error = '';
$user_country = '';
$user_address = '';
$user_post_code = '';
$phone_number = '';
// move tot he top

if (isset($_POST['insert_user_profile_button'])) {
  $user_main_id = $_POST['user_main_id'];
  $user_country = $_POST['user_country'];
  $user_address = $_POST['user_address'];
  $user_post_code = $_POST['user_post_code'];
  $phone_number = $_POST['phone_number'];

  $result = $insert_information->validate_user_profile($user_main_id, $user_country, $user_address, $user_post_code, $phone_number);
  if (isset($result['errors'])) {
    // Handle validation errors
    $errors = $result['errors'];
    if (isset($errors['user_country'])) {
      $user_country_errors = $errors['user_country'];
    }
    if (isset($errors['user_address'])) {
      $user_address_errors = $errors['user_address'];
    }
    if (isset($errors['user_post_code'])) {
      $uuser_post_code_errors = $errors['user_post_code'];
    }
    if (isset($errors['phone_number'])) {
      $phone_number_error = $errors['phone_number'];
    }
  } else {
    // Data is valid, perform the insertion into the database
    $insert_information->insertOrUpdateUserInformation($user_main_id, $user_country, $user_address, $user_post_code, $phone_number);
  }
}
?>
<!-- header on the top, Navbar -->
<?php path("navbar"); ?>
<!-- Main Sidebar Container -->
<?php path('sidebar', ['roles' => $roles, 'username' => $username, 'user_id' => $user_id, 'database' => $database]); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="height: auto;">
  <section class="content">
    <?php //path("cards"); 
    ?>
    <div class="card"></div>
    <div class="container-fluid">
      <div class="row">
        <!-- student -->
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                Update Your Profile
              </h3>
            </div>
            <!-- body -->
            <div class="card-body">
              <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                <?php FlashMessage::displayMessages(); ?>
                <?php
                $inserted_data = $database->UserInfomation('school.userinformation', $user_id);
                if (!empty($inserted_data)) {
                  $user_country = $inserted_data[0]['country'];
                  $user_address = $inserted_data[0]['address'];
                  $user_post_code = $inserted_data[0]['zip_code'];
                  $phone_number = $inserted_data[0]['phone_number'];
                }

                ?>
                <!-- insert profile -->
                <form method="POST" action="<?php ClearInput::selfURL(); ?>">
                  <div class=" row">
                    <!-- display user_id -->
                    <div class="col-lg-12 mb-2">
                      <input type="hidden" class="form-control" name="user_main_id" placeholder="User Main ID" value="<?php echo $user_id; ?>">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="user_country" placeholder="Where are you from ?" value="<?php echo $user_country; ?>">
                        <span class="error">
                          <?php
                          if (isset($errors['user_country'])) {
                            echo $errors['user_country'];
                          }
                          ?>
                        </span>
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="user_address" value="<?php echo $user_address; ?>" placeholder="Where do you live">
                        <span class="error">
                          <?php
                          if (isset($errors['user_address'])) {
                            echo $errors['user_address'];
                          }
                          ?>
                        </span>
                      </div>
                    </div>
                    <!--  -->
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="user_post_code" 
                        placeholder="Post code e.g, 12345" value="<?php echo $user_post_code; ?>">
                        <span class="error">
                          <?php
                          if (isset($errors['user_post_code'])) {
                            echo $errors['user_post_code'];
                          }
                          ?>
                        </span>
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="phone_number" placeholder="Phone number" value="<?php echo $phone_number; ?>">
                        <span class="error">
                          <?php
                          if (isset($errors['phone_number'])) {
                            echo $errors['phone_number'];
                          }
                          ?>
                        </span>
                      </div>
                    </div>
                    <!--  -->
                  </div>
                  <div class="card">
                    <div class="card-footer">
                      <button type="submit" name="insert_user_profile_button" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
                <!-- end profile -->
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
</div>
</div>

<!-- end student -->
</div>
</div>
</section>
</div>
<?php path("footer"); ?>