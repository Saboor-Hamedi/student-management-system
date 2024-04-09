$(document).ready(function() {
  $('#searchInput').on('input', function() {
      let searchText = $(this).val().toLowerCase();
      $('#dataTable tbody tr').each(function() {
          let rowText = $(this).text().toLowerCase();
          if (rowText.includes(searchText)) {
              $(this).show();
          } else {
              $(this).hide();
          }
      });
  });
});
