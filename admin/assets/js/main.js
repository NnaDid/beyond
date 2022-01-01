$(document).ready(function(){

    let $document = $(document);
   

    // for the comment Form 
    $document.on("submit", ".relyMessageForm", function(evt){
        evt.preventDefault();
        $(".result").html('<i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i>');
    });



});