<?php

  function updateStatus($func_classString, $func_messageString) {
    ?><script type="text/javascript">
      updateStatus("<?= $func_classString ?>", "<?= $func_messageString ?>");
    </script><?php
  }

  $password = $_GET['password'];
  $username = trim($_GET['username']);
  $email    = trim($_GET['email']);
  $color    = (integer) $_GET['color'];
  if($color < 1 || $color > 15) $color = rand(1, 15);
  if(strlen($username) < PLAYER_MINLEN) die('Username Too Short');
  
  $uppername = strtoupper($username);
  if(str_replace(str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), '', $uppername) == $uppername) die('Username Error');
  
  
  //if(!Utils::CheckString('0123456789ABCDEF', 32, 32, $password)) die('Password Error');
  if(!Utils::CheckString(PLAYER_CHARS,PLAYER_MINLEN,PLAYER_MAXLEN, $username))  die('Username Error');
  if(!Utils::CheckString(EMAIL_CHARS,EMAIL_MINLEN,EMAIL_MAXLEN, $email)) die('Email Error');
 
  $query = sprintf("SELECT * FROM `accs` WHERE `name` = '%s'",
  mysql_real_escape_string($username));
 $checkuser = mysql_query($query);
$username_exist = mysql_num_rows($checkuser);
if($username_exist > 0){
    die("Name Taken!");
}

$player = array(
		'email' => $email,
		'registerIP' => $_SERVER['REMOTE_ADDR'],
		'registertime' => time(),
		'color' => $color,
		'head'	=> 0,
		'face'	=> 0,
		'neck'	=> 0,
		'body'	=> 0,
		'hands'	=> 0,
		'feet'	=> 0,
		'pin'	=> 0,
		'photo'	=> 0,
		'items'	=> array(1, 444),
		'coins'	=> 10000,
		'isModerator'	=>	false,
		'isBanned_'	=> false,
		'buddies' => array(),
		'ignore' => array(),
		'stamps' => array(),
		'stampColor' => 1,
		'stampHighlight' => 1,
		'stampPattern' => -1,
		'stampIcon' => 1,
		'igloo' => 1,
		'music' => 0,
		'floor' => 0,
		'furniture' => array(),
		'roomFurniture' => "",
		'mood' => "I am new to iCPPS",
);
	
	
$query = sprintf("INSERT INTO  `accs` (`ID`,`name`,`crumbs`,`password`)
 VALUES ('NULL', '%s', '%s', '%s');",
 mysql_real_escape_string($username),
  mysql_real_escape_string(md5($password)));
 mysql_real_escape_string(serialize($player)),
 mysql_real_escape_string($password));
 mysql_query($query) or die("Player DB Error: " .mysql_error());
 // Get Last ID
 $playerID = mysql_insert_id(); ?>
<strong>You've been registred succesfully</strong><br />
Thank you for signing up at iCPPS<br />
<br />
<small>Your PlayerID is <strong><?= $playerID ?></strong></small>

<?php updateStatus('ui-state-highlight', '<strong>Regristration Done:</strong> Successful'); ?>