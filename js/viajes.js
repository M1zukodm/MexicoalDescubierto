document.getElementById('photo').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const photoPreview = document.getElementById('photoPreview');

    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            photoPreview.innerHTML = `<img src="${e.target.result}" alt="Vista previa de la foto">`;
        };
        
        reader.readAsDataURL(file);
    } else {
        photoPreview.innerHTML = ''; // Limpiar la vista previa si no hay archivo
    }
});

document.getElementById('commentForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el envío del formulario
    
    const title = document.getElementById('title').value;
    const name = document.getElementById('name').value;
    const comment = document.getElementById('comment').value;
    const photoInput = document.getElementById('photo');
    const photoFile = photoInput.files[0]; // Obtiene el archivo subido
    
    if (title && name && comment) {
        const commentList = document.querySelector('.comments-list');
        const newComment = document.createElement('div');
        newComment.classList.add('comment-item');
        
        const commentContent = document.createElement('div');
        commentContent.classList.add('comment-content');
        
        if (photoFile) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(photoFile); // Crea una URL local para la imagen
            img.alt = title;
            commentContent.appendChild(img);
        }
        
        const commentText = document.createElement('div');
        commentText.classList.add('comment-text');
        commentText.innerHTML = `<strong>${name}</strong> <em>${title}</em><p>${comment}</p>`;
        
        commentContent.appendChild(commentText);
        newComment.appendChild(commentContent);
        
        commentList.appendChild(newComment);
        
        // Limpiar el formulario
        document.getElementById('title').value = '';
        document.getElementById('photo').value = '';
        document.getElementById('name').value = '';
        document.getElementById('comment').value = '';
        document.getElementById('photoPreview').innerHTML = ''; // Limpiar vista previa
    }
});
