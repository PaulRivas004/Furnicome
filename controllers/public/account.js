/*
*   Controlador es de uso general en las páginas web del sitio público.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'business/public/cliente.php';
// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
    if (JSON.session) {
        HEADER.innerHTML = `
<div>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
<!-- Container wrapper -->
<div class="container-fluid">
    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
        data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Navbar brand -->
        <a class="navbar-brand mt-2 mt-lg-0" href="#">
            <img src="../../recursos/FURNICOM.png" height="60" alt="Furnicom logo" loading="lazy" />
        </a>
        <!-- Left links -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="../../views/public/index.html">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../views/public/products.html">Muebles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../views/public/about_us.html">Sobre nosotros</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="../../views/public/mis_pedidos.html">Mis pedidos</a>
        </li>
        </ul>
        <!-- Left links -->
    </div>
    <!-- Collapsible wrapper -->

    <!-- Right elements -->
    <div class="d-flex align-items-center">
        <!-- Icon -->
        <a class="text-reset me-3" href="../../views/public/carrito_compras.html">
        <i class="fas fa-shopping-cart"></i>
      </a>
        <!-- Avatar -->
        <div class="dropdown">
            <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown"
                aria-expanded="false">
                <img src="../../recursos/iconos/user.png" class="rounded-circle" height="25"
                    alt="Black and White Portrait of a Man" loading="lazy" />
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                <li>
                    <a class="dropdown-item" href="#"><b>${JSON.username}</b></a>
                </li>
                <li>
                    <a class="dropdown-item" onclick="logOut()">Salir</a>
                </li>

            </ul>
        </div>
    </div>
    <!-- Right elements -->
</div>
<!-- Container wrapper -->

</nav>
</div>
        `;
    } else {
        HEADER.innerHTML = `
        <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
    
                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navbar brand -->
                    <a class="navbar-brand mt-2 mt-lg-0" href="#">
                        <img src="../../recursos/FURNICOM.png" height="60" alt="Furnicom logo" loading="lazy" />
                    </a>
                    <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="../public/index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="navbarDropdownMenuLink" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">Muebles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../public/about_us.html">Sobre nosotros</a>
                        </li>
                    </ul>
                    <!-- Left links -->
                </div>
                <!-- Collapsible wrapper -->
    
                <!-- Right elements -->
                <div class="d-flex align-items-center">
                    <!-- Icon -->
    
                    <!-- Avatar -->
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                            id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown"
                            aria-expanded="false">
                            <img src="../../recursos/iconos/user.png" class="rounded-circle"
                                height="25" alt="Black and White Portrait of a Man" loading="lazy" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                            <li>
                                <a class="dropdown-item" href="login.html">Iniciar sesión</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="sign_up.html">Registrarte</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    
        `;}
    // Se establece el pie del encabezado.
    FOOTER.innerHTML = `
        <div class="container">
            <div class="row">
                <div class="col s12 m6 l6">
                    <h5 class="white-text">Nosotros</h5>
                    <p>
                        <blockquote>
                            <a href="#" class="white-text"><b>Misión</b></a>
                            <span>|</span>
                            <a href="#" class="white-text"><b>Visión</b></a>
                            <span>|</span>
                            <a href="#" class="white-text"><b>Valores</b></a>
                        </blockquote>
                        <blockquote>
                            <a href="#" class="white-text"><b>Términos y condiciones</b></a>
                        </blockquote>
                    </p>
                </div>
                <div class="col s12 m6 l6">
                    <h5 class="white-text">Contáctanos</h5>
                    <p>
                        <blockquote>
                            <a href="https://www.facebook.com/" class="white-text" target="_blank"><b>facebook</b></a>
                            <span>|</span>
                            <a href="https://www.instagram.com/" class="white-text" target="_blank"><b>instagram</b></a>
                            <span>|</span>
                            <a href="https://www.youtube.com/" class="white-text" target="_blank"><b>youtube</b></a>
                        </blockquote>
                        <blockquote>
                            <a href="mailto:dacasoft@outlook.com" class="white-text"><b>Correo electrónico</b></a>
                            <span>|</span>
                            <a href="https://api.whatsapp.com/" class="white-text" target="_blank"><b>WhatsApp</b></a>
                        </blockquote>
                    </p>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <span>© 2018-2023 Copyright CoffeeShop. Todos los derechos reservados.</span>
            </div>
        </div>
    `;
    // Se inicializa el componente Sidenav para que funcione la navegación lateral.
    // Se declara e inicializa un arreglo con los nombres de las imagenes que se pueden utilizar en el efecto parallax.
    const IMAGES = ['img01.jpg', 'img02.jpg', 'img03.jpg', 'img04.jpg', 'img05.jpg'];
    // Se declara e inicializa una constante para obtener un elemento del arreglo de forma aleatoria.
    const ELEMENT = Math.floor(Math.random() * IMAGES.length);
    // Se asigna la imagen a la etiqueta img por medio del atributo src.
    // Se inicializa el efecto Parallax.
});