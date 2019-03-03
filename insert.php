<?php
$connect = mysqli_connect("localhost:3308", "root", "", "bakerydb");
if(isset($_POST["name"], $_POST["description"], $_POST["account_number"], $_POST["bank_code"],  $_POST["amount"]))
{
 $name = mysqli_real_escape_string($connect, $_POST["name"]);
 $description = mysqli_real_escape_string($connect, $_POST["description"]);
 $account_number = mysqli_real_escape_string($connect, $_POST["account_number"]);
 $bank_code = mysqli_real_escape_string($connect, $_POST["bank_code"]);
 $amount = mysqli_real_escape_string($connect, $_POST["amount"]);

$query = "INSERT INTO suppliers(name, description, account_number, bank_code, amount) VALUES('$name', '$description', '$account_number', '$bank_code', '$amount')";
$query2 = "SELECT type, name, description, account_number, bank_code, currency FROM suppliers ";



if(mysqli_query($connect, $query))
{
  echo 'Data Inserted';
}

$result = mysqli_query($connect, $query2);
$data_array = array();
while ($row = mysqli_fetch_assoc($result)) 
{
     $data_array = $row;
}

$url = "https://api.paystack.co/transferrecipient";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data_array)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$headers = [
  'Authorization: Bearer sk_test_ee6ffed0718d607063af1be81d911419bd4eb224',
  'Content-Type: application/json',

];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$request = curl_exec ($ch);

curl_close ($ch);

$outfile = "list.json";
if($request) { 
    if(file_put_contents($outfile, $request)) {
      echo "Saved JSON fetched from paystack as “{$outfile}”.";
    }
    else {
      echo "Unable to save JSON to “{$outfile}”.";
    }
}
else {
   echo "Unable to fetch JSON from paystack.";
}

}


