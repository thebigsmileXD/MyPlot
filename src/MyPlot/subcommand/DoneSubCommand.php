<?php
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class DoneSubCommand extends SubCommand {
	/**
	 * @param CommandSender $sender
	 * @return bool
	 */
	public  function canUse(CommandSender $sender) {
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.done");
	}

	/**
	 * @param Player $sender
	 * @param string[] $args
	 * @return bool
	 */
	public  function execute(CommandSender $sender, array $args) {
		$plot = $this->getPlugin()->getPlotByPosition($sender);
		if ($plot === null) {
			$sender->sendMessage(TextFormat::RED . $this->translateString("notinplot"));
			return true;
		}
		if ($plot->owner !== $sender->getName() and !$sender->hasPermission("myplot.admin.done")) {
			$sender->sendMessage(TextFormat::RED . $this->translateString("notowner"));
			return true;
		}
		if (isset($args[0]) and $args[0] == $this->translateString("confirm")) {
			if($this->getPlugin()->setPlotDone($plot, true)){
				$sender->sendMessage($this->translateString("done.success"));
			}else{
				$sender->sendMessage(TextFormat::RED . $this->translateString("error"));
			}
		} else {
			$plotId = TextFormat::GREEN . $plot . TextFormat::WHITE;
			$sender->sendMessage($this->translateString("done.confirm", [$plotId]));
		}
		return true;
	}
}