function showFlashMessage(message, type = 'success') {
  var $flashMessage = $('#message');
  $flashMessage.removeClass('alert-success alert-danger').addClass('alert-' + type).html(message + '<button type="button" class="close" data-dismiss="alert">&times;</button>').fadeIn();
}
$(function() {
  var flashMessage = sessionStorage.getItem('flashMessage');
  var flashMessageType = sessionStorage.getItem('flashMessageType');

  if (flashMessage && flashMessageType) {
    showFlashMessage(flashMessage, flashMessageType);
    sessionStorage.removeItem('flashMessage');
    sessionStorage.removeItem('flashMessageType');
  }
  // Close flash message when close button is clicked
  $('#message').on('click', '.close', function() {
    $(this).closest('.alert').fadeOut();
  });
});
