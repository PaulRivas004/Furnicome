function paso1(){
    document.getElementById("contenido-registro").innerHTML=` <div class="container-fluid container-registro">
        <div class="row">
            <div class="col-7 col-formularioempresa">
                <div class="row">
                    <h4 class="titulo-registrarempresa">Registra tu empresa</h4>
                    <img src="../../resources/img/Line 69.svg" alt="">
                </div>  
                <div class="row">
                    <div class="col-3 col-empresauser">
                        <img src="" alt="" class="">
                        <button type="button" class="btn btn-redondoempresa"><img src="../../resources/img/Pencil.svg"
                            alt="" class="img-lapiz"></button>
                    </div>
                    <div class="col-9 col-input1">
                        <h3 class="texto-input">Nombre de la empresa</h3>
                        <input type="text" class="form-control nombre-direccion" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                        <h3 class="texto-input">Dirección</h3>
                        <input type="text" class="form-control nombre-direccion" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>       
                <div class="row">
                    <div class="col-6">
                        <h3 class="texto-input2">Correo electrónico</h3>
                        <input type="text" class="form-control input2" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                        <h3 class="texto-input2">NIT</h3>
                        <input type="text" class="form-control input2" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                        <h3 class="texto-input2">Hora de apertura</h3>
                        <input type="text" class="form-control input2" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <a href="" class="texto-terminos">Aceptar terminos y condiciones</a>
                          </div>
                    </div>
                    <div class="col-6">
                        <h3 class="texto-input2">NRC</h3>
                        <input type="text" class="form-control input2" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                        <h3 class="texto-input2">Hora de cierre</h3>
                        <input type="text" class="form-control input2" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                        <h3 class="texto-input2">Teléfono</h3>
                        <input type="text" class="form-control input2" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                        <button type="button" class="btn btn-limpiar">Limpiar</button>
                        <button type="button" class="btn btn-guardar">Guardar</button>
                    </div>
                </div>                           
            </div>
            <div class="col-5 col-imagenregistro">
                <img src="../../resources/img/registro-empresa.svg" alt="" class="imagen-empresa">
            </div>
        </div>
    `;
    }