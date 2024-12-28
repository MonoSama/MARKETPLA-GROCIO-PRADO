<?php

include 'components/Conectar.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conexion->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $message[] = '¡Nombre de usuario o contraseña incorrecta!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User_sesion</title>
   
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
      <h3>Iniciar Sesión Ahora</h3>
      <input type="email" name="email" required placeholder="Introduce su correo electronico" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Introduce su contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Iniciar Sesión Ahora" required placeholder="Iniciar Sesión" class="btn" name="submit">
      <p>¿No tienes una cuenta?</p>
      <a href="User_registro.php" class="option-btn">Regístrate ahora</a>
   </form>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>