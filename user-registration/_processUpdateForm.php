<?php
require_once('partials/_common.php');

$rules = array(
    'required' => array(
        'username'
    ),
    'valid-email' => array(
        'email',
    ),
);


$errors = validate($rules, $_POST);

$response = array(
    'errors' => $errors
);

// Check for existence
if (empty($errors)) {
    // Email must be unique
    $sth = $conn->prepare('SELECT `username`, `email` FROM `users` WHERE email = :email AND user_id <> :user_id LIMIT 1');
    $sth->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
    $sth->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $sth->execute();
    $alreadyRegistered = $sth->fetch(PDO::FETCH_OBJ);
    if (!empty($alreadyRegistered)) {
        $response['errors']['submit-btn'] = 'Съществуващ email!';
        die(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    // Username must be unique
    $sth = $conn->prepare('SELECT `username`, `email` FROM `users` WHERE username = :username AND user_id <> :user_id LIMIT 1');
    $sth->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $sth->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
    $sth->execute();
    $alreadyRegistered = $sth->fetch(PDO::FETCH_OBJ);
    if (!empty($alreadyRegistered)) {
        $response['errors']['submit-btn'] = 'Съществуващ username';
        die(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    // Data Changes
    $sth = $conn->prepare('UPDATE `users`
						   SET `username` = :username,
						   	   `email` = :email
						   WHERE `user_id` = :user_id');
    $sth->bindParam(':username', $_POST['username']);
    $sth->bindParam(':email', $_POST['email']);
    $sth->bindParam(':user_id', $_SESSION['user_id']);
    $sth->execute();
    }
die(json_encode($response, JSON_UNESCAPED_UNICODE));