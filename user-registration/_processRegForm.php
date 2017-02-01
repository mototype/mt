<?php 
require_once('partials/_common.php');
    // Validation
	$errors = validate(array(
        'required' => array(
            'username',
            'email',
            'password',
            'password_confirm',
            'names',
            'birth_year',
            'agree',
        ),
        'valid-email' => array(
            'email',
        ),
        'match-string' => array(
        	'password', 
        	'password_confirm', 
        ),
        'min-length' => array(
        	'password' => 6, 
        	'password_confirm' => 6,
        ),
    ), $_POST);

    $response = array(
        'errors' => $errors
    );

    $conn = connection();

    // Check if registered
    if (empty($errors)) {
    	$sth = $conn->prepare('SELECT `username`, `email` FROM `users` WHERE email = :email OR username = :username LIMIT 1'); 

        $sth->bindParam(':username', $_POST['username'], PDO::PARAM_STR); 
    	$sth->bindParam(':email', $_POST['email'], PDO::PARAM_STR); 
    	$sth->execute();
    	$alreadyRegistered = $sth->fetch(PDO::FETCH_OBJ);

    	if (!empty($alreadyRegistered)) {
 			$response['errors']['submit-btn'] = 'Вече сте се регистрирали.';
    		die(json_encode($response, JSON_UNESCAPED_UNICODE));
    	}

		// Add user
		$sth = $conn->prepare('INSERT INTO `users`
							 (`username`, `email`, `password`, `names`, `birth_year`, `user_reg_date`)
							   VALUES
							 (:username, :email, :password, :names, :birth_year, :user_reg_date) ');
		$date = date('Y-m-d H:i:s');
		$sth->bindParam(':username', $_POST['username']);
		$sth->bindParam(':email', $_POST['email']);
		$sth->bindParam(':password', md5($_POST['password']));
		$sth->bindParam(':names', $_POST['names']);
		$sth->bindParam(':birth_year', $_POST['birth_year']);
		$sth->bindParam(':user_reg_date', $date);
 		$sth->execute();
    }

	die(json_encode($response, JSON_UNESCAPED_UNICODE));  