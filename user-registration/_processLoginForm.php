<?php
require_once('partials/_common.php');

    $errors = validate(array(
        'required' => array(
            'login_name',
            'password',
        ),
    ), $_POST);

    $response = array(
        'errors' => $errors
    );

    if(!empty($errors)) {
        die(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

//d($password);

    // Login check
    $sth = $conn->prepare('SELECT `user_id` FROM `users` WHERE (`email` = :login_name OR `username` = :login_name) AND `password` = :password LIMIT 1');
    $sth->bindValue(':login_name', $_POST['login_name'], PDO::PARAM_STR);
    $password = md5($_POST['password']);
    $sth->bindValue(':password', $password, PDO::PARAM_STR);
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_OBJ);
    if(empty($row)) {
        $response['errors']['submit-btn'] = 'Няма такъв чоуек, чоуек!';
        die(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    $_SESSION['user_id'] = $row->user_id;

    die(json_encode($response, JSON_UNESCAPED_UNICODE));
