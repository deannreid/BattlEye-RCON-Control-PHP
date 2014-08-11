BattlEye-RCON-Control-PHP
=========================

These are scripts that are useful to control your DayZ Server if you don't have access to BEC for example Linux DS

First you need to install the correct packages on your server, 

If you are using a Distro that uses YUM then copy this

``` 
su -c yum update
su yum install php5 php5-cgi spawn-fcgi
```
I'm not entirely sure on which package is correct, it might pop up with an error on one of them :/

If you use a Distro that uses APT then copy this

```
sudo apt-get update
sudo apt-get upgrade
sudo apt-get install php5 php5-cgi

and if it moans then you can try

sudo apt-get install -f 
```

***

How to install

Edit the config.php to specify your servers IP,Port and Password, Battleye must be enabled for these to work.

then you can either use the crons I provide for a 3 hour restart or create your own All you need to do is change the location of the files 

***
```
Pre-Setup 4 Hour Restart Cron Jobs

10,30,50 0-1 * * * php -q /home/dayzservers/epochchernarus/Restart/resinf.php  #Restart Information
0 1,4,7,10,13,16,19,22 * * * php -q /home/dayzservers/epochchernarus/Restart/2hr.php  #2 Hour Restart Warning
0 2,5,8,11,14,17,20,23 * * * php -q /home/dayzservers/epochchernarus/Restart/1hr.php  #1 Hour Restart
30 2,5,8,11,14,17,20,23 * * * php -q /home/dayzservers/epochchernarus/Restart/30min.php   #30 Min Restart
45 2,5,8,11,14,17,20,23 * * * php -q /home/dayzservers/epochchernarus/Restart/15min.php    #15 Min Restart
50 2,5,8,11,14,17,20,23 * * * php -q /home/dayzservers/epochchernarus/Restart/10min.php     #10 Min Restart
55 2,5,8,11,14,17,20,23 * * * php -q /home/dayzservers/epochchernarus/Restart/5min.php      #5 Min Restart
59 2,5,8,11,14,17,20,23 * * * php -q /home/dayzservers/epochchernarus/Restart/1min.php        #1 Min Restart

The above are only if you copy and paste into the cron file located in /var/spool/cron/crontabs/USERNAME
```

***
These are how to setup on multiple systems 

###/*For Webmin*/
```
1. Login
2. Select "System" on the left
3. Select "Scheduled Cron Jobs"
4. Click the button at the top that says "Create a new scheduled cron job"

#####=== In Order ===
######==Job Details==
Execute cron job as: "Your Login Username" e.g dayzservers. or click the button next to the text box and select your username *Case Sensitive*
Active? Select Yes!
Command: Copy and paste a command from below
Input to command: BLANK
Description: e.g DayZ Epoch Panthera Restarter

######==When to Execute==
You can select from the drop down box or for a 3 hour restart *Make sure this is correct or your server will restart every minute!*

In the Minutes Box select: 0 
In the hours box select: 0 3 6 9 12 15 18 31 

Make sure it says Selected .. and not All   keep "Days, Months, Weekdays set to all"

then under "Date range to execute" Select Run on any date!

then click Save and then follow from the top for each cron
```
###/*For cPanel*/
```
1. Login
2. Scroll down to Advanced Tab
3. Click Cron Jobs

######=== In Order ===
Common Settings: Select one of the defaults if you wish

Minute: 0
Hour: Select the drop down box and select what you want.
Day: *
Month: *
Weekday: *
 
Command: Select from below

then Click Add New Cron Job and it should show at the bottom
```

Use these to add as the command for the cron jobs 

/*			       */
/* Commands */
/*			       */

```
 2 Hr: php -q /home/dayzservers/epochchernarus/Restart/2hr.php
 1 Hr: php -q /home/dayzservers/epochchernarus/Restart/1hr.php
 30 Min: php -q /home/dayzservers/epochchernarus/Restart/30min.php
 15 Min: php -q /home/dayzservers/epochchernarus/Restart/15min.php
 10 Min: php -q /home/dayzservers/epochchernarus/Restart/10min.php
 5 Min: php -q /home/dayzservers/epochchernarus/Restart/5min.php
 1 Min: php -q /home/dayzservers/epochchernarus/Restart/1min.php
```

###These Files were not created by me. Just reuploaded to github due to original server being offline. All files were created by JPhix
