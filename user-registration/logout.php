<?php
require_once('partials/_common.php');
require_once ('partials/_header.php');

// Logout
unset($_SESSION["username"]);
unset($_SESSION["user_id"]);
session_write_close();

header("Location: login.php");