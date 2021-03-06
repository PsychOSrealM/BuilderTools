<?php

/**
 * Copyright 2018 CzechPMDevs
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace czechpmdevs\buildertools\commands;

use czechpmdevs\buildertools\BuilderTools;
use czechpmdevs\buildertools\editors\Canceller;
use czechpmdevs\buildertools\editors\Editor;
use czechpmdevs\buildertools\editors\object\EditorResult;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

/**
 * Class UndoCommand
 * @package buildertools\commands
 */
class RedoCommand extends Command implements PluginIdentifiableCommand {

    /**
     * UndoCommand constructor.
     */
    public function __construct() {
        parent::__construct("/redo", "Redo last BuilderTools actions", null, []);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return mixed|void
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender instanceof Player) {
            $sender->sendMessage("§cThis command can be used only in-game!");
            return;
        }
        if(!$sender->hasPermission("bt.cmd.undo")) {
            $sender->sendMessage("§cYou do not have permissions to use this command!");
            return;
        }

        /** @var Canceller $canceller */
        $canceller = BuilderTools::getEditor(Editor::CANCELLER);

        /** @var EditorResult $result */
        $result = $canceller->redo($sender);

        if(!$result->error) $sender->sendMessage(BuilderTools::getPrefix()."§aUndo was cancelled!");
    }

    /**
     * @return Plugin&BuilderTools
     */
    public function getPlugin(): Plugin {
        return BuilderTools::getInstance();
    }
}
