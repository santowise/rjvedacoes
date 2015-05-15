<?php
//Apaga o cookie com o login
setcookie(COOKIE_LOGIN, '', time()-3600, '/');


//Retorna para a página de login
header('Location: ' . HOST_URL);