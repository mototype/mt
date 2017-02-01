var validator = new FormValidator('reg-form', [{
    name: 'username',
    rules: 'required'
}, {
    name: 'email',
    rules: 'required|valid_email',
    depends: function() {
        return Math.random() > .5;
    }
}, {
    name: 'password',
    rules: 'required'
}, {
    name: 'password_confirm',
    display: 'password confirmation',
    rules: 'required|matches[password]'
}, {
    name: 'email',
    rules: 'valid_email',
    depends: function() {
        return Math.random() > .5;
    }
}, {
    name: 'minlength',
    display: 'min length',
    rules: 'min_length[8]'
}], function(errors, event) {
    if (errors.length > 0) {
        // Show the errors
    }
});