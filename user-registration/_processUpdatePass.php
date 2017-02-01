<?php
require_once('partials/_common.php');


// Validate password only if present
if ($_POST['password'] != '') {
    $rules['match-string'] = array(
        'password',
        'password_confirm',
    );

    $rules['min-length'] = array(
        'password' => 6,
        'password_confirm' => 6,
    );
} else {
    $rules['min-length'] = array(
        'password' => 6,
        'password_confirm' => 6,
    );
}
// Old Password
if ($_POST['old_password'] != '') {
    $rules['required'] = array(
        'old_password'
    );
}

if (isset($_POST['old_password'])) {
    $_POST['old_password'] = md5($_POST['old_password']);
}

$sth = $conn->prepare('SELECT password FROM users WHERE user_id = :user_id');
$sth->bindParam(':user_id', $_SESSION['user_id']);
$sth->execute();
$oldPassword = $sth->fetchObject();
$_POST['old_password_from_db'] = $oldPassword->password;

$rules['match-string'] = array('old_password', 'old_password_from_db');

$errors = validate($rules, $_POST);

$response = array(
    'errors' => $errors
);

    // Password change
    $sth = $conn->prepare('UPDATE `users`
						   SET `password` = :password
						   WHERE `user_id` = :user_id');
    $sth->bindParam(':password', md5($_POST['password']));
    $sth->bindParam(':user_id', $_SESSION['user_id']);
    $sth->execute();

die(json_encode($response, JSON_UNESCAPED_UNICODE));
