<?php
//FUCKING CORRS.
echo file_get_contents("http://ontime01/ontimeweb/api/oauth2/token?grant_type=" . $_GET['grant_type'] . "&username="  . $_GET['username'] .  "&password=" . $_GET['password'] . "&client_id=" . $_GET['client_id'] . "&client_secret=" . $_GET['client_secret']);
?>