<?php

namespace Thesis\config;

use Exception;

class FlashMessage
{
  public static function setMessage(string $message, string $type = 'info')
  {
    // Check if the session variable is not set or is an empty array
    if (!isset($_SESSION['flash_messages']) || !is_array($_SESSION['flash_messages'])) {
      $_SESSION['flash_messages'] = [];
  }

    // Check if a message of the same type already exists
    foreach ($_SESSION['flash_messages'] as $existingMessage) {
      if ($existingMessage['type'] === $type) {
        // If a message of the same type exists, do not add a new one
        return;
      }
    }
    $_SESSION['flash_messages'][] = [
      'message' => $message,
      'type' => $type,
    ];
  }

  public static function getMessages()
  {
    $messages = $_SESSION['flash_messages'] ?? [];
    $_SESSION['flash_messages'] = []; // Clear messages after retrieval
    return $messages;
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
    }
  }

  public static function addMessageWithException(string $message, Exception $exception, string $type = 'info')
  {
    self::setMessage($message . ' ' . $exception->getMessage(), $type);
  }

  // public static function redirect(string $url, string $message, string $type = 'info')
  // {
  //   self::setMessage($message, $type);
  //   header("Location:" . BASE_URL . "{$url}");
  //   exit; // Ensure no further output is sent
  // }
  public static function redirect(string $url, string $message, string $type = 'info')
{
    // Use a unique session variable to prevent redirection loop
    if (!isset($_SESSION['redirected'])) {
        $_SESSION['redirected'] = true;
        self::setMessage($message, $type);
        header("Location:" . BASE_URL . "{$url}");
        exit; // Ensure no further output is sent
    } else {
        // Clear the session variable after use
        unset($_SESSION['redirected']);
    }
}

}
