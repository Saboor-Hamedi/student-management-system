function showFlashMessage(message, type = 'success') {
  var $flashMessage = $('#message');
  if ($flashMessage.length === 0) {
    console.error("Flash message container not found");
    return;
  }
  $flashMessage.removeClass('alert-success alert-danger').addClass('alert-' + type).html(message + '<button type="button" class="close" data-dismiss="alert">&times;</button>').fadeIn();
}

function clearFlashMessages() {
  var $flashMessage = $('#message');
  if ($flashMessage.length) {
    $flashMessage.fadeOut().empty();
  }
}
$(function () {
  var flashMessage = sessionStorage.getItem('flashMessage');
  var flashMessageType = sessionStorage.getItem('flashMessageType');

  if (flashMessage && flashMessageType) {
    showFlashMessage(flashMessage, flashMessageType);
    sessionStorage.removeItem('flashMessage');
    sessionStorage.removeItem('flashMessageType');
  }
  // Close flash message when close button is clicked
  $('#message').on('click', '.close', function () {
    $(this).closest('.alert').fadeOut();
  });
});

