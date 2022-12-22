<?php
if(isset($_POST['enviar'])){
    $conexion = conect_mysqli();
    $opcion = mysqli_real_escape_string($conexion, (string) $_POST['opcion']);
    ?>
    <div class="contenedor">
    <?php
    if($opcion == "GLA"){
    ?>
        <p>Se ha generado la siguiente llave segura: <?php echo generar_llave_alteratorio(16); ?></p>
    <?php
    }elseif($opcion == "CUW"){
        ?>
        <form action="" method="post">
            <div class="grid_2_auto">

                <div class="mb-3 contenedor">
                  <label for="user" class="form-label">Usuario</label>
                  <input type="text"
                    class="form-control" name="user" id="user" aria-describedby="user" placeholder="Pon el usuario">
                  <small id="user" class="form-text text-muted">Aquí pon el usuario.</small>
                </div>

                <div class="mb-3 contenedor">
                  <label for="email" class="form-label">Correo</label>
                  <input type="email"
                    class="form-control" name="email" id="email" aria-describedby="email" placeholder="Pon el correo">
                  <small id="email" class="form-text text-muted">Aquí pon el correo del usuario.</small>
                </div>

            </div>
            <div class="flex_center">
                <button type="submit" name="newuser" class="btn btn-success">Agregar</button>
            </div>
        </form>
        <?php
    }elseif($opcion == "DP"){
        ?>
        <form action="" method="post">
            <div class="flex_center">
                <div class="mb-3">
                  <label for="password" class="form-label">Contraseña </label>
                  <input type="password"
                    class="form-control" name="password" id="password" aria-describedby="password" placeholder="Pon la contraseña de bloqueo">
                  <small id="password" class="form-text text-muted">Necesitas la contraseña para eliminar el sistema diden´t pay.</small>
                </div>
            </div>
            <div class="flex_center">
                <button type="submit" name="deletepay" class="btn btn-success">Eliminar</button>
            </div>
        </form>
        <?php
    }elseif($opcion == "ECW"){
      ?>
      <form action="" method="post">
        <div class="flex_center">
          <div class="mb-3">
            <label for="email" class="form-label">Correo a enviar</label>
            <input type="email"
              class="form-control" name="email" id="email" aria-describedby="email" placeholder="Pon el correo donde se enviará la prueba">
            <small id="email" class="form-text text-muted">Ingresa el correo donde se reibirá la prueba de envío.</small>
          </div>
        </div>
        <div class="flex_center">
          <button type="submit" name="prueba_correo_wordpress" class="btn btn-success">Enviar</button>
        </div>
      </form>
      <?php
    }elseif($opcion == "ECJ"){
      ?>
      <form action="" method="post">
        <div class="flex_center">
          <div class="mb-3">
            <label for="email" class="form-label">Correo a enviar</label>
            <input type="email"
              class="form-control" name="email" id="email" aria-describedby="email" placeholder="Pon el correo donde se enviará la prueba">
            <small id="email" class="form-text text-muted">Ingresa el correo donde se reibirá la prueba de envío.</small>
          </div>
        </div>
        <div class="flex_center">
          <button type="submit" name="prueba_correo_jossecurity" class="btn btn-success">Enviar</button>
        </div>
      </form>
      <?php
    }elseif($opcion == "CSMTP"){
      if(!file_exists(__DIR__ . DIRECTORY_SEPARATOR . "../smtp/wp-mail.php")){
        $wp_mail_create = fopen(__DIR__ . DIRECTORY_SEPARATOR . '../smtp/wp-mail.php', 'w');
        fwrite($wp_mail_create, "<?php\n".'function wp_mail( $to, $subject, $message, $headers = "", $attachments = [] ){'."\n".'
          return mail_WP( $to, $subject, $message, $headers, $attachments );'."\n".
      '}'."\n?>");
        fclose($wp_mail_create);
        ?>
        <script>
        Swal.fire(
        'Completado',
        'Se ha creado correctamente el sistema SMTP dentro de WordPress.',
        'success'
        ),
        window.location.reload()
    </script>
        <?php
      }
    }elseif($opcion == "DSMTP"){
      if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "../smtp/wp-mail.php")){
        unlink(__DIR__ . DIRECTORY_SEPARATOR . "../smtp/wp-mail.php");
        ?>
        <script>
        Swal.fire(
        'Completado',
        'Se ha desactivado correctamente el sistema SMTP dentro de WordPress.',
        'success'
        ),
        window.location.reload()
    </script>
        <?php
      }
    }
    ?>
    </div>
    <?php
}
?>