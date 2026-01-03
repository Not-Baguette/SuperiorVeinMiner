<?php

namespace frostcheat\deluxeveinminer\command\subcommands;

use frostcheat\deluxeveinminer\command\SubCommandInterface;
use frostcheat\deluxeveinminer\command\VeinMinerCommand;
use frostcheat\deluxeveinminer\Loader;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class SetMaxBlocksSubCommand implements SubCommandInterface {

    public function getName(): string {
        return "setmaxblocks";
    }
    
    public function getDescription(): string {
        return "Set the maximum blocks that can be mined at once";
    }
    
    public function getUsage(): string {
        return "/deluxeveinminer setmaxblocks <number>";
    }
    
    public function getPermission(): ?string {
        return "deluxeveinminer.command.setmaxblocks";
    }

    public function execute(VeinMinerCommand $parent, CommandSender $sender, array $args): bool {
        if (!$sender->hasPermission($this->getPermission())) {
            $sender->sendMessage(TextFormat::colorize("&cYou don't have permission to use this command."));
            return false;
        }
        
        if (count($args) === 0) {
            $current = Loader::getInstance()->getMaxBlocks();
            $sender->sendMessage(TextFormat::colorize("&aCurrent max blocks: &e$current"));
            $sender->sendMessage(TextFormat::colorize("&cUsage: " . $this->getUsage()));
            return false;
        }
        
        $maxBlocks = (int) $args[0];
        
        if ($maxBlocks < 1) {
            $sender->sendMessage(TextFormat::colorize("&cMax blocks must be at least 1."));
            return false;
        }
        
        if ($maxBlocks > 1000) {
            $sender->sendMessage(TextFormat::colorize("&cMax blocks cannot exceed 1000 for performance reasons."));
            return false;
        }
        
        Loader::getInstance()->setMaxBlocks($maxBlocks);
        Loader::getInstance()->save();
        
        $sender->sendMessage(TextFormat::colorize("&aMax blocks set to &e$maxBlocks&a."));
        return true;
    }
}