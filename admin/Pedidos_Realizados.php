<?php

include '../components/Conectar.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:Inicio_Sesion_Admin.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = $conexion->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = '¡Estado de pago actualizado!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conexion->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:Pedidos_Realizados.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pedidos Realizados</title>

   <!--== Kit de herramienta SVG, fuente y css, página: cdnj.com ==-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!--== ICONO DE LA PÁGINA ==-->
   <link rel="stylesheet" href="../css/admin_style.css">

   <!--== ICONO DE LA PÁGINA ==-->
   <link rel="icon" href="LOGO_FSTYLEZ.ico">

</head>
<body>

<?php include '../components/Admin_Encabezado.php'; ?>

<section class="orders">

<h1 class="heading">Pedidos Realizados</h1>

<div class="box-container">

   <?php
      $select_orders = $conexion->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Fecha del Pedido : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Nombre : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> Número de Celular : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> Dirección : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Total de Productos: <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Precio Total : <span>S/<?= $fetch_orders['total_price']; ?></span> </p>
      <p> Forma de Pago : <span><?= $fetch_orders['method']; ?></span> </p>
      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="payment_status" class="select">
            <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">Pendiente</option>
            <option value="completed">Completado</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="Actualizar" class="option-btn" name="update_payment">
         <a href="Pedidos_Realizados.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('¿Eliminar este pedido?');">Eliminar</a>
        </div>
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">¡No hay pedidos realizados todavía!</p>';
      }
   ?>

</div>

</section>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>