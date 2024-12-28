<?php

include '../components/Conectar.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:Inicio_Sesion_Admin.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conexion->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conexion->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conexion->prepare("DELETE FROM `messages` WHERE user_id = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conexion->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conexion->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:Cuentas_Usuario.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cuentas de Usuarios</title>

   <!--== Kit de herramienta SVG, fuente y css, página: cdnj.com ==-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!--== ICONO DE LA PÁGINA ==-->
   <link rel="stylesheet" href="../css/admin_style.css">

   <!--== ICONO DE LA PÁGINA ==-->
   <link rel="icon" href="LOGO_FSTYLEZ.ico">

</head>
<body>

<?php include '../components/Admin_Encabezado.php'; ?>

<section class="accounts">

   <h1 class="heading">Cuentas de Usuarios</h1>

   <div class="box-container">

   <?php
      $select_accounts = $conexion->prepare("SELECT * FROM `users`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> ID de Usuario: <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Nombre de Usuario : <span><?= $fetch_accounts['name']; ?></span> </p>
      <p> Email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <a href="Cuentas_Usuario.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('¿Desea eliminar esta cuenta? ¡La información relacionada con el usuario también se eliminará!')" class="delete-btn">Eliminar</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">¡No hay cuentas disponibles!</p>';
      }
   ?>

   </div>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>