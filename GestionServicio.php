<?php
//    session_start();
//    if(empty($_SESSION['usuario'])) {
//        include_once './acceso.html';
//    }else{ 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//ES">
<html>
    <head>
        <title>Gestión de Servicios - Katupyry Desarrollos SRL</title>
        <meta charset="UTF-8">
        <script type='text/javascript' src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/modulos/global.js"></script>
        <link href="css/estilo.css" rel="stylesheet" type="text/css">
        <link href="css/estiloSistema.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            //////////////////// DECLARACIÓN DE VARIABLES /////////////////////
            var url = "php/servicios/Servicio.php";
            var tabla = '';
            var arreglo = new Array();
            var cantidad;
            ////////////////////////// LOAD DE TABLA /////////////////////////
            $(function() {
                $(document).on("ready", function() {
                    $.ajax({
                        type: 'POST',
                        data: 'accion=traerServicios',
                        url: url,
                        dataType: 'json',
                        success: function(data) {
                            arreglo = data;
                            cantidad = arreglo.length;
                            cargarTabla();
                            tabla = '';
                        },
                        error: function(jqXHR, textStatus, error) {
                            alert(jqXHR.responseText);
                        }
                    });
                    return false;
                });

                ///////////////////////// NUEVO SERVICIO /////////////////////////    
                $("#btnNuevoServicio").click(function() {
                    try {  
                        var formData = new FormData($("#frmNuevoServicio")[0]);
                        var message = "";
                        var nombre = "";
                        var descripcion = "";
                        nombre = document.getElementById("nombre").value;
                        descripcion = document.getElementById("descripcion").value;
                        var imagen = document.getElementById("imagen").value;
                        if(nombre.length < 1 || descripcion.length < 1 || imagen === ""){
                            throw new Error('Todos los campos son obligatorios');
                        }
                        //hacemos la petición ajax  
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: formData,
                            //necesario para subir archivos via ajax
                            cache: false,
                            contentType: false,
                            processData: false,
                            //mientras enviamos el archivo

                            success: function(data) {
                                $("#errores").append(data);
                                arreglo = data;
                                cantidad = arreglo.length;
                                cargarTabla();
                                tabla = '';
                                mostrarOcultar('tablaServicios', 'formularioServicio');
                            },
                            error: function(jqXHR, textStatus, error) {
                                $("#errores").append(jqXHR.responseText);
                            }
                        });
                        return false;
                    } catch(excepcion) {
                        alert(excepcion);
                    }
                });

                /////////////////////////// BUSCAR SERVICIOS /////////////////////////////////
                $("#btnBuscarServicio").click(function() {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: $("#frmBuscarServicio").serialize(),
                        success: function(data) {
                            arreglo = data;
                            cantidad = arreglo.length;
                            cargarTabla();
                            tabla = '';
                        }
                    });
                    return false;

                });
                //////////////////// RESTAURAR LISTA /////////////////////////
                $("#btnRestaurar").click(function() {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: 'accion=traerServicios',
                        success: function(data) {
                            arreglo = data;
                            cantidad = arreglo.length;
                            cargarTabla();
                            tabla = '';
                        }
                    });
                    return false;
                });
            });
        
            //////////////////////// EDITAR SERVICIO //////////////////////////
            function editarServicio(codigo) {
                $("#nombre").val(arreglo[codigo]['nombre']);
                $("#descripcion").append(arreglo[codigo]['descripcion']);
                $("#codigo").val(arreglo[codigo]['codigo']);
                $("#imagen").val('');
                mostrarOcultar('formularioServicio', 'tablaServicios');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $("#frmNuevoServicio").serialize(),
                    success: function(data) {
                        arreglo = data;
                        cantidad = arreglo.length;
                        cargarTabla();
                        tabla = '';
                    }
                });
                return false;
            }
            /////////////////////// ELIMINAR SERVICIO //////////////////////////
            function eliminarServicio(codigo) {
                if (confirm("Esta seguro que desea continuar?")) {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: 'accion=eliminarServicio&codigo=' + codigo,
                        success: function(data) {
                            arreglo = data;
                            cantidad = arreglo.length;
                            cargarTabla();
                            tabla = '';
                        }
                    });
                    return false;
                }
            }

            ///////////////////////// CARGAR TABLA //////////////////////////
            function cargarTabla() {
                $('.remove').remove();
                for (i = 0; i < cantidad; i++) {
                    descripcionCompleta = arreglo[i]['descripcion'];
                    descripcion = descripcionCompleta.substring(0,30)+'...';
                    tabla += '<tr class="remove">' +
                            '<td><p>' + arreglo[i]['nombre'] + '</p></td>' +
                            '<td><p>' + arreglo[i]['fecha'] + '</p></td>' +
                            '<td><p>' + arreglo[i]['usuario'] + '</p></td>' +
                            '<td><p>' + descripcion + '</p></td>' +
                            '<td><p><button onclick="editarServicio(\'' + i + '\')" class="botonTEditar"></button> ' +
                            ' <button onclick="eliminarServicio(\'' + arreglo[i]['codigo'] + '\')" class="botonTEliminar"></button></td>' +
                            '</tr>';
                }
                ;
                $("#bodyTabla").append(tabla);
            }
            
            ////////////// LIMPIA CAJA DE TEXTO ////////////////////////
            function limpiarText() {
                $("#nombre").val('');
                $("#descripcion").val('');
                $("#codigo").val('');
                $("#imagen").val('');
            }
            

        </script>



    </head>
    <body>
