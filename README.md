SignPortal v1.1.1
==========

PocketMine-MP multiworld sign portal
Supports PocketMine 1.6.2dev
Stripped down version of previous plugin due to incompleteness of API

## Configuration
No Configuration as of this update

## Usage
Create a sign with the format below

```
 - [WORLD]
 - <worldname>
 ```
 
The rest of the sign can be whatever desired

SignPortal is used to create portals to other worlds using signs.

##Features:

Checks for existing world on teleport attempt to prevent crashes

Loads world on teleport attempt

Simple portal creation without need for config or database files

/generate command for world generation

World existence test - fixes most crashes

##Installation:

Drop the plugin into the plugins/ folder
Restart the server

Usage:
Follow the sign format below to create a portal:
```
[WORLD]
<worldname>
```
An example for teleporting the the world 'testworld' would be:
```
[WORLD]
testworld
```

The rest of the sign can be used as desired

The /generate command is for testing only, tread carefully
