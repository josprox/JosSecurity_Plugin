<?php

if(isset($_POST['newuser'])){
    global $fecha, $nombre_app;
    if($_ENV['DOMINIO'] != "localhost"){
        $ssl = "https://";
    }else{
        $ssl = "http://";
    }
    $direccion = $ssl . $_ENV['DOMINIO'] . $_ENV['HOMEDIR'];
    $conexion = conect_mysqli();
    $user = mysqli_real_escape_string($conexion, (string) $_POST['user']);
    $email = mysqli_real_escape_string($conexion, (string) $_POST['email']);
    $generar_contra = generar_llave_alteratorio(18);
    $password_encriptada = password_hash($generar_contra,PASSWORD_BCRYPT,["cost"=>10]);
    $conexion -> close();
    $resultado = insertar_datos_clasic_mysqli("wp_users","user_login ,user_pass , user_nicename, user_email, user_url, user_registered, display_name","'$user','$password_encriptada','$user','$email','$direccion', '$fecha', '$user'");
    if($resultado == TRUE){
        $contenido = "<div><p>Hola, muchas gracias por registrarte en $nombre_app, a continuación le mandamos su contraseña para acceder.</p><p>Contraseña: $generar_contra</p></div>";
        $correo = mail_smtp_v1_3("Hola ". $user, "Su registro ha sido exitoso ". $user, $contenido, $email);
        if($contenido == TRUE){
            ?>
            <script>
                Swal.fire(
                'Listo',
                'El registro ha sido exitoso.',
                'success'
                )
            </script>
            <?php
        }
    }
}elseif(isset($_POST['deletepay'])){
    $conexion = conect_mysqli();
    $password = mysqli_real_escape_string($conexion, (string) $_POST['password']);
    $consulta = consulta_mysqli_clasic("*","not_pay");
    $conexion -> close();
    if(password_verify((string) $password, $consulta['token']) == TRUE){
        echo eliminar_datos_con_where("not_pay","id",$consulta['id']);
    }
}elseif(isset($_POST['prueba_correo_wordpress'])){
    $conexion = conect_mysqli();
    $email = mysqli_real_escape_string($conexion, (string) $_POST['email']);
    $nombre_pagina = get_bloginfo( 'name' );
    $conexion -> close();
    wp_mail($email,"correo electrónico de prueba","Has recibido este mensaje debido a que acabas de hacer una prueba de testing. El sistema de JosSecurity se encuentra funcionando correctamente y funciona la conexión entre $nombre_pagina y el sistema.");
    ?>
    <script>
        Swal.fire(
        'Completado',
        'Se ha enviado el correo de manera correcta.',
        'success'
        )
    </script>
    <?php
}elseif(isset($_POST['prueba_correo_jossecurity'])){
    $conexion = conect_mysqli();
    $email = mysqli_real_escape_string($conexion, (string) $_POST['email']);
    $conexion -> close();
    if(mail_smtp_v1_3_check($email) == TRUE){
    ?>
    <script>
        Swal.fire(
        'Completado',
        'Se ha enviado el correo de manera correcta.',
        'success'
        )
    </script>
    <?php
    }
}

?>