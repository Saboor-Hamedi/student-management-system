<?php

namespace Thesis\config;

use Exception;

class FlashMessage
{
    private static $messages = [];

    public static function setMessage(string $message, string $type = 'info')
    {
        self::$messages[] = [
            'message' => $message,
            'type' => $type,
        ];
    }

    public static function getMessages()
    {
        return self::$messages;
    }

    public static function clearMessages()
    {
        self::$messages = [];
    }

    public static function displayMessages()
    {
        $messages = self::getMessages();
        if ($messages) {
            echo '<div class="flash-messages">';
            foreach ($messages as $message) {
                echo '<div class="flash-message alert alert-' . $message['type'] . '" role="alert">' . $message['message'] . '</div>';
            }
            echo '</div>';
            self::clearMessages();
        }
    }
    public static function addMessageWithException(string $message, Exception $exception, string $type = 'info')
    {
        self::$messages[] = [
            'message' => $message . ' ' . $exception->getMessage(),
            'type' => $type,
        ];
    }
}

?>
<script>
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
</script>