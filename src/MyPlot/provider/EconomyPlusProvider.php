<?php
declare(strict_types=1);
namespace MyPlot\provider;

use ImagicalGamer\EconomyPlus\Main;

use pocketmine\Player;

class EconomyPlusProvider implements EconomyProvider
{
	/** @var Main $plugin */
	public $plugin;

	/**
	 * EconomyPlusProvider constructor.
	 *
	 * @param Main $plugin
	 */
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}

	/**
	 * @param Player $player
	 * @param float $amount
	 * @return bool
	 */
	public function reduceMoney(Player $player, float $amount) : bool {
		if ($amount === 0) {
			return true;
		} elseif ($amount < 0) {
			$amount = -$amount;
		}
		if($this->plugin->myMoney($player) - $amount < 0) {
			$this->plugin->getLogger()->debug("MyPlot failed to reduce money of ".$player->getName());
			return false;
		}
		$this->plugin->subtractMoney($player, $amount);
		$this->plugin->getLogger()->debug("MyPlot reduced money of ".$player->getName());
		return true;
	}
}