function login(){
    $.post("authenticate.php", $("#login_form").serialize())
        // success function
        .done(function(){
            // redirect
            window.location = "../";
        })
        // received an error
        // note: .done and .fail have the parameters of the callback in different orders
        .fail(function(request){
            // server responds with 403 if the username/password was bad
            if (request.status == 403){
                alert('Username and password do not match \n');
            }
        });
}
