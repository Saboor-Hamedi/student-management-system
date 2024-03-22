$(document).ready(function () {
  'use strict';
  // Event listener for input changes
  $('#test').on('input', function () {
      var inputValue = $(this).val().trim();
      console.log('AJAX request initiated');

      // Make an AJAX call to the PHP file
      $.ajax({
        url: '../../views/files/test.php', // Replace 'path/to/your/php/file.php' with the actual path to your PHP file
        method: 'POST',
        data: { input: inputValue }, // You can send input data to the PHP file if needed
        dataType: 'html', // Change the dataType to 'html' if you expect HTML response
        success: function (response) {
          // Handle the successful response here
          // For example, update a div with the response
          $('#result').html(response);
        },
        error: function () {
          // Handle errors here
          console.error('Error occurred while loading PHP file.');
        }
      });
  });
});
