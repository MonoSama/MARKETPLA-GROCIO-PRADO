<?php

include 'components/Conectar.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:User_sesion.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conexion->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conexion->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conexion->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Pedido realizado correctamente!';
   }else{
      $message[] = 'Tu carrito esta vacío';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Verify</title>
   
   <!--== Kit de herramienta SVG, fuente y css, página: cdnj.com ==-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <!--== LLAMAR AL ESTILO DE LA PÁGINA ==-->
   <link rel="icon" href="logo/LOGO_FSTYLEZ.ico">

</head>
<body>
   
<?php include 'components/User_Encabezado.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Tus órdenes</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conexion->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= 'S/'.$fetch_cart['price'].' - x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">Tu carrito esta vacío!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">Total General : <span>S/<?= $grand_total; ?></span></div>
      </div>

      <h3>Haga sus pedidos</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Nombres y Apellidos :</span>
            <input type="text" name="name" placeholder="Introduzca su nombre" class="box" maxlength="40" required >
         </div>
         <div class="inputBox">
            <span>Número de celular:</span>
            <input type="number" name="number" placeholder="Introduzca su numero de celular" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 9) return false;" required>
         </div>
         <div class="inputBox">
            <span>Tu correo electrónico :</span>
            <input type="email" name="email" placeholder="Introduce tu correo electrónico" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Método de pago :</span>
            <select name="method" class="box" required>
               <option selected hidden value="">Métodos de pago</option> <!--Esta opcion me sirve para que siempre aparezca eso primera, para identificar que es los metodos de pagos-->
               <option value="cash on delivery">Pago contra entrega </option>
               <option value="credit card">Tarjeta de crédito</option>
               <option value="paytm">Paytm</option>
               <option value="paypal">Paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Número de telefono fijo :</span>
            <input type="number" name="flat" placeholder="Por ejemplo, 7777777" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 7) return false;" required>
         </div>
         <div class="inputBox">
            <span>Dirección :</span>
            <input type="text" name="street" placeholder="Por ejemplo, Jr. / Av. / Urb. / Calle" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Región o Departamento :</span>
            <input type="text" name="city" placeholder="Por ejemplo, Lima" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Provincia :</span>
            <input type="text" name="state" placeholder="Por ejemplo, Cañete" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>País :</span>
            <input type="text" name="country" placeholder="Por ejemplo, Perú" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Codigo postal :</span>
            <input type="number" min="0" name="pin_code" placeholder="por ejemplo, 15701" min="0" max="55555" onkeypress="if(this.value.length == 5) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value=" ║✓║ Realizar compra">

   </form>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>