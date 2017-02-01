<?php require_once('partials/_common.php'); ?>
<?php require_once('partials/_header.php'); ?>


<div class="container">
	<?php
		if(isset($_GET['success-login'])) {
			echo '<p style="text-align:center; font-size: 30px; margin-bottom:50px;">Успешна регистрация</p>';
		}

		phpinfo();
	exit;
	?>

	<form method="post" action="<?php echo $config['base']; ?>_processLoginForm.php" class="login-form" name="login-form">
	    <fieldset>
	        <legend>Login</legend>
	        <ol>
	            <li>
	                <label for="login_name">Username / email</label>
	                <input type="text" name="login_name" value="" id="login_name"/>
	            </li>     
	            <li>
	                <label for="password">password</label>
	                <input type="password" name="password" value="" id="password"/>
	            </li> 
	            <li>
	                <button type="submit" id="submit-btn">Вход</button>
	            </li>
	        </ol>
	    </fieldset>
	</form>
	
</div>	

	<script type="text/javascript"> 
		// User validation
        $(function() {
			var $this = $('.login-form');
    		var validator = new FormValidator('login-form', [{
			    name: 'login_name',
			    rules: 'required'
			}, {
			    name: 'password',
			    rules: 'required'
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
                        if (jQuery.isEmptyObject($response.errors)) {
                            window.location.href = '<?php echo $config['base']; ?>home.php';
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

<?php require_once('partials/_footer.php'); ?>

