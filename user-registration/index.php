<?php require_once('partials/_common.php'); ?>
<?php require_once('partials/_header.php'); ?>


	<div class="container">
		
		<form method="post" action="<?php echo $config['base']; ?>_processRegForm.php" class="reg-form" name="reg-form">
		    <fieldset>
		        <legend>Registration</legend>
		        <ol>
		            <li>
		                <label for="username">username</label>
		                <input type="text" name="username" value="" id="username"/>
		            </li>     
		            <li>
		                <label for="email">email</label>
		                <input type="email" name="email" value="" id="email"/>
		            </li>      
		            <li>
		                <label for="password">password</label>
		                <input type="password" name="password" value="" id="password"/>
		            </li> 
		            <li>
		                <label for="password_confirm">repeat password</label>
		                <input type="password" name="password_confirm" value="" id="password_confirm"/>
		            </li>
		            <li>
		                <label for="names">names</label>
		                <input type="text" name="names" value="" id="names"/>
		            </li>  
		            <li>
		            	<label for="birth_year">Birth year</label>
		            	<select name="birth_year" id="birth_year">
		            			<option value="">-- Моля, изберете! --</option>
		            		<?php foreach ($years_number as $year): ?>
		            			
		            			<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
		            			
		            		<?php endforeach ?>
		            	</select>
		            </li>
		            <li>
                        <label for="agree" class="checkbox">
                            <input type="checkbox" name="agree" id="agree" value="yes">
                            <span>Съгласен съм с бщите условия</span>
                        </label>
                    </li>
		            <li>
		                <button type="submit" id="submit-btn">submit</button>
		            </li>
		        </ol>
		    </fieldset>
		</form>
	</div>	
	<script type="text/javascript"> 
		// User validation
        $(function() {
			var $this = $('.reg-form');
    		var validator = new FormValidator('reg-form', [{
			    name: 'username',
			    rules: 'required'
			}, {
			    name: 'email',
			    rules: 'required|valid_email'
			}, {
			    name: 'birth_year',
			    rules: 'required'
			}, {
			    name: 'password',
			    rules: 'required|min_length[6]'
			}, {
			    name: 'password_confirm',
			    rules: 'required|matches[password]|min_length[6]'
			}, {
			    name: 'names',
			    rules: 'required'
			}, {
			    name: 'agree',
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
                        if ($.isEmptyObject($response.errors)) {
                            window.location.href = '<?php echo $config['base']; ?>login.php?success-reg';
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