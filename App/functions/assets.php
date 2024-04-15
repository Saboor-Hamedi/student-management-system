<?php

function assets($file, $root = '/assets/')
{
  // ensure file is a non-empty string 

  if (!is_string($file) || empty($file)) {
    throw new InvalidArgumentException('File path must be non-empty string.');
  }
  // ensure root ends with a slash
  if (substr($root, -1) !== '/') {
    $root .= '/';
  }
  // ensure file does not start with slash
  $file = ltrim($file, '/');
  echo $root . $file;
  /* return ROOT . ltrim($file, '/'); */
}
function error($errors, $field)
{
  if (isset($errors[$field])) {
    echo '<small class="error">' . $errors[$field] . '</small>';
  }
}
