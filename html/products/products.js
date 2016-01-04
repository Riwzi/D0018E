function commentSubmit(){
    $.post("comment.php", $("#comment_form").serialize())
        //remove the hidden parent id field after commenting (if it exists)
        .done(function(){
            if( $('response_to').length ){
                $('#comment_form').remove('response_to');
            }
            $("#comment_form_title").text("Submit a comment:");
        });
}

//Adds a hidden field with parent comment id to the form
function replyToComment(comment_id){
    $('<input>').attr({
        type: 'hidden',
        name: 'response_to',
        value: comment_id
    }).appendTo('#comment_form');
    $("#comment_form_title").text("Reply to comment:");
}

function rateProduct(rating){
    //Changes the hidden field value depending on if the rating was positive(1) or negative(0)
    $('#rating').val(rating);
    //Submits the form
    $.post("rate.php", $("#rate_form").serialize());
}
