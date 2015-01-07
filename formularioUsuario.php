<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//ES">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<link href="css/estiloSistema.css" rel="stylesheet" type="text/css">
    <head>
         <title>Nuevo Usuario</title>
    </head>
    <body>
    <div class="usuario">
    <h1>Nuevo Usuario</h1>
        <form class="formUsuario" method="post" action="php/nuevoUsuario.php">
            <label class="labelUsuario">Nombre: </label>
            <input type="text" class="cajaUsuario" name="nombre"><br>
            <label class="labelUsuario">Apellido: </label>
            <input type="text" class="cajaUsuario" name="apellido"><br>
            <label class="labelUsuario">Nacimineto: </label>
            <input type="text" class="cajaUsuario" name="fechaNacimiento"><br>
            <label class="labelUsuario">Correo: </label>
            <input type="text" class="cajaUsuario" name="correo"><br>
            <label class="labelUsuario">Usuario: </label>
            <input type="text" class="cajaUsuario" name="nombreUsuario"><br>
            <label class="labelUsuario">Contrase&ntilde;a: </label>
            <input type="text" class="cajaUsuario" name="clave"><br>
            <label class="labelUsuario">Nivel: </label>
            <select id="nivel" class="cajaUsuario" name="nivel" size=1> 
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <input type="submit" class="botonUsuario" name="Guardar">
        </form>    
        <!--usuario--></div>
    </body>
</html>
