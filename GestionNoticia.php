<?php
//    session_start();
//    if(empty($_SESSION['usuario'])) {
//        include_once './acceso.html';
//    }else{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//ES">
<html>
    <head>
        <title>Gestión de Noticias - Katupyry Desarrollos SRL</title>
        <meta charset="UTF-8">
        <script type='text/javascript' src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/modulos/global.js"></script>
        <link href="css/estilo.css" rel="stylesheet" type="text/css">
        <link href="css/estiloSistema.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            //////////////////// DECLARACIÓN DE VARIABLES /////////////////////
            var url = "php/servicios/Noticia.php";
            var tabla = '';
            var arreglo = new Array();
            var cantidad;
            ////////////////////////// LOAD DE TABLA /////////////////////////
            $(function() {
                $(document).on("ready", function() {
                    $.ajax({
                        type: 'POST',
                        data: 'accion=traerNoticias',
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

                ///////////////////////// NUEVO NOTICIA /////////////////////////    
                $("#btnNuevaNoticia").click(function() {
                    try {
                        var formData = new FormData($("#frmNuevaNoticia")[0]);
                        var nombre = "";
                        var contenido = "";
                        nombre = document.getElementById("nombre").value;
                        contenido = document.getElementById("contenido").value;
                        var imagen = document.getElementById("imagen").value;
                        if(nombre.length < 1 || contenido.length < 1 || imagen === ""){
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
                                mostrarOcultar('tablaNoticia', 'formularioNoticia');
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

                /////////////////////////// BUSCAR NOTICIA /////////////////////////////////
                $("#btnBuscarNoticia").click(function() {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: $("#frmBuscarNoticia").serialize(),
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
                        data: 'accion=traerNoticias',
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
        
            //////////////////////// EDITAR NOTICIA //////////////////////////
            function editarNoticia(codigo) {
                $("#nombre").val(arreglo[codigo]['nombre']);
                $("#contenido").append(arreglo[codigo]['cuerpo']);
                $("#codigo").val(arreglo[codigo]['codigo']);
                $("#imagen").val('');
                mostrarOcultar('formularioNoticia', 'tablaNoticia');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $("#frmNuevaNoticia").serialize(),
                    success: function(data) {
                        arreglo = data;
                        cantidad = arreglo.length;
                        cargarTabla();
                        tabla = '';
                    }
                });
                return false;
            }
            /////////////////////// ELIMINAR NOTICIA //////////////////////////
            function eliminarNoticia(codigo) {
                if (confirm("Esta seguro que desea continuar?")) {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: 'accion=eliminarNoticia&codigo=' + codigo,
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
                    descripcionCompleta = arreglo[i]['cuerpo'];
                    descripcion = descripcionCompleta.substring(0,30)+'...';
                    tabla += '<tr class="remove">' +
                            '<td><p>' + arreglo[i]['nombre'] + '</p></td>' +
                            '<td><p>' + arreglo[i]['fecha'] + '</p></td>' +
                            '<td><p>' + arreglo[i]['usuario'] + '</p></td>' +
                            '<td><p>' + descripcion + '</p></td>' +
                            '<td><p><button onclick="editarNoticia(\'' + i + '\')" class="botonTEditar"></button> ' +
                            ' <button onclick="eliminarNoticia(\'' + arreglo[i]['codigo'] + '\')" class="botonTEliminar"></button></td>' +
                            '</tr>';
                }
                ;
                $("#bodyTabla").append(tabla);
            }
            
            ////////////// LIMPIA CAJA DE TEXTO ////////////////////////
            function limpiarText() {
                $("#nombre").val('');
                $("#contenido").val('');
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
	                <h1>GESTIÓN DE NOTICIA</h1>
                </div>
                <div class="botonDerecha">
                    <input type="button" class="btnNuevo" value="Nueva Noticia" onclick="mostrarOcultar('formularioNoticia', 'tablaNoticia'), limpiarText()">
                </div>
            </div>

            <div class="formulario" id="formularioNoticia" style="display:none">
                <form method="POST" id="frmNuevaNoticia" enctype="multipart/form-data">
                    <label for="nombre" class="lbl">Nombre:</label><br>
                    <input type="text" name="nombre" id="nombre" class="cajaEstandar1"><br>
                    <label for="contenido" class="lbl">Contenido:</label><br><br>
                    <textarea name="contenido" id="contenido" cols="72" rows="18"></textarea><br>
                    <input type="hidden" name="accion" id="accion" value="nuevaNoticia">
                    <input type="hidden" name="codigo" id="codigo" value="">
                    <!--SELECCIONAR IMAGEN-->
                    <input type="file" name="imagen" id="imagen"><br>
                    <input type="button" name="btnNuevaNoticia" id="btnNuevaNoticia" class="boton" value="Guardar">
                    <input type="reset" name="reset" id="reset" class="boton" value="Borrar">
                    <input type="button" value="Regresar" id="regresar" onclick="mostrarOcultar('tablaNoticia', 'formularioNoticia')" class="boton">
                    <div class="validacion" id="validacion"></div>
                </form>
            </div>

            <div class="tablaNoticia" id="tablaNoticia">
                <form method="POST" id="frmBuscarNoticia" >
                    <label for="buscar">Buscar:</label>
                    <input type="text" name="buscar" id="buscar" class="cajaEstandar">
                    <input type="hidden" name="accion" id="accion" value="buscarNoticia">
                    <input type="button" name="btnBuscarNoticia" id="btnBuscarNoticia" class="boton" value="Buscar">
                    <input type="button" name="btnRestaurar" id="btnRestaurar" class="boton" value="Restaurar">
                </form>
                <table class="tbl" id="tblNoticias">
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
