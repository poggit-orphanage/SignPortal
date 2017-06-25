<?php

namespace leonchang99\SignPortal;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\tile\Sign;
/** Not currently used but may be later used  */
use pocketmine\level\Position;
use pocketmine\entity\Entity;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;
use pocketmine\tile\Tile;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {
    
    const PREFIX = TextFormat::GREEN . "[" . "SignPortal" . "]" . TextFormat::RESET . " ";
    private $api, $server, $path;

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerInteract(\pocketmine\event\player\PlayerInteractEvent $event) {
        if($event->getBlock()->getID() == 323 || $event->getBlock()->getID() == 63 || $event->getBlock()->getID() == 68) {
            $sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
            if(!($sign instanceof Sign)) {
                return;
            }
            $sign = $sign->getText();
            if($sign[0]=='[WORLD]'){
                if(empty($sign[1]) !== true) {
                    $mapname = $sign[1];
                    $event->getPlayer()->sendMessage(self::PREFIX . TextFormat::AQUA . "Preparing world '".$mapname."'");
                    //Prevents most crashes
                    if(Server::getInstance()->loadLevel($mapname) != false){
                        $event->getPlayer()->sendMessage(self::PREFIX . TextFormat::GREEN . "Teleporting...");
                        $event->getPlayer()->teleport(Server::getInstance()->getLevelByName($mapname)->getSafeSpawn());
                    }else{
                        $event->getPlayer()->sendMessage(self::PREFIX . TextFormat::RED . "World '".$mapname."' not found.");
                    }
                }
            }
        }
    }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args){
        //Commands are just for development only, tread carefully...
        switch($command->getName()){
            //Very basic world generation command for world teleportation testing
            case "generate":
                if(isset($args[0])){
                    Server::getInstance()->generateLevel($args[0]);
                    $sender->sendMessage(self::PREFIX . TextFormat::AQUA . "World " . $args[0] . " is being generated");
                }else{
                    $sender->sendMessage("Usage /generate <worldname>");
                }
                return true;
            default:
                return false;
        }
    }

    /** Stuff for next update once SignChangeEvent is implemented */
    public function onSignChange(\pocketmine\event\block\SignChangeEvent $event){
        if($event->getBlock()->getID() == 323 || $event->getBlock()->getID() == 63 || $event->getBlock()->getID() == 68){
            //Server::getInstance()->broadcastMessage("lv1");
            $sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
            if(!($sign instanceof Sign)){
                return true;
            }
            $sign = $event->getLines();
            if($sign[0]=='[WORLD]'){
                //Server::getInstance()->broadcastMessage("lv2");
                if($event->getPlayer()->hasPermission("signportal.create")){
                    //Server::getInstance()->broadcastMessage("lv3");
                    if(empty($sign[1]) !==true){
                        //Server::getInstance()->broadcastMessage("lv4");
                        if(Server::getInstance()->loadLevel($sign[1])!==false){
                            //Server::getInstance()->broadcastMessage("lv5");
                            $event->getPlayer()->sendMessage(self::PREFIX . TextFormat::GREEN . "Portal to world '".$sign[1]."' created");
                            return true;
                        }
                        $event->getPlayer()->sendMessage(self::PREFIX . TextFormat::RED . "World '".$sign[1]."' does not exist!");
                        //Server::getInstance()->broadcastMessage("f4");
                        $event->setLine(0,"[BROKEN]");
                        return false;
                    }
                    $event->getPlayer()->sendMessage(self::PREFIX . TextFormat::RED . " World name not set");
                    //Server::getInstance()->broadcastMessage("f3");
                    $event->setLine(0,"[BROKEN]");
                    return false;
                }
            $event->getPlayer()->sendMessage(self::PREFIX . TextFormat::RED . "You need signportal.create permission to make a portal");
            //Server::getInstance()->broadcastMessage("f2");
            $event->setLine(0,"[BROKEN]");
            return false;
            }
        }
        return true;
    }
}
