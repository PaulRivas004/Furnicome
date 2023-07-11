// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/dashboard/producto.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Se define una constante tipo objeto con la fecha y hora actual.
    const TODAY = new Date();
    // Se define una variable con el número de horas transcurridas en el día.
    let hour = TODAY.getHours();
    // Se define una variable para guardar un saludo.
    let greeting = '';
    // Dependiendo del número de horas transcurridas en el día, se asigna un saludo para el usuario.
    if (hour < 12) {
        greeting = 'Buenos días';
    } else if (hour < 19) {
        greeting = 'Buenas tardes';
    } else if (hour <= 23) {
        greeting = 'Buenas noches';
    }
    // Se muestra un saludo en la página web.
    document.getElementById('greeting').textContent = greeting;
    // Se llaman a la funciones que generan los gráficos en la página web.
    graficoBarrasSubCategorias();
    graficoLinealCategorias();
});

/*
*   Función asíncrona para mostrar en un gráfico de barras la cantidad de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoBarrasSubCategorias() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'cantidadProductosSubCategoria');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let subcategorias = [];
        let existencia_producto = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            subcategorias.push(row.nombre_sub);
            existencia_producto.push(row.existencia_producto);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', subcategorias, existencia_producto, 'Cantidad de productos', 'Cantidad de productos por categoría');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.exception);
    }
}

/*
*   Función asíncrona para mostrar en un gráfico de pastel el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoLinealCategorias() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'cantidadProductosexistencia');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let nombre = [];
        let existencia_producto2 = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            nombre.push(row.nombre_producto);
            existencia_producto2.push(row.existencia_producto);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        LineGraph('chart2', nombre, existencia_producto2, 'Estado del producto', 'Top 5 de productos con más existencia');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.exception);
    }
}