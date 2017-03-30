<?php

  if(!function_exists('sendBack')) { function sendBack($func_value) { die($func_value); }}
  include 'Utils.php';
  include 'settings.php';
  
  $username = strtolower($_GET['username']);
  $mysql = mysql_connect(MYSQL_HOSTNAME,MYSQL_USERNAME,MYSQL_PASSWORD) or sendBack('fail');
  mysql_select_db(MYSQL_DATABASE) or sendBack('fail');

  $func_res = mysql_query('SELECT name FROM accs') or sendBack('fail');
  while($func_line = mysql_fetch_array($func_res, MYSQL_ASSOC)) {
    if(strtolower($func_line['playerName']) == $username) { sendBack('true'); break; }
  } mysql_free_result($func_res);
  
  sendBack('false');

?>