<?php

include '../components/Conectar.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:Inicio_Sesion_Admin.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admins = $conexion->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   header('location:Cuentas_Admin.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cuentas de Administrador Fstylez</title>
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

   <h1 class="heading">Cuentas de Administrador - Fstylez</h1>

   <div class="box-container">

   <div class="box">
      <p>Agregar Nuevo Admin</p>
      <a href="Registrar_Admin.php" class="option-btn">Registrar Admin</a>
   </div>

   <?php
      $select_accounts = $conexion->prepare("SELECT * FROM `admins`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> ID Admin : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Nombre Administrador : <span><?= $fetch_accounts['name']; ?></span> </p>
      <div class="flex-btn">
         <a href="Cuentas_Admin.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('¿Estás seguro que deseas eliminar esta cuenta?')" class="delete-btn">Eliminar</a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="Actualizar_Perfil.php" class="option-btn">Actualizar</a>';
            }
         ?>
      </div>
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