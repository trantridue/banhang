<?php
echo $commonUtil->loadConfiguration(); 
echo $commonUtil->loadUserInformation($_SESSION['session_user_id']); 
?>