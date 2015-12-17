function commentSubmit(){
    $.post("comment.php", $("#comment_form").serialize())
        //remove the hidden parent id field after commenting (if it exists)
        .done(function(){
            if( $('parent').length ){
                $('#comment_form').remove('#parent');
            }
            //spårutskrift för att se om .post faktiskt lyckades (gör inte det just nu)
            $("#responseText").text('success');
        });
}

//Adds a hidden field with parent comment id to the form
function replyToComment(comment_id){
    $('<input>').attr({
        type: 'hidden',
        id: 'parent',
        value: comment_id
    }).appendTo('#comment_form');
}
