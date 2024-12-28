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

      <a href="../admin/Configuracion_General.php" class="logo">Vende@Cañete<span>Panel</span></a>

      <nav class="navbar">
         <a href="../admin/Configuracion_General.php">Inicio</a>
         <a href="../admin/Productos.php">Productos</a>
         <a href="../admin/Pedidos_Realizados.php">Pedidos</a>
         <a href="../admin/Cuentas_Admin.php">Administradores</a>
         <a href="../admin/Cuentas_Usuario.php">Usuarios</a>
         <a href="../admin/Mensajes.php">Mensajes</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conexion->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="../admin/Actualizar_Perfil.php" class="btn">Actualizar Perfil</a>
         <div class="flex-btn">
            <a href="../admin/Registrar_Admin.php" class="option-btn">Registrarse</a>
            <a href="../admin/Inicio_Sesion_Admin.php" class="option-btn">Iniciar Sesión</a>
         </div>
         <a href="../components/Cerrar_Sesión_Admin.php" class="delete-btn" onclick="return confirm('¿Cerrar sesión en el sitio web?');">Cerrar Sesión</a> 
      </div>
               
   </section>

</header>