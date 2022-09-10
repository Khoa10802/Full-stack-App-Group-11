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
    <title>My account</title>
</head>
<body>
    <header>
      <?php
        require('header.php');
      ?>
    </header>

    <main>
        <a href="javascript:logout();">logout</a>
    </main>

    <footer>
      <?php
        require('footer.php');
      ?>
    </footer>
</body>
</html>
<script src="/member/member.js" ></script>
