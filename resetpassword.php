<?php
$data = $_POST;

 ?>
<!DOCTYPE html>
  <head>
    <title>RESETING PASS</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css" media="screen">
      #forma{
        padding-top: 150px;
      }
    </style>
  </head>
  <header id="header">
    <h1>Minimalism Style</h1>
  </header>
  <body>
<form  action="resetpassword.php" method="POST">

    <div id="forma">
      <label for="password">SECURITY CODE</label>
      <br>
      <input type="text" name="code" id="code" required placeholder="insert code">
      <br>
      <label for="password">NEW Password</label>
      <br>
      <input type="password" name="password" id="password" required placeholder="must be strong">
      <br>
      <label for="re-password">Confirm Password</label>
      <br>
      <input type="password" name="re_password" id="re_password" required placeholder="must be strong">
      <br>
      <button id="Create-acc" type="submit" name="submit" >Reset Password</button>
      <div id="errorMessage">
        <?php
          session_start();
          //check pass
          function ValidPassword($value)
          {
            $reg = '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/';
            return (preg_match($reg,$value));
          }
          //check for right security code
          function checkCODE($account, $code)
          {
            while ($users = $account->fetch()) {
              if ($users['password'] == $code) {
                return true;
              }
            }
            return false;
          }
          //connet to db
          try
           {
            $pdo = new PDO('mysql:host=localhost;dbname=db_camagru;charset=utf8', 'root', 'root');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           }
           catch(PDOException $e)
           {
            die($e->getMessage());
          }


           //magic

            $errors = array();
           if (isset($data['submit'])) {
             if (($data['re_password'] != $data['password'])) {
                $errors[] = "Password doesnt match";
             }
             if (!ValidPassword($data['password'])) {
                $errors[] = "Password is not valid";
                $errors[] = "Use at least 6 characters";
                $errors[] = "With 1 lower, 1 uppercase and 1 number!";
             }

             $account = $pdo->query('SELECT password FROM users');
             if (!checkCODE($account, $data['code'])) {
               $errors[] = "Wrong Security Code";
             }

             if (empty($errors)) {
               $code = $data['code'];
               echo "Password Apdated";
               //
               $password = hash('md5', $data['password']);
               $reqest = "UPDATE `users` SET `password` = '$password' WHERE `users`.`password` = '$code';";
               $pdo->prepare($reqest)->execute();
               
               header("Location: login.php");
               exit();

             }
             else
             { $i = 0;
               while ($errors[$i]) {
                   echo "<span>&#9654</span>".$errors[$i]."<span>&#9664</span>"."<br>";
                   $i++;
               }
             }
           }

         ?>
      </div>
    </div>
    </form>
  </body>
  </html>
