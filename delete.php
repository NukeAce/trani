<?php
$connect = mysqli_connect("localhost:3308", "root", "", "bakerydb");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM suppliers WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}
?>
