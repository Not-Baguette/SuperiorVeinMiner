<?php

namespace frostcheat\deluxeveinminer\command\subcommands;

use frostcheat\deluxeveinminer\command\SubCommandInterface;
use frostcheat\deluxeveinminer\command\VeinMinerCommand;
use frostcheat\deluxeveinminer\Loader;
use pocketmine\command\CommandSender;
use pocketmine\item\StringToItemParser;
use pocketmine\utils\TextFormat;

class RemoveBlockSubCommand implements SubCommandInterface {

    public function getName(): string {
        return "removeblock";
    }
    
    public function getDescription(): string {
        return "Remove a block from the block blacklist";
    }
    
    public function getUsage(): string {
        return "/deluxeveinminer removeblock <block_name>";
    }
    
    public function getPermission(): ?string {
        return "deluxeveinminer.command.remove.block";
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
        
        $blockName = strtolower(implode(" ", $args));
        
        // try to get the block from string
        $item = StringToItemParser::getInstance()->parse($blockName);
        if ($item === null) {
            $sender->sendMessage(TextFormat::colorize("&cInvalid block: $blockName"));
            return false;
        }
        
        $block = $item->getBlock();
        $actualBlockName = strtolower($block->getName());

        if (!in_array($actualBlockName, Loader::getInstance()->blacklistBlocks)) {
            $sender->sendMessage(TextFormat::colorize("&cThis block is not on the blacklist."));
            return false;
        }

        $index = array_search($actualBlockName, Loader::getInstance()->blacklistBlocks, true);
        if ($index !== false) {
            unset(Loader::getInstance()->blacklistBlocks[$index]);
            Loader::getInstance()->blacklistBlocks = array_values(Loader::getInstance()->blacklistBlocks); // Reindexar el array
            Loader::getInstance()->save();
            $sender->sendMessage(TextFormat::colorize("&aThe block &e$actualBlockName&a has been successfully removed from the blacklist."));
        } else {
            $sender->sendMessage(TextFormat::colorize("&cUnexpected error: block not found in blacklist."));
        }
        return true;
    }
}