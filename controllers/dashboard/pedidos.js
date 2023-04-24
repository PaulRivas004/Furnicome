// Constante para completar la ruta de la API.
const PEDIDOS_API = 'business/dashboard/pedidos.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
const TBODY_ROWS2 = document.getElementById('tbody-rows2');
const RECORDS = document.getElementById('records');


// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
  // Llamada a la función para llenar la tabla con los registros disponibles.
  fillTable();
});

SAVE_FORM.addEventListener('submit', async (event) => {
  // Se evita recargar la página web después de enviar el formulario.
  event.preventDefault();
  // Se verifica la acción a realizar.
  (document.getElementById('id_pedido').value) ? action = 'update' : action = 'create';
  // Constante tipo objeto con los datos del formulario.
  const FORM = new FormData(SAVE_FORM);
  // Petición para guardar los datos del formulario.
  const JSON = await dataFetch(PEDIDOS_API, action, FORM);
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
  if (JSON.status) {
    // Se carga nuevamente la tabla para visualizar los cambios.
    fillTable();

    // Se muestra un mensaje de éxito.
    sweetAlert(1, JSON.message, true);
  } else {
    sweetAlert(2, JSON.exception, false);
  }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/

async function fillTable(form = null) {
  // Se inicializa el contenido de la tabla.
  TBODY_ROWS.innerHTML = '';
  RECORDS.textContent = '';
  // Se verifica la acción a realizar.
  action = 'readAll';
  // Petición para obtener los registros disponibles.
  const JSON = await dataFetch(PEDIDOS_API, action, form);
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
  if (JSON.status) {
    // Se recorre el conjunto de registros fila por fila.
    JSON.dataset.forEach(row => {
      // Se crean y concatenan las filas de la tabla con los datos de cada registro.
      TBODY_ROWS.innerHTML += `
                <tr>
                <td>${row.id_pedido}</td>
                <td>${row.nombre_cliente}</td>
                    <td>${row.estado_pedido}</td>
                    <td>${row.fecha_pedido}</td>
                    <td>${row.direccion_pedido}</td>
                    <td>
                    <button onclick="openUpdate(${row.id_pedido})" type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target=".exampleModal">
                    Actualizar
                    </button>
                    <button onclick="openDelete(${row.id_pedido})" type="button" class="btn btn-danger">Eliminar</button>
                    <button onclick="openDetail(${row.id_pedido})" type="button" class="btn btn-warning" data-mdb-toggle="modal" data-mdb-target="#exampleModal">Detalles</button>
                    </td>
                </tr>
            `;
    });
    RECORDS.textContent = JSON.message;
  } else {
    sweetAlert(4, JSON.exception, true);
  }
}

/*

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/

async function openUpdate(id_pedido) {
  // Se define una constante tipo objeto con los datos del registro seleccionado.
  const FORM = new FormData();
  FORM.append('id_pedido', id_pedido);
  // Petición para obtener los datos del registro solicitado.
  const JSON = await dataFetch(PEDIDOS_API, 'readOne', FORM);
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
  if (JSON.status) {
    // Se deshabilitan los campos necesarios.
    document.getElementById('nombre_cliente').disabled = true;
    document.getElementById('fecha_pedido').disabled = true;
    document.getElementById('direccion').disabled = true;
    // Se inicializan los campos del formulario.
    document.getElementById('id_pedido').value = JSON.dataset.id_pedido;
    document.getElementById('nombre_cliente').value = JSON.dataset.nombre_cliente;
    document.getElementById('fecha_pedido').value = JSON.dataset.fecha_pedido;
    document.getElementById('direccion').value = JSON.dataset.direccion_pedido;
    if (JSON.dataset.estado_pedido) {
      document.getElementById('estado').checked = true;
    } else {
      document.getElementById('estado').checked = false;
    }
  } else {
    sweetAlert(2, JSON.exception, false);
  }
}


async function openDetail(form = null) {
  // Se inicializa el contenido de la tabla.
  TBODY_ROWS2.innerHTML = '';
  // Se verifica la acción a realizar.
  action = 'readDetail';
  // Petición para obtener los registros disponibles.
  const JSON = await dataFetch(PEDIDOS_API, action, form);
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
  if (JSON.status) {
    // Se recorre el conjunto de registros fila por fila.
    JSON.dataset.forEach(row => {
      // Se crean y concatenan las filas de la tabla con los datos de cada registro.
      TBODY_ROWS2.innerHTML += `
      <tr>
      <td>${row.id_detalle}</td>
      <td>${row.id_pedido}</td>
          <td>${row.nombre_producto}</td>
          <td>${row.cantidad_producto}</td>
          <td>${row.precio_producto}</td>
      </tr>
            `;
    });
  } else {
    sweetAlert(4, JSON.exception, true);
  }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDelete(id) {
  // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
  const RESPONSE = await confirmAction('¿Desea eliminar la categoría de forma permanente?');
  // Se verifica la respuesta del mensaje.
  if (RESPONSE) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_categoria', id);
    // Petición para eliminar el registro seleccionado.
    const JSON = await dataFetch(CATEGORIA_API, 'delete', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
      // Se carga nuevamente la tabla para visualizar los cambios.
      fillTable();
      // Se muestra un mensaje de éxito.
      sweetAlert(1, JSON.message, true);
    } else {
      sweetAlert(2, JSON.exception, false);
    }
  }
}

/*
*   Función para abrir el reporte de productos de una categoría.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
function openReport(id) {
  // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
  const PATH = new URL(`${SERVER_URL}reports/dashboard/productos_categoria.php`);
  // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
  PATH.searchParams.append('id_categoria', id);
  // Se abre el reporte en una nueva pestaña del navegador web.
  window.open(PATH.href);
}

//Buscador
(function (document) {
  'buscador';

  var LightTableFilter = (function (Arr) {

    var _input;

    function _onInputEvent(e) {
      _input = e.target;
      var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
      Arr.forEach.call(tables, function (table) {
        Arr.forEach.call(table.tBodies, function (tbody) {
          Arr.forEach.call(tbody.rows, _filter);
        });
      });
    }

    function _filter(row) {
      var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
      row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
    }

    return {
      init: function () {
        var inputs = document.getElementsByClassName('light-table-filter');
        Arr.forEach.call(inputs, function (input) {
          input.oninput = _onInputEvent;
        });
      }
    };
  })(Array.prototype);

  document.addEventListener('readystatechange', function () {
    if (document.readyState === 'complete') {
      LightTableFilter.init();
    }
  });

})(document);