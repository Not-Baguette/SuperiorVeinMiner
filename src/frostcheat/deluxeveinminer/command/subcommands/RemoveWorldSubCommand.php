<?php

namespace frostcheat\deluxeveinminer\command\subcommands;

use frostcheat\deluxeveinminer\command\SubCommandInterface;
use frostcheat\deluxeveinminer\command\VeinMinerCommand;
use frostcheat\deluxeveinminer\Loader;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class RemoveWorldSubCommand implements SubCommandInterface {

    public function getName(): string {
        return "removeworld";
    }
    
    public function getDescription(): string {
        return "Remove a world from the world blacklist";
    }
    
    public function getUsage(): string {
        return "/deluxeveinminer removeworld <world_name>";
    }
    
    public function getPermission(): ?string {
        return "deluxeveinminer.command.remove.world";
    }

    public function execute(VeinMinerCommand $parent, CommandSender $sender, array $args): bool {
        if (!$sender->hasPermission($this->getPermission())) {
            $sender->sendMessage(TextFormat::colorize("&cYou don't have permission to use this command."));
            return false;
        }
        
        if (count($args) === 0) {
            $sender->sendMessage(TextFormat::colorize("&cUsage: " . $this->getUsage()));
            return false;
        }
        
        $worldName = strtolower(implode("_", $args));
        
        // Check if world exists
        $world = Loader::getInstance()->getServer()->getWorldManager()->getWorldByName($worldName);
        if ($world === null) {
            $sender->sendMessage(TextFormat::colorize("&cWorld '$worldName' does not exist."));
            return false;
        }
        
        $actualWorldName = strtolower($world->getFolderName());

        if (!in_array($actualWorldName, Loader::getInstance()->worlds)) {
            $sender->sendMessage(TextFormat::colorize("&cThis world is not on the blacklist."));
            return false;
        }

        $index = array_search($actualWorldName, Loader::getInstance()->worlds, true);
        if ($index !== false) {
            unset(Loader::getInstance()->worlds[$index]);
            Loader::getInstance()->worlds = array_values(Loader::getInstance()->worlds);
            Loader::getInstance()->save();
            $sender->sendMessage(TextFormat::colorize("&aThe world &e$actualWorldName&a has been successfully removed from the blacklist."));
        } else {
            $sender->sendMessage(TextFormat::colorize("&cUnexpected error: world not found in blacklist."));
        }
        return true;
    }
}