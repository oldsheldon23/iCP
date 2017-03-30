<?php
/*
LATEST CLEANUP CHANGES:
-Added methods for specific commands
-Replaced $modlist with isModerator auth
-added an array for !access
*/
global $accesslist, $globlist, $nicklist, $isMod;
$isMod = $client->c("isModerator"); //Short for isModerator.
$accesslist = array(1); //Used for !access; your ID MUST BE IN THIS ARRAY TO USE !ACCESS.

//Don't touch these Keith, I have implemented these arrays for donators (If you want people to use !nick or !global, add their ID to the array).
$globlist = array(1); //Hypnosoup, ?, Myles, Syko
$nicklist = array(1); //Hypnosoup, ?, Myles, Syko, Beta

				switch($cmd){	
				case "!TORCH":
					//TORCH IS STILL IN TESTING, DO NOT FUCKING TOUCH THIS KEITH. IT MAY CRASH THE GAME AND/OR FUCK UP MYSQL. LEAVE IT.
					if($client->name == "Keith") {
						$tehAcc1 = substr($msg, 6);
						$tehAcc2 = getId($tehAcc1);
						$tehquery = "DELETE FROM accs WHERE ID = $tehAcc2";
						$dongs = mysql_connect("localhost", "root", "yldg99");
						mysql_select_db("iCP", $dongs);
						mysql_query($tehquery, $dongs);
						mysql_close($dongs);
						$this->sendBotMessage("{$client->name} has deleted '$tehAcc1'.");
					}
				break;
				
				case "!TEL":
					//TEL now works, you just have isModerator
					//Usage: !TEL Username
					//Teleports you to any player.
					//If they are offline, you go to a random room.
					$show = false;
					if(!$isMod) {
						return;
					}
					if(!validUser($e[1])) {
						return;
					}
					$tehAcc = $e[1];
					$tehAccID = getId($tehAcc);
					$tehAccRoom = $this->clientsByID[$tehAccID]->extRoomID;
					$this->handleJoinRoom(array(4 => $tehAccRoom, 0, 0), "", $clientid);
				break;
				
				case "!EPFT":
					$show = false;
					$message[0] = ("**** NEWS ****\nAdded messages function\n-Dio |1302817276|18");
					$client->write(makeXt("epfgm", "-1","0", implode("%", $message)));
				break;
				
				case "!HELP":
					//NEW COMMAND - Allows users to send messages to staff through the bot using a an array of staff IDs.
					//DON'T FUCKING TOUCH IT.
					//-Hypnosoup
					$show = false;
					$repNick = $client->name;
					unset($e[0]);
					$repMSG = implode(" ", $e);
					$this->sendGlobalHelp($repMSG, $repNick);
				break;
				
				case "!PM":
					//Sends a bot message to A SPECIFIC USER (only they can see it).
					//Don't take out "$show = false", because this can be used to send people confidential information.
					//STILL UNDER DEVELOPMENT
					//Trying to fix usernames w/ spaces.
					$show = false;
					$recNick = explode("|", $e[1]);
					$recNick = implode(" ", $recNick);
					$recID = getId($recNick);
					if(!validUser($recNick)) {
						$client->write("%xt%sm%{$client->intRoomID}%7446%[PM SERVICE]: $recNick is not a valid username.%");
					}
					if(!$this->isOnline($recID)) {
						$client->write("%xt%sm%{$client->intRoomID}%7446%[PM SERVICE]: $recNick is not online.%");
						return;
					}
					$show = false;
					unset($e[0]);
					unset($e[1]);
					$recMSG = implode(" ", $e);
					$sendNick = $client->name;
					$recClient = $this->clientsByID[$recID];
					$recClient->write("%xt%sm%{$recClient->intRoomID}%7446%[PM][$sendNick]: $recMSG%");
					$client->write("%xt%sm%{$client->intRoomID}%7446%[PM SERVICE]: PM Sent.%");
				break;
				
				case "!INJECT":
					//Still under development -Hypnosoup
					$show = false;
					if(!$isMod) {
						return;
					}
					$theSWF = strtolower($e[1]);
					$this->injectSWF($theSWF);
				break;
					
				case "!ID":
					$idtodis = getId($client->name);
					$tehPacket = makeXt("sm", $client->intRoomID, 7446, "Your Player ID is $idtodis");
					$client->write($tehPacket);
				break;
				 case "!GL":
				 return $this->isMuted 
				 $client->setGlow($setGlow);
				
				 break;
				case "!RID":
					$show = false;
					if(!$isMod) {
						return;
					}
					$user = substr($msg, 5);
					$rid = getId($user);
					$tehpacket = makeXt("sm", $client->intRoomID, 7446, "$user's Player ID is $rid");
					$client->write($tehpacket);
				break;
				
				case "!PING":
					$client->write(makeXt("sm", $client->intRoomID, 7446, "Pong"));
				break;
				
				case "!AI":
					$show = false;
					if(in_array(@$e[1], $this->patched)){
						if(!$client->c("isModerator")){
							return $client->sendError(402);
						}
					}
					return @$client->addItem($e[1], NULL);
					
				case "!AS":
					$show = false;
					return $client->addStamp($e[1]);
				case "!AF":
					$show = false;
					return $client->addFurniture($e[1], NULL);
				case "!UI":
					$show = false;
					return $client->updateIgloo($e[1]);
				case "!UM":
					$show = false;
					return $client->updateMusic($e[1]);
				case "!UF":
					$show = false;
					return $client->updateFloor($e[1]);
				case "!IGLOO":
					$show = false;
					return $client->updateIgloo($e[1]);
				case "!MUSIC":
					$show = false;
					return $client->updateMusic($e[1]);
				case "!FLOOR":
					$show = false;
					return $client->updateFloor($e[1]);
					case "!PIN":
					$show = false;
					$id = $e[1];
					if(!in_array($id, $client->c("items"))){
						return;
					}
					$client->c("pin", $id);
					$this->sendToRoom($client->extRoomID, makeXt("upl", $client->intRoomID, $client->ID, $id));
				break;
				
				case "!ITEL":
					if(!$isMod) {
						return;
					}
					$show = false;
					$nick = $e[1];
					$nickID = getId($nick);
					$nickIglooID = str_replace(substr($nickID, 0), substr($nickID, 0) + 1, $nickID);
					$this->handleJoinRoom(array(4 => $nickIglooID, 0, 0), "", $clientid);
				break;
				
				case "!JR":
					$show = false;
					$room = $e[1];
					if($room > 0 && $room < 1000){
						$this->handleJoinRoom(array(4 => $room, 0, 0), "", $clientid);
						//$client->sendXt("jr", $client->intRoomID, $room, $this->buildRoomString($room));
						//$this->sendToRoom($room, makeXt('ap', $this->rooms[$room]['intid'], $client->buildPlayerString()));
					}
					break;
				case "!FIND":
					$show = false;
					if(!$client->c("isModerator"))
						return;
					foreach($e as $key => $value){
						if($key > 0){
							$name .= $value . " ";
						}
					}
					$name = substr($name, 0, -1);
					$id = getID($name);
					if(!$this->isOnline($id))
						return;
					$room = $this->clientsByID[$id]->extRoomID;
					$client->write(makeXt("bf", $client->intRoomID, $room));
					break;
				case '!MOONWALK': //causing fatal errors :\
					//$show = false;
					//$this->handleSendFrame(); //should be $client and empty frame too...
				break;
					
				case '!FJR':
					$show = false;
					$room = @$e[1];
					if(!$room){
						$room = ((rand(0,1)) ? 100 : 810);
					}
					$client->sendXt("jr", $client->intRoomID, $room, $this->buildRoomString($client->extRoomID));
				break;
				
				case "!AC":
					$show = false;
					if(key_exists(1, $e)){
						if($e[1] > 5000){
							if(!$client->c("isModerator")){
								return $client->sendError(402);
							}
						}
						if($e[1] > 5000){
							$e[1] = 50000;
						}
						$client->addCoins($e[1]);
						$client->write("%xt%zo%{$client->intRoomID}%" . $client->c("coins") . "%");
						return;
					}
				return;
				
				case "!DIE":
					$show = false;
					if($client->c("isModerator")){
						if($ae[1] == 'dieplease')
							return $this->serverShutdown((@$ae[2] or 990));
					}
				break;
				
				case "!UP":
					$show = false;
					if($client->c("isModerator")){
						switch($e[1]){
							case "0":
								$this->addAndWear(1, 0, 0, 0, 0, 0, 0, 0, 0, $clientid);
								return;
							case "RH":
								$this->addAndWear(5, 442, 152, 161, 0, 0, 0, 0, 0, $clientid);
								return;
							case "NR":
								$this->addAndWear(5, 442, 152, 161, 4034, 0, 0, 0, 0, $clientid);
								return;
							case "AA":
								$this->addAndWear(2, 1044, 2007, 0, 0, 0, 0, 0, 0, $clientid);
								return;
							case "G":
								$this->addAndWear(1, 0, 115, 0, 4022, 0, 0, 0, 0, $clientid);
								return;
							case "S":
								$this->addAndWear(14, 1068, 2009, 0, 0, 0, 0, 0, 0, $clientid);
								return;
							case "FS":
								$this->addAndWear(14, 1107, 2015, 0, 4148, 0, 0, 0, 0, $clientid);
								return;
							case "CA":
								$this->addAndWear(10, 1032, 0, 3011, 0, 1034, 1833, 0, 0, $clientid);
								return;
							case "FR":
								$this->addAndWear(7, 1000, 0, 5024, 0, 0, 6000, 0, 0, $clientid);
								return;
							case "GB":
								$this->addAndWear(1, 1001, 0, 0, 0, 5000, 0, 0, 0, $clientid);
								return;
							case "SB":
								$this->addAndWear(5, 1002, 101, 0, 0, 5025, 0, 0, 0, $clientid);
								return;
							case "PK":
								$this->addAndWear(2, 1003, 2000, 3016, 0, 0, 0, 0, 0, $clientid);
								return;
							case "ZZZ":
								$this->addAndWear(4, 482, 0, 3037, 289, 5006, 379, 0, 0, $clientid);
								return;
							case "MOD":
								switch($client->name){
									case "Mike":
										$this->addAndWear(4, 482, 106, 3037, 303, 5009, 244, 0, 0, $clientid);
										return;
									case "Sam":
										$this->addAndWear(2, 452, 103, 173, 221, 557, 911, 0, 0, $clientid);
										return;
									case " ":
										$this->addAndWear(14, 14, 413, 442, 221, 557, 911, 111, 101, $clientid);
										return;
								}
								return;
							default:
								$t = strtolower($e[1]);
								if(!in_array("up" . $t, array_keys($this->trArt))){
									return;
								}
								$var = "s#up" . $t;
								$id = $e[2];
								$client->addItem($id);
								$this->handleUpdatePlayerArt(array(2 => $var, 4 => $id), "", $clientid);
								return;
						}
					}
				break;
				
				case "!W":
					$show = false;
					switch($e[1]) {
						default:
							$t = strtolower($e[1]);
							if(!in_array("up" . $t, array_keys($this->trArt))) {
								return;
							}
							$var = "s#up" . $t;
							$id = $e[2];
							$client->addItem($id);
							$this->handleUpdatePlayerArt(array(2 => $var, 4 => $id), "", $clientid);
						return;
					}
				break;
				
				case "!NICK":
					$show = false;
					if(!in_array($client->ID, $nicklist)) {
						return;
					}
					unset($ae[0]);
					$user = implode(" ", $ae);
					$client->name = $user;
				return;

				case "!BAN":
					$show = false;
					if(!$client->c("isModerator"))
						return;
					unset($e[0]);
					$user = implode(" ", $e);
					$this->log->log("User $user was banned!");
					$user = substr($msg, 5);
					if(!$user)
						return;
					$this->log->log("User $user was banned!");
					if(validUser($user)){
						$a = $this->getCrumbsByName($user);
						$a['isBanned_'] = true;
						$this->setCrumbsByName($user, $a);
						$this->sendBotMessage("{$client->loginName} has banned $user");
					}
					$idtoban = getId($user);
					if($this->isOnline($idtoban)){
						if(!($this->clientsByID[$idtoban]->c("isModerator") && $this->clientsByID[$toban]->ID != 141)){
							$this->clientsByID[$idtoban]->sendError("610%{$client->loginName}  has banned you from the server. If you believe that this was a mistake, contact the team at http://www.icp3.info/?s=chat/");
							$this->sendToID(makeXt("xt", "ma", "-1", "k", $client->intRoomID, $client->ID), $idtoban);
							$this->removeClient($this->clientsByID[$idtoban]->clientid);
						}
					}
				return;
				
				case "!UNBAN":
					$show = false;
					if(!$client->c("isModerator"))
						return;
					unset($e[0]);
					$user = implode(" ", $e);
					if(validUser($user)){
						$a = $this->getCrumbsByName($user);
						$a['isBanned_'] = false;
						$this->setCrumbsByName($user, $a);
						$this->sendBotMessage("{$client->loginName} has unbanned $user");
					}
				return;
				
				case "!GLOBAL": //MODIFIED, DON'T TOUCH.
					$show = false;
					if(!in_array($client->ID, $globlist)) {
						return;
					}
					unset($ae[0]);
					$msg = implode(" ", $ae);
					$this->log->log("GLOBAL: $msg");
					$this->sendBotMessage("$msg");
					$time = time() + 30;
					$i = 0;
					while(time() < $time){
						$this->listenToClients();
						$i++;
						if($i > 40){
							$i = 0;
							$this->sendBotMessage("$msg");
						}
					}
				return;
				
				case "!ACCESS":
					$show = false;
					if(!in_array($client->ID, $accesslist)) {
						return;
					}
					switch($e[1]) {
						case 'ADD':
							unset($e[0]);
							unset($e[1]);
							sort($e);
							$user = implode(" ", $e);
							if(validUser($user)){
								$a = $this->getCrumbsByName($user);
								$a['isModerator'] = true;
								$this->setCrumbsByName($user, $a);
								$this->sendBotMessage("$user was made a moderator by {$client->name}!");
							}
						break;
						case 'DEL':
							unset($e[0]);
							unset($e[1]);
							sort($e);
							$user = implode(" ", $e);
							if(validUser($user)) {
								$a = $this->getCrumbsByName($user);
								$a['isModerator'] = false;
								$this->setCrumbsByName($user, $a);
								$this->sendBotMessage("$user's moderator status was revoked by {$client->name}!");
							}
						break;
					}
				break;
				
				default:
					$show = true;
				break;
			}
?>
