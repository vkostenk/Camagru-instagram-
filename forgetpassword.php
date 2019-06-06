<?php $data = $_POST; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Forget Pass</title>
    <style type="text/css" media="screen">
      body{
        font-family: helvetica, sans-serif;
        font-size: 150%;
      }
      input{
        height: 25px;
        padding: 5px;
        font-size: 25px;
        border-color: black;
        margin-top: 15px;
        margin-bottom: 15px;
      }
      label{

      }
      #forma{
        width: 500px;
        height: 600px;

        margin: 0 auto;
        text-align: center;
      }
      #content{
        margin-top: 125px;
      }
      #header{
        text-align: center;
      }
      #button{
        font-size: 150%;
        background-color: gold;
        margin-top: 50px;
      }

      #forget{

        position: relative;
        bottom: -50px;
      }
      #errorMessage{
        color: red;
        margin-top: 15px;
      }
      H1 {
  display: inline-block;
  position: relative;
  letter-spacing: .05em;
  font-size: 50px;
  cursor: pointer;
  color: white;
  transition: all 1s;
  }


  H1:hover {
    color: Gold;
    }

    </style>
  </head>
  <header id="header">
    <h1>Minimalism Style</h1>
  </header>
  <body>
    <form  action="forgetpassword.php" method="POST">

        <div id="forma">

          <label for="email">Email</label>
          <br>
          <input type="text" name="email" id="email" placeholder="yourname@gmail.com" required value="<?php echo @$data['email']; ?>">
          <br>

          <button id="button" type="submit" name="submit" >Reset password</button>
          <div id="errorMessage">
            <?php
              session_start();


            //conect to database
            try
             {
              $pdo = new PDO('mysql:host=localhost;dbname=db_camagru;charset=utf8', 'root', 'root');
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             }
             catch(PDOException $e)
             {
              die($e->getMessage());
             }
             //chek if email exist
             function checkMAIL($account, $email)
             {
               while ($users = $account->fetch()) {
                 if ($users['email'] == $email) {
                   return true;
                 }
               }
               return false;
             }
               //generate security password for reseting it
             function generateRandomString($length = 10) {
               $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
               $charactersLength = strlen($characters);
               $randomString = '';
               for ($i = 0; $i < $length; $i++) {
                 $randomString .= $characters[rand(0, $charactersLength - 1)];
               }
               return $randomString;
               }

             $errors = array();
             if (isset($data['submit'])) {
               $account = $pdo->query('SELECT email FROM users');
               if (!checkMAIL($account, $data['email'])) {
                 $errors[] = "Email is not valid";
               }
               if (empty($errors)) {
                 //run
                 $email = $data['email'];
                 //new pass


                 $string = generateRandomString();
                  // echo $string;
                 $reqest = "UPDATE `users` SET `password` = '$string' WHERE `users`.`email` = '$email';";

                 $pdo->prepare($reqest)->execute();

                 echo "Link was sented on entered email=)";

                 mail($email, 'Camagru', 'For reseting password CLICK HERE! => http://localhost:8888/Main/resetpassword.php
                 Use This code:'.$string, 'From : admin@camag.com');
                //  mail($email, 'Camagru', 'for register come here ! => http://localhost:8888/Main/aftermail.php', 'From : admin@camag.com');
                  echo "<br>You will be redirected to another page in 10 seconds";
                  header("refresh:10;resetpassword.php");
                 //exit;
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
