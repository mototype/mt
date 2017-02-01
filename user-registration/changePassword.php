<?php require_once('partials/_common.php'); ?>
<?php require_once('partials/_header.php'); ?>


<div class="container">

    <form method="post" action="<?php echo $config['base']; ?>_processUpdatePass.php" class="pw-form" name="pw-form">
        <fieldset>
            <legend>Change your password</legend>
            <ol>
                <li>
                    <label for="old_password">old_password</label>
                    <input type="password" name="old_password" value="" id="old_password"/>
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
                    <button type="submit" id="submit-btn">submit</button>
                </li>
            </ol>
            <a href="home.php">Back</a>
        </fieldset>
    </form>
</div>

<script type="text/javascript">

        // User password validation
        var $this = $('.pw-form');
        var validator = new FormValidator('pw-form', [{
                name: 'password',
                rules: 'min_length[6]'
            }, {
                name: 'password_confirm',
                rules: 'matches[password]|min_length[6]'
            }, {
                name: 'old_password',
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
                            window.location.href = '<?php echo $config['base'] ?>home.php?success-change';
                        } else {
                            // Print errors for each field
                            for (var key in $response.errors) {
                                $('#'+ key).parents('li').append('<div class="validation-errors">'+ $response.errors[key] +'</div>');
                            }

                        }
                    }
                });
            });

</script>
<a href="logout.php">Logout</a>