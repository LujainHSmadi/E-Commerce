<?php
@include '../includes/connect.php';

$id = $_POST['id'] ?? null;
if (!$id) {
    header('Location:index.php');
    exit;
}

$statement = $conn->prepare('DELETE FROM `subcategory` WHERE `subcategory`.`subcategory_id` = :id');
$statement->bindValue(':id', $id);
$statement->execute();
header("Location:index.php");
