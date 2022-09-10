<header>
  <div class="logo"> <img src="logo.png" alt="LOGO"> </div>
  <div class="website-name">Group 11</div>
  <nav class="header-nav">
      <?php
        if (!isset($_SESSION['login'])) {
          ?>
            <a href="index.php">Login</a>
            <a href="register.php">Register</a>
          <?php
        } else {
          ?>
            <a href="member.php">My Account</a>
          <?php
          if (isset($_SESSION['customer'])) {
            ?>
              <a href="customerview.php">Products</a>
              <a href="shoppingcart.php">Cart</a>
            <?php
          } else if (isset($_SESSION['vendor'])) {
            ?>
              <a href="vendorview.php">Products list</a>
              <a href="vendoradd.php">Add product</a>
            <?php
          } else {
            ?>
              <a href="shipperpage.php">Shipping list</a>
            <?php
          }
        }
      ?>

      <!--Temporary-->
      <a href="customerview.php">Products</a>
      <a href="shoppingcart.php">Cart</a>

      <a href="vendorview.php">Products list</a>
      <a href="vendoradd.php">Add product</a>

      <a href="shipperpage.php">Shipping list</a>

  </nav>
</header>