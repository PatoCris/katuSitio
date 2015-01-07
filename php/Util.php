<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Util
 *
 * @author cristian
 */
class Util {
    //////////////////FUNCIÓN ENVIAR CORREO////////////////////
    public static function correoContacto($nombre, $mensaje, $telefono, $correo){
        $para = "katupyrydesarrollos@gmail.com";
        $titulo = 'Contacto desde la web de Katupyry Desarrollos';
        $mensaje = $mensaje. "\r\n" .
                   'Nombre: '.$nombre. "\r\n" .
                   'Teléfono: '.$telefono. "\r\n" .
                   'Correo: '.$correo. "\r\n";
        
        $cabeceras = 'From: '. $correo . "\r\n" . //La direccion de correo desde donde supuestamente se envió
        'Reply-To: ' . $correo . "\r\n" . //La direccion de correo a donde se responderá (cuando el recepto haga click en RESPONDER)
        'X-Mailer: PHP/' . phpversion();  //información sobre el sistema de envio de correos, en este caso la version de PHP

        mail($para, $titulo, $mensaje, $cabeceras);
    }
}
