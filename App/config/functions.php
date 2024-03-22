<?php
// change timeozome 
function formatCreatedAt($createdAt)
{
    $dateTime = new DateTime($createdAt);
    return $dateTime->format('Y-m-j');
}

// kept the text on input 
function getInputValue($fieldName)
{
    return isset($_POST[$fieldName]) ? htmlspecialchars($_POST[$fieldName]) : "";
}
function hash_password($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function encrypt($id, $salt)
{
    $encrypted_id = base64_encode($id . $salt);
    $encrypted_id = rtrim($encrypted_id, '='); // remove the = from the very end of url = id
    return $encrypted_id;
}

function decrypt($encrypted_id, $salt)
{
    $decrypted_id = base64_decode($encrypted_id);
    $decrypted_id = str_replace($salt, '', $decrypted_id);
    return $decrypted_id;
}
