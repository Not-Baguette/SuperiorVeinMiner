<?php

namespace frostcheat\deluxeveinminer\command\subcommands;

use frostcheat\deluxeveinminer\command\SubCommandInterface;
use frostcheat\deluxeveinminer\command\VeinMinerCommand;
use frostcheat\deluxeveinminer\Loader;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class ToggleSubCommand implements SubCommandInterface {

    public function getName(): string {
        return "toggle";
    }
    
    public function getDescription(): string {
        return "Toggle vein mining features on/off";
    }
    
    public function getUsage(): string {
        return "/deluxeveinminer toggle <shift-disable|require-tool>";
    }
    
    public function getPermission(): ?string {
        return "deluxeveinminer.command.toggle";
    }

    public function execute(VeinMinerCommand $parent, CommandSender $sender, array $args): bool {
        if (!$sender->hasPermission($this->getPermission())) {
            $sender->sendMessage(TextFormat::colorize("&cYou don't have permission to use this command."));
            return false;
        }
        
        if (count($args) === 0) {
            $sender->sendMessage(TextFormat::colorize("&cUsage: " . $this->getUsage()));
            $sender->sendMessage(TextFormat::colorize("&eAvailable options:"));
            $sender->sendMessage(TextFormat::colorize("  &6shift-disable &f- Sneak to temporarily disable vein mining"));
            $sender->sendMessage(TextFormat::colorize("  &6require-tool &f- Require a tool (disable bare hands)"));
            return false;
        }
        
        $option = strtolower($args[0]);
        $loader = Loader::getInstance();
        
        switch ($option) {
            case "shift-disable":
            case "shift":
                $loader->shiftToDisable = !$loader->shiftToDisable;
                $status = $loader->shiftToDisable ? "&aenabled" : "&cdisabled";
                $sender->sendMessage(TextFormat::colorize("&aShift to disable is now $status&a."));
                break;
                
            case "require-tool":
            case "tool":
                $loader->requireTool = !$loader->requireTool;
                $status = $loader->requireTool ? "&aenabled" : "&cdisabled";
                $sender->sendMessage(TextFormat::colorize("&aRequire tool is now $status&a."));
                break;
                
            default:
                $sender->sendMessage(TextFormat::colorize("&cInvalid option: $option"));
                $sender->sendMessage(TextFormat::colorize("&eUse: shift-disable or require-tool"));
                return false;
        }
        
        $loader->save();
        return true;
    }
}