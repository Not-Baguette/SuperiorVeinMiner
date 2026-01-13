<h1 align="center">📦 SuperiorVeinMiner - A fork of DeluxeVeinMiner</h1>
<p align="center">SuperiorVeinMiner allows players to mine entire veins of minerals or connected blocks by simply breaking a single one.</p>

---

## 🌟 Features

- Automatically mines all connected ores of the same type.
- Compatible with enchantments like **Fortune** and **Unbreaking**.
- Applies durability loss correctly and respects tool compatibility.
- Drops all ores at the first block broken.
- Ignores world and block blacklists.
- Fast, recursive vein-mining logic with a configurable block limit (default: 64).
- Easy configuration and live command-based control.
- Java-like vein-mining experience for PocketMine-MP servers.

---

## 📜 Commands

| Command                                     | Description                                    | Permission                                |
| ------------------------------------------- | ---------------------------------------------- | ----------------------------------------- |
| `/deluxeveinminer addblock <block>`         | Add a block to the block blacklist            | `deluxeveinminer.command.add.block`       |
| `/deluxeveinminer removeblock <block>`      | Remove a block from the block blacklist       | `deluxeveinminer.command.remove.block`    |
| `/deluxeveinminer addwhitelist <block>`     | Add a block to the whitelist                  | `deluxeveinminer.command.add.whitelist`   |
| `/deluxeveinminer removewhitelist <block>`  | Remove a block from the whitelist             | `deluxeveinminer.command.remove.whitelist`|
| `/deluxeveinminer addworld <world>`         | Add a world to the world blacklist            | `deluxeveinminer.command.add.world`       |
| `/deluxeveinminer removeworld <world>`      | Remove a world from the world blacklist       | `deluxeveinminer.command.remove.world`    |
| `/deluxeveinminer setmaxblocks <number>`    | Set maximum blocks per vein (1-1000)          | `deluxeveinminer.command.setmaxblocks`    |
| `/deluxeveinminer toggle <option>`          | Toggle features (shift-disable, require-tool) | `deluxeveinminer.command.toggle`          |
| `/deluxeveinminer status`                   | Show current plugin configuration             | `deluxeveinminer.command.status`          |
| `/deluxeveinminer reload`                   | Reload the plugin configuration               | `deluxeveinminer.command.reload`          |
| `/deluxeveinminer help`                     | Show all available commands                   | `deluxeveinminer.command.help`            |

---

## 🧱 Supported Software

> ✅ This plugin is only compatible with **PocketMine-MP**  
> ❌ It will NOT work on Nukkit, Altay, or other forks

---

## 📥 Installation

1. 📦 [Download SuperiorVeinMiner](https://github.com/Not-Baguette/DeluxeVeinMiner/releases/latest) from Poggit
2. 📁 Place the `.phar` files inside your `/plugins/` directory
3. 🔁 Restart your server

---

## ⚙️ Todo
- [x] Commands for whitelist management
- [ ] config.yml backwards compatibility
- [x] Shift to stop veinmining temporarily
- [x] Disable veinmining with barehands

---

## 📖 License

Licensed under the [MIT License](https://github.com/FrostCheatMC/DeluxeVeinMiner/blob/master/LICENSE)
You are free to fork, contribute, or suggest changes.

---

## ☕ Support & Donate

If you would like to give your thanks:

> 💖 [Donate via PayPal](https://paypal.me/notnotbagu)

Any support is greatly appreciated! Also shout out to the original creator [FrostCheat](https://github.com/FrostCheat/DeluxeVeinMiner)!

---

<p align="center"><b>Made with 💙 by FrostCheatMC | Forked by 🥖 Baguette</b></p>
