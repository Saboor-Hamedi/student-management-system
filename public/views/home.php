<?php

/** 
 *  Read: 
 *  * The file is on: views/home.php
 *  - This is a default file, where every single user redirect to this page for the first time
 *     but none can edit,delete or insert each others information.
 *  - This is a home page for all users which are allowed to login in
 *  Todo:
 *  ? By no mean this documentation is perfetc, I tried my best to explain everything which helps 
 *  ? to understand the project flow. 
 *  ! For more information visit file note.txt
 */
?>
<?php require_once __DIR__ . '/../../App/config/path.php'; ?>
<?php path('header'); // header 
?>
<?php

use Thesis\config\Auth;
use Thesis\config\FlashMessage;

?>
<?php Auth::authenticate([0, 1, 2]); ?>
<?php path('navbar'); // navbar 
?>
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
    <?php if ($roles === 0) : ?>
      <?php path('cards'); ?>
    <?php else : ?>
      <div class="card"></div>
    <?php endif; ?>
    <div class="container-fluid">
      
      <div class="row">
        <div class="col-12">
          <div class="card ">
            <div class="card-header">
              <h3 class="card-title">
                Welcome
                <?php echo ucfirst($username); ?>
              </h3>
            </div>
            <!-- body -->
            <div class="card-body">
            <?php FlashMessage::displayMessages(); ?>
              <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                <table class="table table-hover table-condensed">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <!-- fetch data -->
                  <tbody>
                    <?php $result = $database->GetUsersByRoleAndUserId('school.users', $roles, $user_id); ?>
                    <?php if (!empty($result)) : ?>
                      <?php foreach ($result as $user) : ?>
                        <tr class="odd">
                          <td class="dtr-control sorting_1" tabindex="0">
                            <?php echo ucfirst($user['username']); ?>
                          </td>
                          <td>
                            <?php echo $user['email']; ?>
                          </td>
                          <td>
                            <?php echo formatCreatedAt($user['created_at']); ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <tr>
                        <td colspan="3">No user added yet</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <p></p>
            </div>
          </div>
        </div>
        <!-- main body -->
      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>