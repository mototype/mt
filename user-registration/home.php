<?php
require_once ('partials/_common.php');
require_once ('partials/_header.php');

// User Data
if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
	exit;
}
// Session
$user_id = $_SESSION['user_id'];

$sth = $conn->prepare('SELECT `username`, `email`, `names`, `birth_year` FROM `users` WHERE `user_id` = :user_id');
$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$sth->execute();
$userInfo = $sth->fetch(PDO::FETCH_OBJ);

?>

<div class="container">
	<div id="welcome_msg">Welcome back <strong><?php echo $userInfo->username; ?></strong> ! </div>
	<br>
	<br>
	<a href="javascript:;" class="toggle-btn">Change Your Data</a>
	<br>
	<br>

	<form method="post" style="display:none;" action="<?php echo $config['base']; ?>_processUpdateForm.php" class="edit-form" name="edit-form">
		<fieldset>
			<legend>Change Data</legend>
			<ol>
				<li>
					<label for="username">username</label>
					<input type="text" name="username" value="<?php echo $userInfo->username; ?>" id="username"/>
				</li>
				<li>
					<label for="email">email</label>
					<input type="email" name="email" value="<?php echo $userInfo->email; ?>" id="email"/>
				</li>
				<li>
					<button type="submit" id="submit-btn">submit</button>
				</li>
				<li>
					<a href="changePassword.php">Change Password</a>
				</li>
			</ol>
		</fieldset>
	</form>
</div>
<script type="text/javascript">
	$(function() {
		// Toggle form
		$('.toggle-btn').on('click', function (e) {
			e.preventDefault();

			$('.edit-form').toggle();
		});
		// User validation
		var $this = $('.edit-form');
		var validator = new FormValidator('edit-form', [{
				name: 'username'
			}, {
				name: 'email',
				rules: 'valid_email'

			}],
			function(errors, event) {
				event.preventDefault();

				if (errors.length > 0) {
					this.printValidationErrors($this, errors);
					return;
				}

				$.ajax({
					url: $this.attr('action'),
					data: $this.serialize(),
					type: 'POST',
					dataType: 'json',
					success: function($response) {
						if ($.isEmptyObject($response.errors)) {
							window.location.href = '<?php echo $config['base']; ?>home.php?success-edit';
						} else {
							// Print errors for each field
							for (var key in $response.errors) {
								$('#'+ key).parents('li').append('<div class="validation-errors">'+ $response.errors[key] +'</div>');
							}

						}
					}
				});
			});
	});

</script>
<a href="logout.php">Logout</a>

