<?php
    //session_start();
//    if(empty($_SESSION['usuario'])) {
//        include_once './acceso.html';
//    }else{        
?>
<html>
    <head>
        <title>Gestión General - Katupyry Desarrollos SRL</title>
        <meta charset="UTF-8">
        <link href="css/estilo.css" rel="stylesheet" type="text/css">
        <link href="css/estiloSistema.css" rel="stylesheet" type="text/css">
        <script type='text/javascript' src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/modulos/global.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/additional-methods.js"></script>
        <script type="text/javascript">

            //////////////////// DECLARACIÓN DE VARIABLES /////////////////////
            var url = "php/servicios/Usuario.php";
            var tabla = '';
            var arreglo = new Array();
            var cantidad;

            ////////////////////////// LOAD DE TABLA /////////////////////////
            $(function() {
                $(document).on("ready", function() {
                    $.ajax({
                        type: 'POST',
                        data: 'accion=traerUsuarios',
                        url: url,
                        dataType: 'json',
                        success: function(data) {
                            arreglo = data;
                            cantidad = arreglo.length;
                            cargarTabla();
                            tabla = '';
                        },
                        error: function(jqXHR, textStatus, error) {
                            alert("error: " + jqXHR.responseText);
                        }
                    });
                    return false;
                });

                ///////////////////////// NUEVO USUARIO /////////////////////////    
                $("#btnNuevoUsuario").click(function() {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: $("#frmNuevoUsuario").serialize(),
                        success: function(data) {
                            arreglo = data;
                            cantidad = arreglo.length;
                            cargarTabla();
                            tabla = '';
                            mostrarOcultar('tablaUsuarios', 'formularioUsuario');
                        }
                    });
                    return false;
                });

                /////////////////////////// BUSCAR USUARIOS /////////////////////////////////
                $("#btnBuscarUsuario").click(function() {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: $("#frmBuscarUsuario").serialize(),
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
                        data: 'accion=traerUsuarios',
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

            //////////////////////// EDITAR USUARIO //////////////////////////
            function editarUsuario(codigo) {
                $("#nombre").val(arreglo[codigo]['nombre']);
                $("#apellido").val(arreglo[codigo]['apellido']);
                $("#nombreUsuario").val(arreglo[codigo]['nombreUsuario']);
                $("#clave").val("");
                $("#correo").val(arreglo[codigo]['correo']);
                $("#codigo").val(arreglo[codigo]['codigo']);
                mostrarOcultar('formularioUsuario', 'tablaUsuarios');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $("#frmNuevoUsuario").serialize(),
                    success: function(data) {
                        arreglo = data;
                        cantidad = arreglo.length;
                        cargarTabla();
                        tabla = '';
                    }
                });
                return false;
            }

            /////////////////////// ELIMINAR USUARIO //////////////////////////
            function eliminarUsuario(codigo) {
                if (confirm("Esta seguro que desea continuar?")) {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: 'accion=eliminarUsuario&codigo='+codigo,
                        success: function(data) {
                            arreglo = data;
                            cantidad = arreglo.length;
                            cargarTabla();
                            alert("entro");
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
                    tabla += '<tr class="remove">' +
                            '<td><p>' + arreglo[i]['nombre'] + '</p></td>' +
                            '<td><p>' + arreglo[i]['apellido'] + '</p></td>' +
                            '<td><p>' + arreglo[i]['nombreUsuario'] + '</p></td>' +
                            '<td><p>' + arreglo[i]['correo'] + '</p></td>' +
                            '<td><p><button onclick="editarUsuario(\'' + i + '\')" class="botonTEditar"></button> ' +
                            ' <button onclick="eliminarUsuario(\'' + arreglo[i]['codigo'] + '\')" class="botonTEliminar"></button></td>' +
                            '</tr>';
                }
                ;
                $("#bodyTabla").append(tabla);
            }

            ////////////// LIMPIA CAJA DE TEXTO ////////////////////////
            function limpiarText() {
                $("#nombre").val('');
                $("#apellido").val('');
                $("#nombreUsuario").val('');
                $("#clave").val('');
                $("#correo").val('');
                $("#nivel").val('');
                $("#codigo").val('');
            }

        </script>
    </head>

    <body>
        <?PHP include_once 'cabecera.php'; ?>
        <div class="contentGestion">
            <div class="botones" id="botones">
            <div class="titBotones">
	                <h1>GESTIÓN DE USUARIOS</h1>
                </div>
                <div class="botonDerecha">
                    <input type="button" class="btnNuevo" value="Nuevo Usuario" onclick="mostrarOcultar('formularioUsuario', 'tablaUsuarios'), limpiarText()">
                </div>
            </div>
            
            <div class="formulario" id="formularioUsuario" style="display:none">
                <form method="POST" id="frmNuevoUsuario">
                    
                    <div class="izq">
                    <label class="labelUsuario">Nombre: </label>
                    <input type="text" class="cajaUsuario" name="nombre" id="nombre">
                    <label class="labelUsuario">Usuario: </label>
                    <input type="text" class="cajaUsuario" name="nombreUsuario" id="nombreUsuario">
                    <label class="labelUsuario">Nivel: </label>
                    <select id="nivel" class="cajaUsuario" name="nivel"> 
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    
                    <!--fin izq--></div>
                    
                    <div class="der">
                        <label class="labelUsuario">Apellido: </label>
                        <input type="text" class="cajaUsuario" name="apellido" id="apellido"><br>
                        <label class="labelUsuario">Correo: </label>
                        <input type="text" class="cajaUsuario" name="correo" id="correo"><br>
                        <label class="labelUsuario">Contraseña: </label>
                        <input type="text" class="cajaUsuario" name="clave" id="clave"><br>                    
                    <!--fin der--></div>
                    <input type="hidden" name="accion" id="accion" value="nuevoUsuario">
                    <input type="hidden" name="codigo" id="codigo" value="">
                    
                    <div class="botonesUs">
                    <input type="button" name="btnNuevoUsuario" id="btnNuevoUsuario" class="boton" value="Guardar">
                    <input type="reset" name="reset" id="reset" class="boton" value="Borrar">
                    <input type="button" value="Regresar" onclick="mostrarOcultar('tablaUsuarios', 'formularioUsuario')" class="boton" id="regresar">
                    </div>
                </form>
            </div>

            <div class="tablaUsuarios" id="tablaUsuarios">
                <form method="POST" id="frmBuscarUsuario">
                    <label for="buscar">Buscar:</label>
                    <input type="text" name="buscar" id="buscar" class="cajaEstandar">
                    <input type="hidden" name="accion" id="accion" value="buscarUsuarios">
                    <input type="button" name="btnBuscarUsuario" id="btnBuscarUsuario" class="boton" value="Buscar">
                    <input type="button" name="btnRestaurar" id="btnRestaurar" class="boton" value="Restaurar">
                </form>
                <table class="tbl" id="tblUsuarios">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTabla">
                    <tr class="remove">
                    </tbody>
                </table>
            </div>
        </div><!--contentGestion-->
</body>
</html>
<?PHP
//    }
?>
