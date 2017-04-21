SignPortal
==========

SignPortal is used to create portals to other worlds using signs.

PocketMine-MP multiworld sign portal
Supports PocketMine 1.6.2dev

## Configuration
No Configuration as of this update

## Usage
Create a sign with the format below

```
[WORLD]
<worldname>
 ```
 
 An example for teleporting the the world 'testworld' would be:
 ```
 [WORLD]
 testworld
 ```
 
The rest of the sign can be whatever desired

##Features:

signportal.create permission to create world signs

signportal.command.generate permission to use /generate

Checks for existing world on teleport attempt to prevent crashes

Loads world on teleport attempt

Simple portal creation without need for config or database files

/generate command for world generation

World existence test - fixes most crashes

##Installation:

Drop the plugin into the plugins/ folder
Restart the server