<?php
$data = $_POST;
session_start();
if (!$_SESSION[login])
{
	header('location: index.php');
	exit;
}
?>
<!DOCTYPE html>

<head>
    <title>My Account</title>
    <link rel="stylesheet" href="style2.css">
    <style type="text/css" media="screen">
    button{
      background-color: white;
      border-color: gold;
    }
		footer{
			position: absolute;
			bottom: 0;
		}
    </style>
</head>
    <!-- the header -->
  <?php require_once('header.php'); ?>

  <body>
    <div class="">
      <?php
      $login = $_SESSION[login];
			//echo $login;
			try
			 {
				$pdo = new PDO('mysql:host=localhost;dbname=db_camagru;charset=utf8', 'root', 'root');
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			 }
			 catch(PDOException $e)
			 {
				die($e->getMessage());
			 }
      $account = $pdo->query('SELECT username,phone,email FROM users');
      while ($users = $account->fetch()) {
				//print_r($users);
        if ($users['username'] == $login) {
          $mail = $users['email'];
        $phone = $users['phone'];
        }
      }
			 //echo $login;
      // echo $_SESSION[login];
       ?>
       <form  action="myaccount.php" method="POST">
       <p>Username phone:  <?php echo $phone;?></p>
       <p>Username email:  <?php echo $mail;?></p>
        <p>new phone: <input type="text" name="newphone" value=""></p>
         <p>new email: <input type="text" name="newemail" value=""></p>
       <button type="submit" name="change">Change</button>
     </form>
     <?php
     $newphone = $data['newphone'];
     $newemail = $data['newemail'];
     //echo $newphone;
     //echo $username;
  if (isset($data['change'])) {
if ($newphone != "") {
  $reqest = "UPDATE `users` SET `phone` = '$newphone' WHERE `users`.`username` = '$login';";
   $pdo->prepare($reqest)->execute();
 }
if ($newemail != "") {
	   $reqest = "UPDATE `users` SET `email` = '$newemail' WHERE `users`.`username` = '$login';";
	    $pdo->prepare($reqest)->execute();
		}
   header("Location: myaccount.php");
}


      ?>
    </div>
  </body>
    <!-- the footer -->
  <?php require_once('footer.php'); ?>

</body>
</html>
