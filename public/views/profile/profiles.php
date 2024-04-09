<?php

use Thesis\config\Validation;

/** 
 *  Read: 
 *  * The file is on: views/profile/profiles.php
 *  - This file belongs to both teachers & students
 *  - This file enables teachers and students to update their profiles, the attributes as follows:
 *    1- country 
 *    2- post code (zip-code)
 *    3- the current address (address)
 *    4- phone number
 *  - Both teachers & students has full control over this file, but none can edit, delete each 
 *     others information. 
 *  Todo:
 *  ? By no mean this documentation is perfect, I tried my best to explain everything which helps 
 *  ? to understand the project flow. 
 */
?>
<?php require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header'); ?>
<?php

use Thesis\config\Auth;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\controllers\profile\InsertUserProfile;
use Thesis\functions\Roles;

?>
<?php Auth::authenticate([Roles::getRole('isStudent'), Roles::getRole('isTeacher')]); ?>
<?php $auth = new Auth();?>
<?php $validation = new Validation(); ?>
<?php $flash = new FlashMessage(); ?>
<?php $insert = new InsertUserProfile($database, $validation, $auth, $flash); ?>
<?php $errors = $insert->insertProfile(); ?>
<?php path("navbar"); ?>
<?php path(
  'sidebar',
  [
    'roles' => $roles,
    'username' => $username,
    'user_id' => $user_id,
    'database' => $database
  ]
); // sidebar
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="height: auto;">
  <section class="content">
    <div class="card"></div>
    <div class="container-fluid">
      <div class="row">
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
                <?php $posts = $insert->users('userinformation', Auth::user_id()); ?>
                <?php if (!empty($posts)) {
                  $user_id = $posts['user_id'];
                  $country = $posts['country'];
                  $address = $posts['address'];
                  $code  = $posts['zip_code'];
                  $phoneNumber = $posts['phone_number'];
                } ?>
                <form method="POST" action="<?php ClearInput::selfURL(); ?>">
                  <?php FlashMessage::displayMessages(); ?>
                  <div class="row">
                    <div class="col-lg-12">
                      <!-- <div class="form-group"> -->
                      <input type="hidden" class="form-control" name="user_main_id" placeholder="User Main ID" value="<?php echo $user_id ?>" readonly>
                      <?php //error($errors, 'user_main_id'); 
                      ?>
                      <!-- </div> -->
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="user_country" placeholder="Where are you from ?" value="<?php echo isset($country) ? $country : getInputValue('user_country');
                                                                                                                              ?>">
                        <?php error($errors, 'user_country'); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="user_address" value="<?php echo isset($address) ? $address : getInputValue('user_address'); ?>" placeholder="Where do you live">
                        <?php error($errors, 'user_address'); ?>
                      </div>
                    </div>
                  </div>
                  <!--  -->
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="user_post_code" placeholder="Post code e.g, 12345" value="<?php echo isset($code) ? $code : getInputValue('user_post_code'); ?>">
                        <?php error($errors, 'user_post_code'); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="phone_number" placeholder="Phone number" value="<?php echo isset($phoneNumber) ? $phoneNumber : getInputValue('phone_number'); ?>">
                        <?php error($errors, 'phone_number'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-footer">
                      <button type="submit" name="insert_user_profile_button" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php path("footer"); ?>