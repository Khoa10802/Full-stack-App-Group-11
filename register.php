<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css" type="text/css">
    <title>Join</title>
</head>
<body>
    <header>
        <?php
            require('header.php');
        ?>
    </header>

    <main>
        <h1>REGISTER</h1>
        <div class="register_form">
            <form name="frm">
                <div class="radio">
                    <label>
                        <input type="radio" name="gubn" onclick="inputChange(this)" value="1" checked>
                        Customers
                    </label>
                    <label>
                        <input type="radio" name="gubn" onclick="inputChange(this)" value="2">
                        Vendors
                    </label>
                    <label>
                        <input type="radio" name="gubn" onclick="inputChange(this)" value="3">
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

                <div class="fill_pi">
                    <div class="pi_label">
                        <label>Profile Image: </label>
                    </div>
                    <input type="file" id="profile" accept="image/*"/>
                </div>

                <div class="shipper">
                    <div class="name_label">
                        <label>Name: </label>
                    </div>
                    <input type="text" id="userName"/>
                </div>

                <div class="shipper2">
                    <div class="address_label">
                        <label>Address: </label> 
                    </div>
                    <input type="text" id="address"/>
                </div>

                <div class="hub">
                    <div class="hub_label">
                        <label>Hub: </label>
                    </div>
                    <select id="hub">
                        <option value="hub1" selected>hub1</option>
                        <option value="hub2">hub2</option>
                        <option value="hub3">hub3</option>
                    </select> 
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
</html>
<script src="/join/join.js"></script>