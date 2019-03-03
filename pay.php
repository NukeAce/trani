<?php 

$connect = mysqli_connect("localhost:3308", "root", "", "bakerydb");
if(isset($_POST["id"]))
{
	$query = "SELECT recipient FROM suppliers WHERE id = '".$_POST["id"]."'";
	$qResult=mysqli_query($connect, $query);
	while ($qValues=mysqli_fetch_assoc($qResult)){
	     if (is_null($qValues["recipient"])){

	     	
				$myfile = "list.json";
				 $dat = file_get_contents("$myfile");
					$ya = json_decode($dat);
					$code= $ya->data->recipient_code;
				file_put_contents($myfile, "");

				$query = "UPDATE suppliers SET recipient ='".$code."' WHERE id = '".$_POST["id"]."'";

				 if(mysqli_query($connect, $query))
				 {
				  echo 'recipient updated';
				 }

				 $query2 = "SELECT source, amount, recipient FROM suppliers WHERE id = '".$_POST["id"]."'";



				$res = mysqli_query($connect, $query2);
				while ($row = mysqli_fetch_assoc($res)) 
				{
					$var= json_encode($row, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_LINE_TERMINATORS);    
				}


					$ch = curl_init();

					curl_setopt($ch, CURLOPT_URL, 'https://api.paystack.co/transfer');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $var);
					curl_setopt($ch, CURLOPT_POST, 1);

					$headers = array();
					$headers[] = 'Authorization: Bearer sk_test_ee6ffed0718d607063af1be81d911419bd4eb224';
					$headers[] = 'Content-Type: application/json';
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

					$paid = curl_exec($ch);
					if (curl_errno($ch)) {
					echo 'Error:' . curl_error($ch);
					}
					curl_close ($ch);


					printf($paid);




	     }
	     else{
	        $query3 = "SELECT source, amount, recipient FROM suppliers WHERE id = '".$_POST["id"]."'";



			$res2 = mysqli_query($connect, $query3);
			while ($row1 = mysqli_fetch_assoc($res2)) 
			{
				$var2= json_encode($row1, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_LINE_TERMINATORS);    
			}

			$ch2 = curl_init();

				curl_setopt($ch2, CURLOPT_URL, 'https://api.paystack.co/transfer');
				curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch2, CURLOPT_POSTFIELDS, $var2);
				curl_setopt($ch2, CURLOPT_POST, 1);

				$headerss = array();
				$headerss[] = 'Authorization: Bearer sk_test_ee6ffed0718d607063af1be81d911419bd4eb224';
				$headerss[] = 'Content-Type: application/json';
				curl_setopt($ch2, CURLOPT_HTTPHEADER, $headerss);

				$paid2 = curl_exec($ch2);
				if (curl_errno($ch2)) {
				echo 'Error:' . curl_error($ch2);
				}
				curl_close ($ch2);


				printf($paid2);



		}
	}


}





