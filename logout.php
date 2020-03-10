<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION['user_id']);
   unset($_SESSION['user_name']); 
   unset($_SESSION['user_email']);
   unset($_SESSION['user_type']);
   unset($_SESSION['dep_id']);
   
   header('Refresh: 2; URL = user_login_page.html');
?>