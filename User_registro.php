<?php

include 'components/Conectar.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conexion->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = '¡El email ya existe!';
   }else{
      if($pass != $cpass){
         $message[] = '¡La confirmación de contraseña no coincide!';
      }else{
         $insert_user = $conexion->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $message[] = '¡Registrado con éxito, inicie sesión ahora por favor!';
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
   <title>Registrarse</title>
   
   <!--== Kit de herramienta SVG, fuente y css, página: cdnj.com ==-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <!--== LLAMAR AL ESTILO DE LA PÁGINA ==-->
   <link rel="icon" href="logo/LOGO_FSTYLEZ.ico">

</head>
<body>
   
<?php include 'components/User_Encabezado.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Regístrate ahora</h3>
      <input type="text" name="name" required placeholder="Ingrese su nombre de usuario" maxlength="20"  class="box">
      <input type="email" name="email" required placeholder="Ingrese su email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Ingrese su contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Confirme su contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Regístrate Ahora" class="btn" name="submit">
      <p>¿Ya tienes una cuenta?</p>
      <a href="User_sesion.php" class="option-btn">Iniciar Sesión Ahora</a>
   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>