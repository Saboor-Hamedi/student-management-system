<?php

/**
 * * This is responsible for search on scores table, this is code is only available for teachers
 */
require_once __DIR__ . '/../../../vendor/autoload.php';

use Thesis\config\Database;
use Thesis\controllers\scores\SearchScore;
use Thesis\functions\InputUtils;
?>
<?php $database = Database::GetInstance(); ?>
<?php
if (isset($_POST['search'])) { ?>
  <?php
  $searchText = $_POST['search'];
  $search = new SearchScore($database);
  $result = $search->search($searchText);
  ?>
  <?php if (is_array($result) && count($result) > 0) :  ?>
    <?php foreach ($result as $user) : ?>
      <!-- This div will be populated with the full list of records -->
      <div id="initialTableState" style="display: none;">
        <tr class="odd">
          <td><?php echo $user['lastname']; ?></td>
          <td><?php echo $user['subject_names']; ?></td>
          <td><?php echo $user['score']; ?></td>
          <?php if (isset($user['isScored'])) : ?>
            <td>
              <?php switch ($user['isScored']) {
                case 'complete':
                  echo '<span class="badge bg-success">Completed</span>';
                  break;
                case 'progress':
                  echo '<span class="badge bg-info">In Progress</span>';
                  break;
                default:
                  echo '<a href="#" class="btn btn-danger btn-xs deleteScore_" data-id="' . $user['score_id'] . '">Delete</a>';
              } ?>
            </td>
          <?php endif; ?>
        </tr>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
<?php } ?>
