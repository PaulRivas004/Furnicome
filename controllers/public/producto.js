// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/public/producto.php';
// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
// Constantes para establecer el contenido principal de la página web.
const TITULO = document.getElementById('title');
const PRODUCTOS = document.getElementById('productos');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('id_subcategoria', PARAMS.get('id_producto'));
    // Petición para solicitar los productos de la categoría seleccionada.
    const JSON = await dataFetch(PRODUCTO_API, 'readProductosSubCategoria', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de productos.
        PRODUCTOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            PRODUCTOS.innerHTML += `
                        <div class="card" style="width: 18rem;">
                        <img src="${SERVER_URL}images/productos/${row.imagen_producto}" class="materialboxed">
                        
                    <hr>
                        <div class="card-body">
                        <span class="card-title">${row.nombre_producto}</span>
                        <p>Precio(US$) ${row.precio_producto}</p>
                        <div class="text-center">
                        <a href="index.html?id=${row.id_producto}"><button type="button" class="btn  btn-rounded text-center">Ver producto</button></a>
                        </div>
                        </button>
                      </div>

            `;

            
        });
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        TITULO.textContent = JSON.exception;
    }
});