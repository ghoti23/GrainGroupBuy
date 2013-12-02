$(document).ready(function() {
	var errorContainer = $('#error-message'), form = $('#adminLoginForm'), btn = form.find('button'), errorHandler = function() {
		errorContainer.show();
		btn.button('reset');
	};
    var viewModal = $('#viewModal'),
        forgotPasswordForm = $('#forgotPassword'),
        registerForm = $('#signupForm'),
        registerMessage =$('#message-signup');

	form.submit(function() {
		btn.button('loading');
		$('#results tbody > tr').remove();
		var data = form.serializeObject();
		errorContainer.hide();
		if (data.username.length < 1 && data.password.length < 1) {
			errorHandler.call();
			return false;
		} else {
			$.ajax({
				data : data,
				cache : false,
				type : 'POST',
				success : function(resp) {
					if (resp != null && (resp.errors || resp.message)) {
						errorHandler.call();
					} else {
						window.location.href = 'dashboard.php';
					}
				},
				url : "api/login.php"
			});
			return false;
		}

	});

    $( "#forgot" ).click(function() {
        viewModal.modal('show');
    });
    forgotPasswordForm.submit(function() {
        var data = forgotPasswordForm.serializeObject();

        $.ajax({
            data : data,
            cache : false,
            type : 'POST',
            success : function(resp) {
                viewModal.modal('hide');
            },
            url : "forgotpassword.php"
        });
        return false;

    });

    registerForm.submit(function() {
        var data = registerForm.serializeObject();

        $.ajax({
            data : data,
            cache : false,
            type : 'POST',
            success : function(resp) {
                registerMessage.html("Please wait 24-48 hours for approval");
                registerMessage.addClass("alert-success");
            },
            url : "register.php"
        });
        return false;

    });
}); 