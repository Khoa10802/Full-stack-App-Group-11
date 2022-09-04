<?php
    session_start();
    // if (!isset($_SESSION['login'])) {
    //     header('location: login.php');
    // }

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add new product</title>
    </head>

    <body>
        <header>
            <!-- Header's content -->
        </header>

        <main>
            <!-- Main's content -->
            <h1>
                NEW PRODUCT
            </h1>
            <form method="post" action="vendoradd.php" enctype="multipart/form-data">
                <!-- Name -->
                <div class="form-row">
                    <div class="form-label">
                        <label for="product_name">
                            Name of the product:
                        </label>
                    </div>
                    <div class="form-field">
                        <input type="text" id="product_name" name="product_name">
                    </div>
                </div>
                <!-- Price -->
                <div class="form-row">
                    <div class="form-label">
                        <label for="product_price">
                            Price:
                        </label>
                    </div>
                    <div class="form-field">
                        <input type="number" id="product_price" name="product_price">
                    </div>
                </div>
                <!-- Image -->
                <div class="form-row">
                    <div class="form-label">
                        <label for="product_image">
                            Product's Image
                        </label>
                    </div>
                    <div class="form-field">
                        <input type="file" name="product_image" id="product_image">
                    </div>
                </div>
                <!-- Description -->
                <div class="form-row">
                    <div class="form-label">
                        <label for="product_description">Description</label>
                    </div>
                    <div class="form-field">
                        <textarea cols="40" rows="10" id="product_description" name="product_description"></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <input type="submit" value="Add" name="act">
                </div>

                <!-- Using PHP to validate product creation -->
                <?php
                    $name_err = $price_err = $image_err = $description_err = "";

                    if (isset($_POST['act'])) {
                        $has_err = false;
                        if (empty($_POST['product_name'])) {
                            $name_err = "Product's name is empty<br>";
                            $has_err = true;
                        }
                        if (!empty($_POST['product_name']) && (strlen($_POST['product_name']) <= 10 || strlen($_POST['product_name']) >= 20)) {
                            $name_err = "Product's name is too short or too long<br>";
                            $has_err = true;
                        }
                        if (empty($_POST['product_price'])) {
                            $price_err = "Product's price is empty<br>";
                            $has_err = true;
                        }
                        else if (!empty($_POST['product_price']) && $_POST['product_price'] < 0) {
                            $price_err = "Product's price is negative<br>";
                            $has_err = true;
                        }
                        if (empty($_POST['product_description'])) {
                            $description_err = "Product's description is empty<br>";
                            $has_err = true;
                        }
                        else if (!empty($_POST['product_description']) && strlen($_POST['product_description']) > 500) {
                            $description_err = "Product's description is too long<br>";
                            $has_err = true;
                        }
                        if (empty($_FILES['product_image']) || $_FILES["product_image"]["error"] != UPLOAD_ERR_OK) {
                            $image_err = "Error uploading image<br>";
                            $has_err = true;
                        }
                        
                        if (!$has_err) {
                            $image_name = str_replace(' ', '-', $_POST['product_name']);
                            $image_location = "itm_images/".$image_name.'.png';
                            move_uploaded_file($_FILES['product_image']['tmp_name'], $image_location);
                
                            $itm = [
                                'name' => $_POST['product_name'],
                                'price' => $_POST['product_price'],
                                'description' => $_POST['product_description'],
                                'image' => $image_location,
                                // 'vendor' => $_SESSION['username']
                            ];
                            $_SESSION['items'][] = $itm;
                            echo "<p> Item added </p>";
                        }
                    }
                ?>

                <!--Display error message-->
                <span class="error">
                    <?php echo $name_err; ?>
                    <?php echo $price_err; ?>
                    <?php echo $image_err; ?>
                    <?php echo $description_err; ?>
                </span> 
            </form>
        </main>
    </body>
</html>