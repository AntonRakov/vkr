<?php 
require 'lib/rb.php';
R::setup( 'mysql:host=localhost;dbname=barbershop','root', '' ); 

if ( !R::testconnection() )
{
		exit ('Нет соединения с базой данных');
}

session_start();