<?php

/*Llamar al php conectar, y funcionan todas las variables*/
include '../components/Conectar.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:Inicio_Sesion_Admin.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   /* "FILTER_SANITIZE_STRING" Elimina etiquestas, opcionalmente o codifica caractetes especiales */
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   /* "Prepare" para sentencias que serán ejecutadas en múltiples ocaciones con diferentes parámetros Opti. rendimiento. */
   $update_profile_name = $conexion->prepare("UPDATE `admins` SET name = ? WHERE id = ?");

   /* "Execute" para vincular variables o valores respectivamente a los parametros. */
   $update_profile_name->execute([$name, $admin_id]);

   /* "sha1" algoritmo de contraseñas incriptadas, "filter_var" valores escaleres son convertidos a cuerda internamente antes que se filtren */
   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if($old_pass == $empty_pass){
      $message[] = '¡Por favor ingrese la contraseña anterior!';
   }elseif($old_pass != $prev_pass){
      $message[] = '¡La contraseña anterior no coincide!';
   }elseif($new_pass != $confirm_pass){
      $message[] = '¡La confirmación de contraseña no coincide!';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = $conexion->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$confirm_pass, $admin_id]);
         $message[] = '¡Contraseña actualizada exitosamente!';
      }else{
         $message[] = '¡Por favor ingrese una nueva contraseña!';
      }
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Actualizar Perfil</title>

   <!--== Kit de herramienta SVG, fuente y css, página: cdnj.com ==-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!--== LLAMAR AL ESTILO DE LA PÁGINA ==-->
   <link rel="stylesheet" href="../css/admin_style.css">

   <!--== ICONO DE LA PÁGINA ==-->
   <link rel="icon" href="LOGO_FSTYLEZ.ico">
   

</head>
<body>

<?php include '../components/Admin_Encabezado.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Actualizar Perfil</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
      <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" required placeholder="Ingrese su Nombre de Usuario" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="old_pass" placeholder="Ingrese su Anterior Contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Ingrese su Nueva Contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="Confirmar Nueva Contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Actualizar Ahora" class="btn" name="submit">
   </form>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>