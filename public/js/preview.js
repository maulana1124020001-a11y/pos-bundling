function previewImage(event) {

    let image = document.getElementById('preview');

    image.src = URL.createObjectURL(event.target.files[0]);
}