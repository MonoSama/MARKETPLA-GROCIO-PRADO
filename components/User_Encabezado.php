
<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">Vende@Cañete<span>.</span></a>

      <nav class="navbar">
         <a href="home.php">Inicio</a>
         <a href="Sobre.php">Acerca de Nosotros</a>
         <a href="Pedidos.php">Pedidos</a>
         <a href="Tienda.php">Tienda</a>
         <a href="Contacto.php">Contacto</a>
      </nav>

      <div class="icons">
         <?php
            $count_wishlist_items = $conexion->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conexion->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="Página_busq.php"><i class="fas fa-search"></i></a>
         <a href="Lista_Deseo.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="Carro_comp.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conexion->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile["name"]; ?></p>
         <a href="User_actualizar.php" class="btn">Actualizar Perfil</a>
         <div class="flex-btn">
            <a href="User_registro.php" class="option-btn">Registrarse</a>
            <a href="User_sesion.php" class="option-btn">Iniciar Sesión</a>
         </div>
         <a href="components/Cierre_Sesión_User.php" class="delete-btn" onclick="return confirm('¿Cerrar sesión en el sitio web?');">Cerrar Sesión</a> 
         <?php
            }else{
         ?>
         <p>¡Por favor inicie sesión o regístrese primero!</p>
         <div class="flex-btn">
            <a href="User_registro.php" class="option-btn">Registrarse</a>
            <a href="User_sesion.php" class="option-btn">Iniciar Sesión</a>
         </div>
         <?php
            }
         ?>      
         
         
      </div>

   </section>

</header>