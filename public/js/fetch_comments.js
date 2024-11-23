


async function getComment_id(recetaId, userid) {

    if (!recetaId) {
        console.error("ID de receta no especificado en la URL.");
        return;
    }

    if (!userid) {
        console.error("no se ha iniciado session.");
        return;
    }

    try {
        const url =  `<?php echo BASE_URL . '/controllers/CommentController.php?action=getComment_id&receta_id=${recetaId}&user_id=${userid}'; ?>`
        const response = await fetch(url, {
            method: 'GET',
        });

        if (!response.ok) {
            throw new Error("Error al cargar comentarios.");
        }

        const comments = await response.json();

        if (comments.length > 0) {
            const comentarios = document.getElementById("tu-comentario-texbox");
            const fecha = document.getElementById('fecha');
            const estrella = document.querySelectorAll('.tuComentario-container .rating .fa-star');
            const estrallaInput = document.getElementById('selected-rating');
            const estrellaAsignado = comments[0]['estrellas'];
            const tuComentario = document.querySelector('.tuComentario-container');
            const btnComentario = document.getElementById('btn-subir-comentario');
            const btnAction = document.getElementById('btn-subir-comentario');
            
            tuComentario.classList.add('disabled')
            comentarios.value = comments[0]['comentario']
            fecha.innerText = comments[0]['fecha']
            estrallaInput.value = comments[0]['estrellas']
            btnComentario.innerText = 'actualizar';
            
            btnComentario.setAttribute('type', 'button');
            btnAction.value = 'updateComentario';



            btnComentario.addEventListener('click', recetaId => {
                setTimeout(()=>{
                    btnComentario.innerText = 'subir';
                    btnComentario.setAttribute('type', 'submit');
                    tuComentario.classList.remove('disabled')
                }, 100);

            })



            for (let i = 0; i < estrellaAsignado; i++) {
                estrella[ i ].classList.add('filled');
            }
        } else {
            console.log('no hay comentarios personal')
        }
    } catch (error) {
        console.error("Error:", error);
        document.getElementById("comments-list").innerHTML = "<p>Error al cargar comentarios.</p>";
    }
}



async function getCommentAll(recetaId) {

    if (!recetaId) {
        console.error("ID de receta no especificado en la URL.");
        return;
    }


    try {
        const url =  `<?php echo BASE_URL . '/controllers/CommentController.php?action=getComment&receta_id=${recetaId}'; ?>`;
        const response = await fetch(url, {
            method: 'GET',
        });

        if (!response.ok) {
            throw new Error("Error al cargar comentarios.");
        }

        const comments = await response.json();
        const commentsList = document.getElementById("comentarios-lista-container");

        if (comments.length === 0) {
            commentsList.innerHTML = "<p>No hay comentarios para esta receta.</p>";
        } else {
            cargarComentarios(comments);
        }
    } catch (error) {
        console.error("Error:", error);
        document.getElementById("comments-list").innerHTML = "<p>Error al cargar comentarios.</p>";
    }
}

function cargarComentarios(comentarios) {
    const user_id = document.getElementById('user_id').value
    const container = document.querySelector('#comentarios-lista-container');
    comentarios.forEach(comment => {
        if(user_id != comment.user_id){
            container.innerHTML += `
                <div class="comentario">
                    <div class="imagen-perfil-container"> 
                    
                        <img src="<?php echo BASE_URL; ?>/public/img/${comment.imagen_perfil ?? 'default.png'}" class="imagen-perfil">
                    </div>
                    <div class="comentario-contenido">
                        <div class="usuario">${comment.nombre_usuario}</div>
                        <div class="texto">${comment.comentario}</div>
                        <div class="rating">
                            ${Array(5).fill().map((_, i) => `
                                <i class="${i < comment.estrellas ? 'fa-solid' : 'fa-regular'} fa-star"></i>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
        }


        
    });

}
