<?php

namespace frostcheat\deluxeveinminer\command\subcommands;

use frostcheat\deluxeveinminer\command\SubCommandInterface;
use frostcheat\deluxeveinminer\command\VeinMinerCommand;
use frostcheat\deluxeveinminer\Loader;
use pocketmine\block\VanillaBlocks;
use pocketmine\command\CommandSender;
use pocketmine\item\StringToItemParser;
use pocketmine\utils\TextFormat;

class AddBlockSubCommand implements SubCommandInterface {

    public function getName(): string {
        return "addblock";
    }
    
    public function getDescription(): string {
        return "Add a block to the block blacklist";
    }
    
    public function getUsage(): string {
        return "/deluxeveinminer addblock <block_name>";
    }
    
    public function getPermission(): ?string {
        return "deluxeveinminer.command.add.block";
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
        
        if (in_array($actualBlockName, Loader::getInstance()->blacklistBlocks)) {
            $sender->sendMessage(TextFormat::colorize("&cThis block is already blacklisted."));
            return false;
        }

        Loader::getInstance()->blacklistBlocks[] = $actualBlockName;
        Loader::getInstance()->save();

        $sender->sendMessage(TextFormat::colorize("&aThe block &e$actualBlockName&a has been successfully added to the blacklist."));
        return true;
    }
}