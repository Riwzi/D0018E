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



function create_account(){
    $.post("create_account.php", $("#account_form").serialize())
        // success function
        .done(function(){
            // redirect
            window.location = "../";
        })
        // received an error
        // note: .done and .fail have the parameters of the callback in different orders
        .fail(function(request){
            // server responds with 403 if there was a problem
            if (request.status == 403){
                alert('Username and password do not match \n');
            }
        });
}
