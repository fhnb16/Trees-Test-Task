<?php
require('connect.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <title>Trees View</title>

      <link rel='stylesheet' type='text/css' href='assets/style/index.css'>
      <script type='text/javascript' src=''></script>

      <style type='text/css'>

      </style>

    </head>
    <body>
      
      <nav>
          <div class="logo">Trees View</div>
          <div class="user">Admin, fhnb16</div>
          <ul>
              <li>Sign in</li>
              <li>Edit</li>
              <li>Sign out</li>
          </ul>
      </nav>

      <div class="content">

		<div class="authView">

<form method="post" action="auth.php">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Login</button>
    </div>
</form>

		</div>

		<div class="guestView">



		</div>

		<div class="adminView">



		</div>

      </div>

      <footer>
      	<?
			$end_time = microtime(TRUE);
			$time_taken = ($end_time-$start_time);
			$time_taken = round($time_taken,3);
      	?>
      	Made by <a href="//fhnb.ru/">fhnb16</a> in <?echo date("Y")?>, page loaded in <?echo $time_taken?>s.
      </footer>

      <script type='text/javascript'>
        // Add your JS here
        
      </script>
    </body>
</html>
