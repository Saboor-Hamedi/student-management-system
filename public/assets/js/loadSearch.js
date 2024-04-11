$(document).ready(function () {
  // Store the original table structure
  let originalTable = $('#dataTable').html();
  // Function to handle search and update table
  function performSearch(searchText) {
    $.ajax({
      url: '../../views/files/loadSearch.php',
      type: 'POST',
      data: { search: searchText },
      success: function (html) {
        if (html.trim() !== '') {
          // Update the table body with search results
          $('#dataTable tbody').html(html);
          attachDeleteHandlers(); // Reattach delete button click handlers
          showFlashMessage("Records Found", 'success');
        } else {
          // If no records found, revert to original table structure
          $('#dataTable').html(originalTable);
          showFlashMessage("No Records Found", 'danger');
        }
      },
      error: function () {
        showFlashMessage("Error occurred while searching", 'danger');
      }
    });
  }

  // Event listener for input changes on search input
  $('#searchInput').on('input', function () {
    let searchText = $(this).val().trim().toLowerCase();

    if (searchText.length > 1) {
      performSearch(searchText);
    } else {
      // When search input is cleared, revert to original table structure
      $('#dataTable').html(originalTable);
    }
  });

  // Function to attach delete button click handlers to dynamically added delete buttons
  function attachDeleteHandlers() {
    $('#dataTable').off('click', '.deleteScore_').on('click', '.deleteScore_', function (e) {
      e.preventDefault();
      var $deleteButton = $(this);
      var scoreId = $deleteButton.data('id');

      // Prompt user for confirmation
      if (confirm("Are you sure you want to delete this record?")) {
        deleteRecord(scoreId)
          .then(function () {
            // If deletion succeeds, remove the corresponding table row
            $deleteButton.closest('tr').remove();
            showFlashMessage("Record deleted successfully", 'success');
          })
          .catch(function (error) {
            showFlashMessage("Failed to delete record. Please try again.", 'danger');
          });
      }
    });
  }

  // Function to handle delete record via AJAX
  function deleteRecord(scoreId) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        type: "POST",
        url: "../../views/files/DeleteScore.php",
        data: { id: scoreId },
        dataType: "json",
        success: function (response) {
          if (response.success) {
            resolve();
          } else {
            reject("Error deleting record");
          }
        },
        error: function (xhr, status, error) {
          reject("AJAX request failed: " + status + ", " + error);
        },
      });
    });
  }
});
