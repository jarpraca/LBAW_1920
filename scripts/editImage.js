$("#profile_img").click(function(e) {
    $("#image_upload").click();
});

function fasterPreview( uploader ) {
    if ( uploader.files && uploader.files[0] ){
          $('#profile_img').attr('src', 
             window.URL.createObjectURL(uploader.files[0]) );
    }
}

$("#image_upload").change(function(){
    fasterPreview( this );
});