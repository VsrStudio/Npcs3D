<?php

namespace VsrStudio\Npcs3D;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\entity\Skin;
use pocketmine\network\mcpe\protocol\AnimateEntityPacket;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerChangeSkinEvent;

use VsrStudio\Npcs3D\Form\SimpleForm;

class Main extends PluginBase implements Listener {

    private array $skin = [];

    public function onEnable(): void {
        $map = $this->getDescription()->getMap();
        $ver = $this->getDescription()->getVersion();

        if (isset($map["author"])) {
            if ($map["author"] !== "VsrStudio" or $ver !== "1.0.0") {
                $this->getLogger()->emergency("§cPlugin info has been changed, please give the author the proper credits, set the author to \"VsrStudio\" and set the version to \"1.0.0\" if required, or else the server will shutdown on every start-up");
                $this->getServer()->shutdown();
                return;
            }
        } else {
            $this->getLogger()->emergency("§cPlugin info has been changed, please give the author the proper credits, set the author to \"xXKHaLeD098Xx, VsrStudio\" and set the version to \"3.0-beta\" if required, or else the server will shutdown on every start-up");
            $this->getServer()->shutdown();
        }
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        foreach (["kill_effect_preview.geo.json", "kill_effect_preview.png", "battlearena.duels.geometry.json", "battlearena.duels.texture.png", "battlearena.ffa.geometry.json", "battlearena.ffa.texture.png", "battlearena.gameduels.geometry.json", "battlearena.gameduels.texture.png", "bedwars.teams4.geometry.json", "bedwars.teams4.texture.png", "betagames.geometry.json", "betagames.texture.png", "blockwars.bridges.duels.json", "blockwars.bridges.duels.texture.png", "blockwars.bridges.geometry.json", "blockwars.bridges.texture.png", "blockwars.ctf.duels.geometry.json", "blockwars.ctf.duels.texture.png", "blockwars.ctf.geometry.json", "blockwars.ctf.texture.png", "blockwars.giga.geometry.json", "blockwars.giga.texture.png", "colonycontrol.geometry.json", "colonycontrol.texture.png", "eggwars.duels.geometry.json", "eggwars.duels.texture.png", "eggwars.duos.geometry.json", "eggwars.duos.texture.png", "eggwars.mega.geometry.json", "eggwars.mega.texture.png", "eggwars.solo.geometry.json", "eggwars.solo.texture.png", "eggwars.teams4.geometry.json", "eggwars.teams4.texture.png", "luckyblocks.duels.geometry.json", "luckyblocks.duels.texture.png", "luckyblocks.solo.geometry.json", "luckyblocks.solo.texture.png", "luckyblocks.teams4.geometry.json", "luckyblocks.teams4.texture.png", "minerware.geometry.json", "minerware.texture.png", "parkour_competitive_npc.png", "parkour_competitive_npc_geometry.json", "parkour_regular_npc.png", "parkour_regular_npc_geometry.json", "pillars_of_fortune.geometry.json", "pillars_of_fortune.texture.png", "presentrush.geometry.json", "presentrush.texture.png", "skyblock.geometry.json", "skyblock.texture.png", "skywars.chaos.geometry.json", "skywars.chaos.texture.png", "skywars.duels.geometry.json", "skywars.duels.texture.png", "skywars.duos.geometry.json", "skywars.duos.texture.png", "skywars.mega.geometry.json", "skywars.mega.texture.png", "skywars.solo.geometry.json", "skywars.solo.texture.png", "skywars.team4.geometry.json", "skywars.team4.texture.png", "snowman.geometry.json", "snowman.texture.png", "survivalgames.duos.geometry.json", "survivalgames.duos.texture.png", "survivalgames.solo.geometry.json", "survivalgames.solo.texture.png", "wintergames.geometry.json", "wintergames.texture.png"] as $file) {
            $this->saveResource($file);
        }
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "npcs") {
            if ($sender instanceof Player) {
                $this->Npcs3D($sender);
                return true;
            } else {
                $sender->sendMessage("Please use this command in-game.");
                return true;
            }
        }
        return false;
    }

    public function Npcs3D(Player $p): void {
        $form = new SimpleForm(function (Player $p, ?int $data = null) {
            if ($data === null) {
                return;
            }
            switch ($data) {
                case 0:
                    $p->setSkin($this->skin[$p->getName()]);
                    $p->sendSkin();
                    $p->sendMessage("§eSuccessfully reset skin.");
                    break;
                case 1:
    if ($p->hasPermission("duel.skin")) {
        $skin = new Skin(
            $p->getSkin()->getSkinId(),
            $this->encodeSkin($this->getDataFolder() . "kill_effect_preview.png"),
            "",
            "geometry.cubecraft.kill_effect_preview",
            file_get_contents($this->getDataFolder() . "kill_effect_preview.geo.json")
        );
        $p->setSkin($skin);
        $p->sendSkin();

        $packet = AnimateEntityPacket::create(
            "animation.cubecraft.kill_effect_preview.kill",
            "geometry.cubecraft.kill_effect_preview",
            "",
            0,
            "default.controller",
            1.0,
            [$p->getId()]
        );
        $p->getNetworkSession()->sendDataPacket($packet);

        $p->sendMessage("§aSuccessfully changed to skin with animation.");
    } else {
        $p->sendMessage("§cYou do not have permission.");
    }
    break;
                case 2:
                    if ($p->hasPermission("bad.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "battlearena.duels.texture.png"), "", "geometry.cubecraft.npc.battlearena.duels", file_get_contents($this->getDataFolder() . "battlearena.duels.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 3:
                    if ($p->hasPermission("baf.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "battlearena.ffa.texture.png"), "", "geometry.cubecraft.npc.battlearena.ffa", file_get_contents($this->getDataFolder() . "battlearena.ffa.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 4:
                    if ($p->hasPermission("bag.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "battlearena.gameduels.texture.png"), "", "geometry.cubecraft.npc.battlearena.gameduels", file_get_contents($this->getDataFolder() . "battlearena.gameduels.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 5:
                    if ($p->hasPermission("bwt.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "bedwars.teams4.texture.png"), "", "geometry.cubecraft.npc.bedwars.team4", file_get_contents($this->getDataFolder() . "bedwars.teams4.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 6:
                    if ($p->hasPermission("bg.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "betagames.texture.png"), "", "geometry.cubecraft.npc.betagames", file_get_contents($this->getDataFolder() . "betagames.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 7:
                    if ($p->hasPermission("bwbd.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "blockwars.bridges.duels.texture.png"), "", "geometry.cubecraft.npc.blockwars.bridges.duels", file_get_contents($this->getDataFolder() . "blockwars.bridges.duels.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 8:
                    if ($p->hasPermission("bwb.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "blockwars.bridges.texture.png"), "", "geometry.cubecraft.npc.blockwars.bridges", file_get_contents($this->getDataFolder() . "blockwars.bridges.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 9:
                    if ($p->hasPermission("bwcd.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "blockwars.ctf.duels.texture.png"), "", "geometry.cubecraft.npc.blockwars.ctf.duels", file_get_contents($this->getDataFolder() . "blockwars.ctf.duels.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 10:
                    if ($p->hasPermission("bwc.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "blockwars.ctf.texture.png"), "", "geometry.cubecraft.npc.blockwars.ctf", file_get_contents($this->getDataFolder() . "blockwars.ctf.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 11:
                    if ($p->hasPermission("bwg.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "blockwars.giga.texture.png"), "", "geometry.cubecraft.npc.blockwars.giga", file_get_contents($this->getDataFolder() . "blockwars.giga.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 12:
                    if ($p->hasPermission("cc.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "colonycontrol.texture.png"), "", "geometry.cubecraft.npc.colonycontrol", file_get_contents($this->getDataFolder() . "colonycontrol.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 13:
                    if ($p->hasPermission("s1.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "eggwars.duels.texture.png"), "", "geometry.cubecraft.npc.eggwars.duels", file_get_contents($this->getDataFolder() . "eggwars.duels.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 14:
                    if ($p->hasPermission("s2.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "eggwars.duos.texture.png"), "", "geometry.cubecraft.npc.eggwars.duos", file_get_contents($this->getDataFolder() . "eggwars.duos.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 15:
                    if ($p->hasPermission("s3.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "eggwars.mega.texture.png"), "", "geometry.cubecraft.npc.eggwars.mega", file_get_contents($this->getDataFolder() . "eggwars.mega.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 16:
                    if ($p->hasPermission("s4.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "eggwars.solo.texture.png"), "", "geometry.cubecraft.npc.eggwars.solo", file_get_contents($this->getDataFolder() . "eggwars.solo.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 17:
                    if ($p->hasPermission("s5.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "eggwars.teams4.texture.png"), "", "geometry.cubecraft.npc.eggwars.team4", file_get_contents($this->getDataFolder() . "eggwars.teams4.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 18:
                    if ($p->hasPermission("s6.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "luckyblocks.duels.texture.png"), "", "geometry.cubecraft.npc.luckyblock.duels", file_get_contents($this->getDataFolder() . "luckyblocks.duels.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 19:
                    if ($p->hasPermission("s7.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "luckyblocks.solo.texture.png"), "", "geometry.cubecraft.npc.luckyblocks.solo", file_get_contents($this->getDataFolder() . "luckyblocks.solo.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 20:
                    if ($p->hasPermission("s8.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "luckyblocks.teams4.texture.png"), "", "geometry.cubecraft.npc.luckyblocks.teams4", file_get_contents($this->getDataFolder() . "luckyblocks.teams4.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 21:
                    if ($p->hasPermission("s9.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "minerware.texture.png"), "", "geometry.cubecraft.npc.minerware", file_get_contents($this->getDataFolder() . "minerware.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 22:
                    if ($p->hasPermission("s10.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "parkour_competitive_npc.png"), "", "geometry.cubecraft.lobby.parkour.competitive.npc", file_get_contents($this->getDataFolder() . "parkour_competitive_npc_geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 23:
                    if ($p->hasPermission("s11.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "parkour_regular_npc.png"), "", "geometry.cubecraft.lobby.parkour.regular.npc", file_get_contents($this->getDataFolder() . "parkour_regular_npc_geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 24:
                    if ($p->hasPermission("s12.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "pillars_of_fortune.texture.png"), "", "geometry.cubecraft.npc.pillars_of_fortune", file_get_contents($this->getDataFolder() . "pillars_of_fortune.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 25:
                    if ($p->hasPermission("s13.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "presentrush.texture.png"), "", "geometry.cubecraft.npc.presentrush", file_get_contents($this->getDataFolder() . "presentrush.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 26:
                    if ($p->hasPermission("s14.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "skyblock.texture.png"), "", "geometry.cubecraft.npc.skyblock", file_get_contents($this->getDataFolder() . "skyblock.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 27:
                    if ($p->hasPermission("s15.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "skywars.chaos.texture.png"), "", "geometry.cubecraft.npc.skywars.chaos", file_get_contents($this->getDataFolder() . "skywars.chaos.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 28:
                    if ($p->hasPermission("s16.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "skywars.duels.texture.png"), "", "geometry.cubecraft.npc.skywars.duels", file_get_contents($this->getDataFolder() . "skywars.duels.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 29:
                    if ($p->hasPermission("s17.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "skywars.duos.texture.png"), "", "geometry.cubecraft.npc.skywars.duos", file_get_contents($this->getDataFolder() . "skywars.duos.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 30:
                    if ($p->hasPermission("s18.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "skywars.mega.texture.png"), "", "geometry.cubecraft.npc.skywars.mega", file_get_contents($this->getDataFolder() . "skywars.mega.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 31:
                    if ($p->hasPermission("s19.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "skywars.solo.texture.png"), "", "geometry.cubecraft.npc.skywars.solo", file_get_contents($this->getDataFolder() . "skywars.solo.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 32:
                    if ($p->hasPermission("s20.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "skywars.team4.texture.png"), "", "geometry.cubecraft.npc.skywars.team4", file_get_contents($this->getDataFolder() . "skywars.team4.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 33:
                    if ($p->hasPermission("s21.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "snowman.texture.png"), "", "geometry.cubecraft.snowman", file_get_contents($this->getDataFolder() . "snowman.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 34:
                    if ($p->hasPermission("s22.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "survivalgames.duos.texture.png"), "", "geometry.cubecraft.npc.survivalgames.duos", file_get_contents($this->getDataFolder() . "survivalgames.duos.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 35:
                    if ($p->hasPermission("s23.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "survivalgames.solo.texture.png"), "", "geometry.cubecraft.npc.survivalgames.solo", file_get_contents($this->getDataFolder() . "survivalgames.solo.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
                case 36:
                    if ($p->hasPermission("s24.skin")) {
                        $p->setSkin(new Skin($p->getSkin()->getSkinId(), $this->encodeSkin($this->getDataFolder() . "wintergames.texture.png"), "", "geometry.cubecraft.npc.wintergames", file_get_contents($this->getDataFolder() . "wintergames.geometry.json")));
                        $p->sendSkin();
                        $p->sendMessage("§aSuccessfully changed to skin");
                    } else {
                        $p->sendMessage("§cYou do not have permission.");
                    }
                    break;
            }
        });
        $form->setTitle("§l§bNpc3DCubeCraft");
        $form->addButton("§l§cReset Skin\n§rtap to reset");
        $form->addButton("§l§eDuels\n§bDuo");
        $form->addButton("§l§eBattleArena\n§bDuels");
        $form->addButton("§l§eBattleArena\n§bFFa");
        $form->addButton("§l§eBattleArena\n§bGameDuels");
        $form->addButton("§l§eBedWars\n§bTeams4");
        $form->addButton("§l§eBetaGames\n§bOnlyOne");
        $form->addButton("§l§eBlockwars\n§bBridgeDuels");
        $form->addButton("§l§eBlockwars\n§bBridge");
        $form->addButton("§l§eBlockwars\n§bCtfDuels");
        $form->addButton("§l§eBlockwars\n§bCtf");
        $form->addButton("§l§eBlockwars\n§bGiga");
        $form->addButton("§l§eColonyControl\n§bOnlyOne");
        $form->addButton("§l§eEggWars\n§bDuels");
        $form->addButton("§l§eEggWars\n§bDuos");
        $form->addButton("§l§eEggWars\n§bMega");
        $form->addButton("§l§eEggWars\n§bSolo");
        $form->addButton("§l§eEggWars\n§bTeams4");
        $form->addButton("§l§eLuckyBlock\n§bDuels");
        $form->addButton("§l§eLuckyBlock\n§bSolo");
        $form->addButton("§l§eLuckyBlock\n§bTeams4");
        $form->addButton("§l§eMineWare\n§bOnlyOne");
        $form->addButton("§l§eParkour\n§bCompetitive");
        $form->addButton("§l§eParkour\n§bRegular");
        $form->addButton("§l§ePillarOfFortune\n§bOnlyOne");
        $form->addButton("§l§ePresentrush\n§bOnlyOne");
        $form->addButton("§l§eSkyBlock\n§bOnlyOne");
        $form->addButton("§l§eSkyWars\n§bChaos");
        $form->addButton("§l§eSkyWars\n§bDuels");
        $form->addButton("§l§eSkyWars\n§bDuos");
        $form->addButton("§l§eSkyWars\n§bMega");
        $form->addButton("§l§eSkyWars\n§bSolo");
        $form->addButton("§l§eSkyWars\n§bTeams4");
        $form->addButton("§l§eSnowMan\n§bOnlyOne");
        $form->addButton("§l§eSurvivalGame\n§bDuos");
        $form->addButton("§l§eSurvivalGame\n§bSolo");
        $form->addButton("§l§eWinterGame\n§bOnlyOne");
        $form->sendToPlayer($p);
    }

    public function encodeSkin(string $path): string {
        $size = getimagesize($path);
        $img = @imagecreatefrompng($path);
        $skinbytes = "";
        for ($y = 0; $y < $size[1]; $y++) {
            for ($x = 0; $x < $size[0]; $x++) {
                $colorat = @imagecolorat($img, $x, $y);
                $a = ((~((int)($colorat >> 24))) << 1) & 0xff;
                $r = ($colorat >> 16) & 0xff;
                $g = ($colorat >> 8) & 0xff;
                $b = $colorat & 0xff;
                $skinbytes .= chr($r) . chr($g) . chr($b) . chr($a);
            }
        }
        @imagedestroy($img);
        return $skinbytes;
    }

    public function onPlayerJoin(PlayerJoinEvent $e): void {
        $p = $e->getPlayer();
        $this->skin[$p->getName()] = $p->getSkin();
    }

    public function onPlayerQuit(PlayerQuitEvent $e): void {
        $p = $e->getPlayer();
        unset($this->skin[$p->getName()]);
    }

    public function onPlayerChangeSkin(PlayerChangeSkinEvent $e): void {
        $p = $e->getPlayer();
        $this->skin[$p->getName()] = $p->getSkin();
    }
}