<?PHP include_once 'cabecera.php'; ?>
        <div class="contentGestion">
            <div class="botones" id="botones">
                <div class="titBotones">
	                <h1>GESTIÓN DE SERVICIOS</h1>
                </div>
                <div class="botonDerecha">
                    <input type="button" class="btnNuevo" value="Nuevo Servicio" onclick="mostrarOcultar('formularioServicio', 'tablaServicios'), limpiarText()">
                </div>
            </div>

            <div class="formulario" id="formularioServicio" style="display:none">
                <form method="POST" id="frmNuevoServicio" enctype="multipart/form-data">
                    <label for="nombre" class="lbl">Nombre:</label><br>
                    <input type="text" name="nombre" id="nombre" class="cajaEstandar1"><br>
                    <label for="descripcion" class="lbl">Descripción:</label><br><br>
                    <textarea name="descripcion" id="descripcion" cols="72" rows="18"></textarea><br>
                    <input type="hidden" name="accion" id="accion" value="nuevoServicio">
                    <input type="hidden" name="codigo" id="codigo" value="">
                    <!--SELECCIONAR IMAGEN-->
                    <input type="file" name="imagen" id="imagen"><br>
                    <input type="button" name="btnNuevoServicio" id="btnNuevoServicio" class="boton" value="Guardar">
                    <input type="reset" name="reset" id="reset" class="boton" value="Borrar">
                    <input type="button" value="Regresar" id="regresar" onclick="mostrarOcultar('tablaServicios', 'formularioServicio')" class="boton">
                    <div class="validacion" id="validacion"></div>
                </form>
            </div>

            <div class="tablaServicios" id="tablaServicios">
                <form method="POST" id="frmBuscarServicio" >
                    <label for="buscar">Buscar:</label>
                    <input type="text" name="buscar" id="buscar" class="cajaEstandar">
                    <input type="hidden" name="accion" id="accion" value="buscarServicios">
                    <input type="button" name="btnBuscarServicio" id="btnBuscarServicio" class="boton" value="Buscar">
                    <input type="button" name="btnRestaurar" id="btnRestaurar" class="boton" value="Restaurar">
                </form>
                <table class="tbl" id="tblServicios">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Contenido</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTabla">

                    </tbody>
                </table>
            </div><!--TABLANOTICIAS-->
        </div><!--contentGestion-->
        <div id="errores"></div>
        
    </body>
</html>
<?PHP
//    }
?>
