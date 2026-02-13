// Image preview for uploaded profile photo
document.addEventListener('DOMContentLoaded', function(){
    var input = document.getElementById('photoInput');
    var preview = document.getElementById('photoPreview');
    if(!input || !preview) return;
    input.addEventListener('change', function(e){
        var file = e.target.files && e.target.files[0];
        if(!file) return;
        var reader = new FileReader();
        reader.onload = function(ev){
            preview.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });
});
