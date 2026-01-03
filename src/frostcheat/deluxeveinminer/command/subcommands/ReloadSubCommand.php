<?php

namespace frostcheat\deluxeveinminer\command\subcommands;

use frostcheat\deluxeveinminer\command\SubCommandInterface;
use frostcheat\deluxeveinminer\command\VeinMinerCommand;
use frostcheat\deluxeveinminer\Loader;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class ReloadSubCommand implements SubCommandInterface {

    public function getName(): string {
        return "reload";
    }
    
    public function getDescription(): string {
        return "Reload the plugin configuration";
    }
    
    public function getUsage(): string {
        return "/deluxeveinminer reload";
    }
    
    public function getPermission(): ?string {
        return "deluxeveinminer.command.reload";
    }

    public function execute(VeinMinerCommand $parent, CommandSender $sender, array $args): bool {
        if (!$sender->hasPermission($this->getPermission())) {
            $sender->sendMessage(TextFormat::colorize("&cYou don't have permission to use this command."));
            return false;
        }
        
        Loader::getInstance()->reloadConfig();
        Loader::getInstance()->load();
        $sender->sendMessage(TextFormat::colorize("&aThe plugin configuration has been reloaded successfully."));
        return true;
    }
}