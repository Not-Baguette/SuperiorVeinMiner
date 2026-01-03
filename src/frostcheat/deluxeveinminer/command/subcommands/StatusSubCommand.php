<?php

namespace frostcheat\deluxeveinminer\command\subcommands;

use frostcheat\deluxeveinminer\command\SubCommandInterface;
use frostcheat\deluxeveinminer\command\VeinMinerCommand;
use frostcheat\deluxeveinminer\Loader;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class StatusSubCommand implements SubCommandInterface {

    public function getName(): string {
        return "status";
    }
    
    public function getDescription(): string {
        return "Show plugin status and configuration info";
    }
    
    public function getUsage(): string {
        return "/deluxeveinminer status";
    }
    
    public function getPermission(): ?string {
        return "deluxeveinminer.command.status";
    }

    public function execute(VeinMinerCommand $parent, CommandSender $sender, array $args): bool {
        if (!$sender->hasPermission($this->getPermission())) {
            $sender->sendMessage(TextFormat::colorize("&cYou don't have permission to use this command."));
            return false;
        }
        
        $loader = Loader::getInstance();
        
        $sender->sendMessage(TextFormat::colorize("&b=== DeluxeVeinMiner Status ==="));
        $sender->sendMessage(TextFormat::colorize("&aMax blocks per vein: &e" . $loader->getMaxBlocks()));
        $sender->sendMessage(TextFormat::colorize("&aShift to disable: " . ($loader->shiftToDisable ? "&aEnabled" : "&cDisabled")));
        $sender->sendMessage(TextFormat::colorize("&aRequire tool: " . ($loader->requireTool ? "&aEnabled" : "&cDisabled")));
        $sender->sendMessage(TextFormat::colorize("&aWhitelisted blocks: &e" . count($loader->whitelistedBlocks)));
        $sender->sendMessage(TextFormat::colorize("&aBlacklisted blocks: &e" . count($loader->blacklistBlocks)));
        $sender->sendMessage(TextFormat::colorize("&aBlacklisted worlds: &e" . count($loader->worlds)));
        
        if (count($loader->whitelistedBlocks) > 0) {
            $sender->sendMessage(TextFormat::colorize("&6Whitelisted: &f" . 
                implode(", ", array_map(fn($block) => $block->getName(), $loader->whitelistedBlocks))));
        }
        
        if (count($loader->blacklistBlocks) > 0) {
            $sender->sendMessage(TextFormat::colorize("&cBlacklisted blocks: &f" . 
                implode(", ", $loader->blacklistBlocks)));
        }
        
        if (count($loader->worlds) > 0) {
            $sender->sendMessage(TextFormat::colorize("&cBlacklisted worlds: &f" . 
                implode(", ", $loader->worlds)));
        }
        
        return true;
    }
}