<?php

include '../components/Conectar.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:Inicio_Sesion_Admin.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Configuración General - Fstylez</title>

   <!--== Kit de herramienta SVG, fuente y css, página: cdnj.com ==-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!--== ICONO DE LA PÁGINA ==-->
   <link rel="stylesheet" href="../css/admin_style.css">

   <!--== ICONO DE LA PÁGINA ==-->
   <link rel="icon" href="LOGO_FSTYLEZ.ico">
</head>
<body>

<?php include '../components/Admin_Encabezado.php'; ?>

<section class="dashboard">

   <h1 class="heading">Configuración General</h1>

   <div class="box-container">

      <div class="box">
         <h3>¡Bienvenido!</h3>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="Actualizar_Perfil.php" class="btn">Actualizar Perfil</a>
      </div>

      <div class="box">
         <?php
            $total_pendings = 0;
            $select_pendings = $conexion->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_pendings->execute(['pending']);
            if($select_pendings->rowCount() > 0){
               while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                  $total_pendings += $fetch_pendings['total_price'];
               }
            }
         ?>
         <h3><span>S/</span><?= $total_pendings; ?><span> -</span></h3>
         <p>Total de Pedidos </p>
         <a href="Pedidos_Realizados.php" class="btn">Ver Pedidos</a>
      </div>

      <div class="box">
         <?php
            $total_completes = 0;
            $select_completes = $conexion->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_completes->execute(['completed']);
            if($select_completes->rowCount() > 0){
               while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                  $total_completes += $fetch_completes['total_price'];
               }
            }
         ?>
         <h3><span>S/</span><?= $total_completes; ?><span> -</span></h3>
         <p>Pedidos Completados</p>
         <a href="Pedidos_Realizados.php" class="btn">Ver Pedidos</a>
      </div>

      <div class="box">
         <?php
            $select_orders = $conexion->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount()
         ?>
         <h3><?= $number_of_orders; ?></h3>
         <p>Pedidos Realizados</p>
         <a href="Pedidos_Realizados.php" class="btn">Ver Pedidos</a>
      </div>

      <div class="box">
         <?php
            $select_products = $conexion->prepare("SELECT * FROM `products`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount()
         ?>
         <h3><?= $number_of_products; ?></h3>
         <p>Productos Agregados</p>
         <a href="Productos.php" class="btn">Ver Productos</a>
      </div>

      <div class="box">
         <?php
            $select_users = $conexion->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $number_of_users = $select_users->rowCount()
         ?>
         <h3><?= $number_of_users; ?></h3>
         <p>Usuarios Normales</p>
         <a href="Cuentas_Usuario.php" class="btn">Ver Usuarios</a>
      </div>

      <div class="box">
         <?php
            $select_admins = $conexion->prepare("SELECT * FROM `admins`");
            $select_admins->execute();
            $number_of_admins = $select_admins->rowCount()
         ?>
         <h3><?= $number_of_admins; ?></h3>
         <p>Usuarios de Administradores</p>
         <a href="Cuentas_Admin.php" class="btn">Ver Administradores</a>
      </div>

      <div class="box">
         <?php
            $select_messages = $conexion->prepare("SELECT * FROM `messages`");
            $select_messages->execute();
            $number_of_messages = $select_messages->rowCount()
         ?>
         <h3><?= $number_of_messages; ?></h3>
         <p>Nuevos Mensajes</p>
         <a href="Mensajes.php" class="btn">Ver Mensajes</a>
      </div>

   </div>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>