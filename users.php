<?php
// users.php - this will be called by ajax in the other codeshare.
$.ajax({
    url: "./user_class.php",
    success: function(result){
        db->prepare(result);
    },
    post: $populate_user_row() 
});


// Call the populate_user_row function with POST data

?>
