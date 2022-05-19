<?php
@include '../includes/connect.php';
$satement = $conn->prepare('SELECT * FROM `user` ORDER BY user_id DESC');
$satement->execute();
$userinfo = $satement->fetchAll(PDO::FETCH_ASSOC);

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
      <h1>User Info. CRUD</h1>
      <table class="table">
          <p>
         <a href="u_create.php" class="btn btn-success">GO Back to Products </a>
       </p>
          <thead>
              <tr>
                  <th scope ="col">#</th>
                  <th scope ="col">username</th>
                  <th scope ="col">phone</th>
                  <th scope ="col">city</th>
                  <th scope ="col">address</th>
                  <th scope ="col">email</th>
                  <th scope ="col">password</th>
                  <th scope ="col">Action</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($userinfo as $i => $info): ?>
              <tr>
                  <th scope = "row"><?php echo $i + 1; ?></th>
                  <td><?php echo $info["username"]  ?></td>
                  <td><?php echo $info["phone"] ?></td>
                  <td><?php echo $info["city"] ?></td>
                  <td><?php echo $info["address"] ?></td>
                  <td><?php echo $info["email"] ?></td>
                  <td><?php echo $info["password"] ?></td>
                  <td> <a class="btn btn-outline-primary" href="u_update.php?id=<?php echo $info['user_id'] ?>">Edit</a>
                  <form style ="display:inline-block" action="u_delete.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $info['user_id'] ?>">
                      <button type="submit" class="btn btn-outline-danger" href="delete?=<?php echo $info['user_id'] ?>" >Delete</button> </td>
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