<?php

namespace frostcheat\deluxeveinminer\command\subcommands;

use frostcheat\deluxeveinminer\command\SubCommandInterface;
use frostcheat\deluxeveinminer\command\VeinMinerCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class HelpSubCommand implements SubCommandInterface {

    public function __construct(private array $subCommands) {}
    
    public function getName(): string {
        return "help";
    }
    
    public function getDescription(): string {
        return "Show help for DeluxeVeinMiner commands";
    }
    
    public function getUsage(): string {
        return "/deluxeveinminer help";
    }
    
    public function getPermission(): ?string {
        return "deluxeveinminer.command.help";
    }

    public function execute(VeinMinerCommand $parent, CommandSender $sender, array $args): bool {
        if (!$sender->hasPermission($this->getPermission())) {
            $sender->sendMessage(TextFormat::colorize("&cYou don't have permission to use this command."));
            return false;
        }
        
        $sender->sendMessage(TextFormat::colorize("&b=== DeluxeVeinMiner Help ==="));
        
        foreach ($this->subCommands as $subCommand) {
            if ($subCommand instanceof SubCommandInterface && $subCommand->getName() !== "help") {
                $sender->sendMessage(TextFormat::colorize("&b" . $subCommand->getUsage() . " &f- &7" . $subCommand->getDescription()));
            }
        }
        
        return true;
    }
}