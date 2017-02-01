<?php 
session_start();
require_once 'db.php';

	$base = 'http://localhost:420/user-registration/';
	$config = array(
        'base' => $base,
        'assets' => $base . 'public/assets/frontend/',
    );

    $conn = connection();

    $date = date('Y-m-d H:i:s');

    $years_number = range(1901, date('Y'));


    // Insert into logs
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = 0;
    }

    $sth = $conn->prepare('INSERT INTO `logs`
                            (`date_time`, `user_ip`, `user_browser`, `user_id`)            
                            -- (`date_time`, `page_url`, `user_ip`, `user_browser`)            
                            VALUES
                            (:date_time, :user_ip, :user_browser, :user_id)');
                            // (:date_time, :page_url, :user_ip, :user_browser)');
    $sth->bindParam(':date_time', $date, PDO::PARAM_STR);
    // $sth->bindParam(':page_url', $_SERVER['HTTP_REFERER'], PDO::PARAM_STR); 
    $sth->bindParam(':user_ip', $_SERVER['SERVER_ADDR'], PDO::PARAM_STR); 
    $sth->bindParam(':user_browser', $_SERVER['HTTP_USER_AGENT'], PDO::PARAM_STR); 
    $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $sth->execute();

    // Dump function
	function d($what)
    {
        echo '<pre>';
        print_r($what);
        echo '</pre>';
    } 

    // Validate
    function validate($rules, $data)
    {
        $errors = array();

        foreach ($rules as $rule => $fields) {
            if ($rule == 'required') {
                foreach ($fields as $field) {
                    if (!isset($data[$field]) || mb_strlen($data[$field]) < 2) {
                        $errors[$field] = 'Field "' . $field . '" is required';
                    }
                }
            } elseif ($rule == 'valid-email') {
                foreach ($fields as $field) {
                    if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                        $errors[$field] = 'Field "' . $field . '" is not a valid email';
                    }
                }
            } elseif ($rule == 'match-string') {

            	if ($data[$fields[0]] !== $data[$fields[1]]) {

                    $errors[$fields[1]] = 'Passwords do not match';
            	}

             } elseif ($rule == 'min-length') {
             	foreach ($fields as $field => $length) {
	             	if (mb_strlen($data[$field]) < $length) {

		                 	$errors[$field] = 'Fields "' . $field . '" must be at least '. $length .' symbols.';
	                 	}

	                 }

            }
        }
        return $errors;
    }

