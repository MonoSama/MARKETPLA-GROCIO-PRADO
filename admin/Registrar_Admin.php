<?php

include '../components/Conectar.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:Inicio_Sesion_Admin.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conexion->prepare("SELECT * FROM `admins` WHERE name = ?");
   $select_admin->execute([$name]);

   if($select_admin->rowCount() > 0){
      $message[] = '¡El nombre de usuario ya existe!';
   }else{
      if($pass != $cpass){
         $message[] = '¡La confirmación de contraseña no coincide!';
      }else{
         $insert_admin = $conexion->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = '¡Nuevo administrador registrado con éxito!';
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
   <title>Registrar Aministrador</title>

   <!--== Kit de herramienta SVG, fuente y css, página: cdnj.com ==-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!--== ICONO DE LA PÁGINA ==-->
   <link rel="stylesheet" href="../css/admin_style.css">

   <!--== ICONO DE LA PÁGINA ==-->
   <link rel="icon" href="LOGO_FSTYLEZ.ico">

</head>
<body>

<?php include '../components/Admin_Encabezado.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Regístrate Ahora</h3>
      <input type="text" name="name" required placeholder="Ingrese tu nombre de usuario" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Ingresa tu contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Confirma tu contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Regístrate Ahora" class="btn" name="submit">
   </form>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>