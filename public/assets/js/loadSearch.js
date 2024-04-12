$(document).ready(function () {
  let originalTable = $('#dataTable').html();
  let debounceTimeout;

  // Improved debounce function
  function debounce(func, delay) {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(func, delay);
  }

  // Enhanced search function
  function searchScore(searchText) {
    if (searchText.trim() === '') {
      revertToOriginalTable();
      return;
    }

    $.ajax({
      url: '../../views/files/loadSearch.php',
      type: 'POST',
      data: { search: searchText },
      success: function (html) {
        if(searchText.trim() === 0 || html.trim() === ''){
           showFlashMessage("No match found", 'info');
        } else {
          updateTable(html);
          showFlashMessage("Records Found", 'success');
        }
      },
      error: function () {
        showFlashMessage("Error occurred while searching", 'danger');
      },
      
    });
  }

  // Event listener for input changes on search input with debouncing
  $('#searchInput').on('input', function () {
    let searchText = $(this).val().trim().toLowerCase();
    debounce(() => searchScore(searchText), 300);
  });

  // Clear search input and revert to original table on clear button click
  $('#clearSearchBtn').on('click', function () {
    $('#searchInput').val('').trigger('input');
  });

  // Helper functions
  function revertToOriginalTable() {
    $('#dataTable').html(originalTable);
    clearFlashMessages();
  }

  function updateTable(html) {
    $('#dataTable tbody').html(html);
    deleteData(); // Assuming deleteData is defined elsewhere
  }

});
