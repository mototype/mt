<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registration</title>
	<style>
		html{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased}blockquote,figure,h1,h2,h3,h4,h5,h6,ol,p,ul{margin:0;padding:0}main{display:block}h1,h2,h3,h4{font-size:inherit}strong{font-weight:700}a,button{color:inherit}a{text-decoration:none}button{overflow:visible;border:0;font:inherit;-webkit-font-smoothing:inherit;letter-spacing:inherit;background:0 0;cursor:pointer}::-moz-focus-inner{padding:0;border:0}img{border:0}fieldset{border:none;padding:0;margin:0}ol,ul{list-style:none}table{border-collapse:collapse;border-spacing:0}
		
		.container {
			width: 1200px;
			margin: 0 auto;
			padding: 100px 0;
			border-left: 1px solid #666;
			border-right: 1px solid #666;
			border-bottom: 1px solid #666;
		}
		.login-form,
		.reg-form,
		.edit-form,
		.pw-form{
			padding: 0 30px
			text-align: center;
		}

		.login-form li,
		.reg-form li,
		.edit-form li,
		.pw-form li {
			margin: 0 auto 20px;
			text-align: center;
		}

		.login-form li select,
		.login-form li input,
		.reg-form li select,
		.reg-form li input,
		.edit-form li select,
		.edit-form li input,
		.pw-form li select,
		.pw-form li input {
			display: block;
			margin: 0 auto;
			padding: 6px 15px;
		}

		.login-form legend,
		.reg-form legend,
		.edit-form legend,
		.pw-form legend {
			font-size: 24px;
			font-weight: bold;
			margin-bottom: 50px;
			text-align: center;
			display: block;
		}
	
		.login-form li label,
		.reg-form li label,
		.edit-form li label,
		.pw-form li label {
			margin: 0 auto 5px;
			display: block;
			text-align: center;
		}
		.login-form button,
		.reg-form button {
			border: 1px solid #666;
			background-color: #666;
			color: #fff;
			padding: 10px 30px;
			border-radius: 20px;
		}
		.edit-form button,
		.pw-form button {
			border: 1px solid #666;
			background-color: #666;
			color: #fff;
			padding: 10px 30px;
			border-radius: 20px;

		}

	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="js/validate.min.js"></script>
</head>
<body>