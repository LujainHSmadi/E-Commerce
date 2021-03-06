<?php
@include '../includes/connect.php';
$satement = $conn->prepare('SELECT * FROM `product` ORDER BY product_id DESC');
$satement->execute();
$products = $satement->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
  <head>
    <title>index</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <h1>Product CRUD</h1>
      <table class="table">
          <p>
         <a href="pcreate.php" class="btn btn-success">Create Product</a>
       </p>
          <thead>
              <tr>
                  <th scope ="col">#</th>
                  <th scope ="col">Image</th>
                  <th scope ="col">Name</th>
                  <th scope ="col">Price</th>
                  <th scope ="col">Description</th>
                  <th scope ="col">Action</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($products as $i => $product): ?>
              <tr>
                  <th scope = "row"><?php echo $i + 1; ?></th>
                  <td><?php echo "<img src=" . $product["product_img"] . " width=100px height=100px>" ?></td>
                  <td><?php echo $product["product_name"] ?></td>
                  <td><?php echo $product["product_price"] ?></td>
                  <td><?php echo $product["product_des"] ?></td>
                  <td> <a class="btn btn-outline-primary" href="pupdate.php?id=<?php echo $product['product_id'] ?>">Edit</a>
                  <form style ="display:inline-block" action="pdelete.php" method="post">
                     <input type="hidden" name="id" value="<?php echo $product['product_id'] ?>">

                      <button type="submit" class="btn btn-outline-danger" href="delete?=<?php echo $product['product_id'] ?>" >Delete</button> </td>



                  </form>


              </tr>
              <?php endforeach;?>
          </tbody>
      </table>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>