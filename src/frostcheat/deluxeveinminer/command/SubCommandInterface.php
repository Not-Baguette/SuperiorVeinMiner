<?php

namespace frostcheat\deluxeveinminer\command;

use pocketmine\command\CommandSender;

interface SubCommandInterface {
    
    /**
     * Execute the subcommand
     * @param VeinMinerCommand $parent
     * @param CommandSender $sender
     * @param array $args
     * @return bool
     */
    public function execute(VeinMinerCommand $parent, CommandSender $sender, array $args): bool;
    
    /**
     * Get the name of the subcommand
     * @return string
     */
    public function getName(): string;
    
    /**
     * Get the description of the subcommand
     * @return string
     */
    public function getDescription(): string;
    
    /**
     * Get the usage string for the subcommand
     * @return string
     */
    public function getUsage(): string;
    
    /**
     * Get the permission required to use this subcommand
     * @return string|null
     */
    public function getPermission(): ?string;
}