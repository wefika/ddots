<?php

$dat_host = "localhost";
$dat_port = "3306";
$dat_username = "root";
$dat_password = "toor";
$dat_name = "bunchdb";

$my_sql = mysql_connect($dat_host.":".$dat_port,$dat_username,$dat_password);

mysql_select_db($dat_name,$my_sql);


mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

?>