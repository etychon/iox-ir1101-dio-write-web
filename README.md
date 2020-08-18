# Introduction

Cisco [Industrial Router IR1101](https://www.cisco.com/c/en/us/td/docs/routers/access/1101/b_IR1101HIG/b_IR1101HIG_chapter_01.html) is a classic Cisco router, running [Cisco IOS-XE](https://www.cisco.com/c/en/us/products/ios-nx-os-software/ios-xe/index.html), and packaged as a rugged platform for industrial applications.

The Cisco IR1101 is fanless, DC powered, and offer a host of options such as Single and Dual LTE connections, GPS with external antenna, SSD hard disk for storing IOx applications, Digital IO ports, and more.

This project will leverage the Digital IO (or DIO) interface that is present on the SPMI module extension to tun on and off each of the 4 channel output. You can for example turn on lights, appliances, cooling, or any other equipment remotely from the Cisco IR1101.

There is a single Alarm port on the IR1101 chassis, but this is input only and therefore cannot be used to this purpose. If you are interested to read the port status (for example to detect if a door is open, or is a water level is too high) check [this other project on GitHub](https://github.com/etychon/iox-ir1101-dio-read).

For this project a Docker container will be build to control those four DIO channels, and we will be using using:
- a small PHP7 script to trigger outputs with a shell command,
- four nice toggle buttons with jQuery,
- Ajax will be used to call the PHP script (on the server side) from the jQuery interface (running javascript on the client side)

# Prerequisites

* You'll need a Cisco IR1101 with IRM-1100-SPMI expansion module.


* The SPMI port is shown below and must be connected [according to the documentation](https://www.cisco.com/c/en/us/td/docs/routers/access/1101/b_IR1101HIG/b_IR1101HIG_chapter_01.html#con_1232292). Port number 5 is the signal reference (typically positive) that will be send to individial ports when they are in high (1) state.
 <img align="right" src="images/ir1101-dio-layout.webp">
Because that state is triggered by a transistor and not a relay, only small charges can be controlled. For this project we have use a [cheap yet very efficient relay board](http://wiki.sunfounder.cc/index.php?title=4_Channel_5V_Relay_Module) from Sunfounder, Kuman, or other clones.

* Docker tooling installed on your developer machine. We have used a CentOS 8 Linux developer machine for this module, but anything else will be fine as long as you can use it. 

* `ioxclient` tooling installed on your developer machine, which [can be downloaded from here](https://developer.cisco.com/docs/iox/#!iox-resource-downloads).
