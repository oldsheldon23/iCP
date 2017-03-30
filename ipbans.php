<?php
//Keith, I've modified this so that we can have an !ipban command. Still working on it, don't touch this.
$ipbanlist = file_get_contents("ipbans.list");
$ipbans = explode("#", $ipbanlist);
?>
