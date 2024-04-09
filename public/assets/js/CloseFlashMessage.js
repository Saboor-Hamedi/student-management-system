// Automatically close flash messages after 3 seconds
setTimeout(function() {
  var flashMessages = document.querySelectorAll('.flash-message');
  flashMessages.forEach(function(message) {
      message.classList.add('fade-out');
      setTimeout(function() {
          message.remove();
      }, 500); // Time to match the CSS transition duration
  });
}, 3000); // 3000 milliseconds = 3 seconds