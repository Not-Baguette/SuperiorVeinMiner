<?php

declare(strict_types=1);

namespace frostcheat\deluxeveinminer;

use frostcheat\deluxeveinminer\command\VeinMinerCommand;
use pocketmine\item\StringToItemParser;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Loader extends PluginBase {
    use SingletonTrait;

    public const CONFIG_VERSION = 1;
    
    public array $worlds = [];
    public array $blacklistBlocks = [];
    public array $whitelistedBlocks = [];
    public int $maxBlocks = 64;
    public bool $shiftToDisable = true;
    public bool $requireTool = true;

    public function onLoad(): void {
        self::setInstance($this);
    }

    public function onEnable(): void {
        $configVersion = $this->getConfig()->get("config-version", 0);
        if ($configVersion < self::CONFIG_VERSION) {
            $this->getLogger()->info("Config version outdated. Consider updating your config.yml");
        }

        $this->load();
        $this->getServer()->getCommandMap()->register("deluxeveinminer", new VeinMinerCommand($this));
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }

    public function load(): void {
        $this->worlds = [];
        $this->blacklistBlocks = [];
        $this->whitelistedBlocks = []; // reset before loading

        $config = $this->getConfig();

        // load bunch of config stuff
        $this->maxBlocks = (int) $config->get("max-blocks", 64);
        $this->shiftToDisable = (bool) $config->get("shift-to-disable", true);
        $this->requireTool = (bool) $config->get("require-tool", true);

        foreach($config->get("blacklisted-worlds", []) as $worldName) {
            $this->worlds[] = strtolower($worldName);
        }

        foreach($config->get("blacklisted-ores", []) as $blockName) {
            $this->blacklistBlocks[] = strtolower($blockName);
        }

        $whitelistedOres = $config->get("whitelisted-ores", []);
        
        foreach ($whitelistedOres as $stringName) {
            // I hope this isnt going to cause bunch of chaos
            $item = StringToItemParser::getInstance()->parse($stringName);

            if ($item !== null) {
                $block = $item->getBlock();
                $blockName = strtolower($block->getName());
                
                // add ONLY if it's not blacklisted (blacklist overrides whitelist)
                if (!in_array($blockName, $this->blacklistBlocks)) {
                    $this->whitelistedBlocks[] = $block;
                } else {
                    $this->getLogger()->info("Block '$stringName' is whitelisted but overridden by blacklist");
                }
            } else {
                // warn if a typo exists in config so the admin can fix it
                $this->getLogger()->warning("Configuration error: Could not identify block named '$stringName'");
            }
        }
        
        $this->getLogger()->info("Loaded " . count($this->whitelistedBlocks) . " whitelisted blocks, " . 
                                count($this->blacklistBlocks) . " blacklisted blocks, " . 
                                count($this->worlds) . " blacklisted worlds. Max blocks: " . $this->maxBlocks);
    }

    public function save(): void {
        $config = $this->getConfig();
        $config->set("blacklisted-worlds", $this->worlds);
        $config->set("blacklisted-ores", $this->blacklistBlocks);
        $config->set("max-blocks", $this->maxBlocks);
        $config->set("shift-to-disable", $this->shiftToDisable);
        $config->set("require-tool", $this->requireTool);
        
        // convert blocks back to string names for saving
        $blockNames = array_map(fn($block) => strtolower($block->getName()), $this->whitelistedBlocks);
        $config->set("whitelisted-ores", $blockNames); 

        $config->save();
    }

    // return array from load()
    public function getOres(): array {
        return $this->whitelistedBlocks;
    }
    
    public function getMaxBlocks(): int {
        return $this->maxBlocks;
    }
    
    public function setMaxBlocks(int $maxBlocks): void {
        $this->maxBlocks = $maxBlocks;
    }
    
    public function isBlockWhitelisted(string $blockName): bool {
        $blockName = strtolower($blockName);
        foreach ($this->whitelistedBlocks as $block) {
            if (strtolower($block->getName()) === $blockName) {
                return true;
            }
        }
        return false;
    }
    
    public function isBlockBlacklisted(string $blockName): bool {
        $blockName = strtolower($blockName);
        return in_array($blockName, $this->blacklistBlocks);
    }
    
    public function isWorldBlacklisted(string $worldName): bool {
        return in_array(strtolower($worldName), $this->worlds);
    }
}