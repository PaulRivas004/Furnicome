/*
*   Controlador de uso general en las páginas web del sitio privado.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'business/dashboard/usuario.php';
// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (JSON.session) {
        // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            HEADER.innerHTML = `
            <div class="dropdown">
            <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown"
                aria-expanded="false">
                <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle"
                    height="25" alt="Black and White Portrait of a Man" loading="lazy" />
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                <li>
                    <a class="dropdown-item" href="#">verified_user<b>${JSON.username}</b></a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">Settings</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">Logout</a>
                </li>
            </ul>
        </div>
            `;
            // Se inicializa el componente Dropdown para que funcione la lista desplegable en los menús.

        } else {
            sweetAlert(3, JSON.exception, false, 'dashboard.html');
        }
    } else {
        // Se comprueba si la página web es la principal, de lo contrario se direcciona a iniciar sesión.
        if (location.pathname == '/Furnicome/private/index.html') {           
            // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.          
        } else {
            location.href = 'index.html';
        }
    }
});