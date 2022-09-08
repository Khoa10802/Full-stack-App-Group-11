<header>
  <div class="logo"> <img src="logo.png" alt="LOGO"> </div>
  <div class="website-name">Group 11</div>
  <nav class="header-nav">
      <?php
        if (!isset($_SESSION['login'])) {
          ?>
            <a href="#">Register</a>
            <a href="#">Login</a>
          <?php
        } else {
          ?>
            <a href="#">My Account</a>
          <?php
        }
      ?>

      <!--Temporary-->
      <a href="customerview.php">Products</a>
      <a href="shoppingcart.php">Cart</a>

      <a href="vendorview.php">Products list</a>
      <a href="vendoradd.php">Add product</a>
  </nav>
</header>