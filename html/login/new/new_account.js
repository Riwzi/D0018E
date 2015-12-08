$(document).ready(function(){
    $('input[type="password"]').keyup(function(){
        // check if password 1 and 2 are the same
        if ($("#password").val() !== $("#password2").val()){
            // complain about password matching in the error field
            $("#password2 + .error").text("Passwords must match");
            //TODO display this in a better way
            //alert("passwords must match:\n" + $("#password").val() + "\n" + $("#password2").val());
        } else {
            // show no error message about matching passwords
            $("#password2 + .error").text("");
        }
    });
});
