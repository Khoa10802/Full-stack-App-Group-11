<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Login</title>
</head>
<body>
    <header>
        <?php
            require('header.php');
        ?>
    </header>

    <main>
        <h1>LOGIN</h1>
        <div class="login_form">
            <form>
                <div class="radio">
                    <label>
                        <input type="radio" name="gubn" value="1" checked>
                        Customers
                    </label>
                    <label>
                        <input type="radio" name="gubn" value="2">
                        Vendors
                    </label>
                    <label>
                        <input type="radio" name="gubn" value="3">
                        Shippers
                    </label>
                </div>
                <div class="fill_ID">
                    <div class="ID_label">
                        <label>ID: </label>
                    </div>
                    <input type="text" id="userId" />
                </div>
                <div class="fill_pw">
                    <div class="pw_label">
                        <label>Password: </label>
                    </div>
                    <input type="password" id="pw" />
                </div>
                <p>
                    <input type="button" id="submit" value="SUBMIT">
                    <input type="reset" value="RESET">
                </p>
            </form>
        </div>
    </main>

    <footer>
      <?php
        require('footer.php');
      ?>
    </footer>
  </body>
</body>
</html>
<script src="/login/login.js"></script>