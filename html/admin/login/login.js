function login(){
    $("#responseText").load(
        "authenticate.php",
        {
            username: $("#username").val(),
            password: $("#password").val()
        },
        function(response, status, request){
            if (status=="success"){
                // redirect to /admin/
                // TODO actually do it
            }else if(status="error"){
                // stay on this page and show an error message
                // TODO ???
            }
            alert("response: " + response + "\nstatus: " + status
                    + "\nreq.status: " + request.status);
            /**/
        }
    );
}
