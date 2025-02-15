<?php

include '../components/Conectar.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:Inicio_Sesion_Admin.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conexion->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:Mensajes.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mensajes</title>

   <!--== Kit de herramienta SVG, fuente y css, página: cdnj.com ==-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!--== ICONO DE LA PÁGINA ==-->
   <link rel="stylesheet" href="../css/admin_style.css">

   <!--== ICONO DE LA PÁGINA ==-->
   <link rel="icon" href="LOGO_FSTYLEZ.ico">

</head>
<body>

<?php include '../components/Admin_Encabezado.php'; ?>

<section class="contacts">

<h1 class="heading">Mensajes</h1>

<div class="box-container">

   <?php
      $select_messages = $conexion->prepare("SELECT * FROM `messages`");
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
   <p> ID de Usuario : <span><?= $fetch_message['user_id']; ?></span></p>
   <p> Nombre : <span><?= $fetch_message['name']; ?></span></p>
   <p> Email : <span><?= $fetch_message['email']; ?></span></p>
   <p> Número de Celular : <span><?= $fetch_message['number']; ?></span></p>
   <p> Mensaje : <span><?= $fetch_message['message']; ?></span></p>
   <a href="Mensajes.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('¿Eliminar este mensaje?');" class="delete-btn">Eliminar</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No tienes mensajes</p>';
      }
   ?>

</div>

</section>










<script src="../js/admin_script.js"></script>
   
</body>
</html>