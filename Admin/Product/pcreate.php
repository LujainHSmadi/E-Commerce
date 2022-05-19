<?php

@include '../includes/connect.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_des = $_POST['product_des'];
    $subcategory_id = $_POST['subcategoryid'];
    if (empty($product_name)) {
        $errors[] = 'Product title is required';

    }
    if (empty($product_des)) {
        $errors[] = 'Description is required';

    }
    if ($subcategory_id == "no") {
        $errors[] = 'Category is required';

    }
    if (!is_dir('images')) {
        mkdir('images');
    }
    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;
        $imagePath = '';
        if ($image) {
            $imagePath = 'images/' . $image['name'];
            // mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $query = "INSERT INTO `product` (`product_id`, `product_name`,`product_price` ,`product_img`, `product_des`, `sub_category_id`)
        VALUES (NULL, :name,:price ,:image, :des,:sub_id)";

        $statment = $conn->prepare($query);
        $statment->bindValue(':name', $product_name);
        $statment->bindValue(':price', $product_price);
        $statment->bindValue(':image', $imagePath);
        $statment->bindValue(':des', $product_des);
        $statment->bindValue(':sub_id', $subcategory_id);
        $statment->execute();

        // header('Location:index.php');
    }
}

function randomString($n)
{
    $str = '';
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }
    return $str;
}

?>


<!doctype html>
<html lang="en">
  <head>
    <title>Create</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <!-- categories -->
      <h1>Create New Product</h1>
      <?php if (!empty($errors)): ?>

            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo $error ?></div>
                    <?php endforeach?>
            </div>
           <?php endif?>
      <br>
      <form action="" method="post" enctype="multipart/form-data">
                 <input class="form-control" type="text" placeholder="Add Product" name="product_name" "><br>
                 <input class="form-control" type="number" step="0.01" placeholder="Price" name="product_price" ">
                    <br>
                <div class="custom-file">
                    <br>
                    <input type="file" class="form-control-file" id="customFile" name="image">
                    </div>

                    <div class="form-group">
                    <br>
                    <label for="exampleFormControlTextarea1">Description </label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="product_des" ></textarea>
                </div>

              <?php

$sql = "SELECT * FROM `subcategory`";

$sta = $conn->prepare($sql);
$sta->execute();
$publish = $sta->fetchAll();

?>

            <select name="subcategoryid" require>
                <option value="no">select Sub-category</option>
                <?php foreach ($publish as $value): ?>
                <option value="<?php echo $value['subcategory_id']; ?>"><?php echo $value['subcategory_name']; ?></option>
                <?php endforeach;?>
                </select>

             <br><br>
             <br><br>

             <button type="submit" class="btn btn-primary" name="add_product">Add</button>
      <form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
