[![published](https://static.production.devnetcloud.com/codeexchange/assets/images/devnet-published.svg)](https://developer.cisco.com/codeexchange/github/repo/Abhijith-R/Webex-teams-with-Google-Maps-Integration)

# Fire Department Incident Management
This Project is an Incident Management Portal for the fire department to handle/manage incidents. This Project also demonstrates the integration between Cisco Webex teams and Google maps API and how it can help in managing fire incidents.

#### Author:

* Abhijith R (abhr@cisco.com)

Date: May/June 2018
***

## Prerequisites
* Xcode and command line tools
* MySql
* PHP
* Google Maps API token
* Cisco Webex Teams API token

## Steps to reproduce the Demo

### Setup the environment for the demo

* Ensure Xcode and command line tools are installed in you Mac system
* Refer https://www.embarcadero.com/starthere/xe5/mobdevsetup/ios/en/installing_the_commandline_tools.html to install Xcode and command line tools.
*	Download the project folder
*	Open a Terminal and run <b>environment-setup.sh</b> file (sh environment-setup.sh)
*	Copy the project folder to the newly created Sites folder (mv project-folder ~/Sites)
*	Open Terminal and type sudo nano /etc/apache2/httpd.conf and press enter
*	Press Ctrl+W which will bring up a search
*	Search for php and press enter. 
*	Delete the # from #LoadModule php7_module libexec/apache2/libphp7.so
*	Press Ctrl+O followed by Enter to save the change you just made
*	Press Ctrl+X to exit nano
*	Type sudo apachectl restart and press enter
*	Go back to Terminal and enter sudo nano /etc/apache2/httpd.conf
*	Press Ctrl+W to bring up search
*	Search for Library and press enter.
*	Replace both occurrences of /Library/WebServer/Documents with /Users/username/Sites(instead of username use your name which can be found at the top of your terminal next to the home icon)
*	Press Ctrl+O followed by Enter to save these changes
*	Press Ctrl+X to exit nano
*	Type sudo apachectl restart and press enter

### Setting up sequelPro to manage MySQL
* Open SequelPro
*	Enter 127.0.0.1 for the Host. Enter root for the Username and newpassword for the Password. Press Connect
*	From the dropdown on the top left corner select mydb as the desired database
*	You can now type http://localhost/Fire_Department/pages/index.php to start the demo.

### Enable Cisco Webex Teams calling in the demo
*	Open a new terminal and open the project folder in the Sites folder (cd Sites/Fire_Department)
*	Execute the below commands
```
npm init
npm install --save ciscospark
npm install --save-dev browserify
echo "window.ciscospark = require('ciscospark')" > ./index.js
browserify index.js > bundle.js
npm install -g httpster
httpster
```

### Note:
*	You need to add your own Google Maps API and Webex Team API token in tokens.txt file in /dist/others to run the demo successfully.
*	You should also change the Webex Teams spaceID in index.php and firestation.php to enable conversation in a webex teams room
*	You should also change the toPerson variable in engine.php to enable  webex team calling.
*	For more information, kindly refer https://developer.webex.com/sdk-for-browsers.html and https://developers.google.com/maps/documentation/javascript/examples/place-search
*	mysql.server start should be executed if in case the computer/system has been rebooted/shutdown to start sql and begin the demo.

#### API Reference/Documentation:
* [Cisco Webex Teams](https://developer.webex.com/)
* [Google Maps](https://developers.google.com/places/)

#### Other References:
<https://developers.google.com/maps/documentation/javascript/examples/place-search><br>
<https://developers.google.com/maps/documentation/javascript/examples/geocoding-simple><br>
<https://developer.webex.com/sdk-for-browsers.html><br>
<https://startbootstrap.com/template-overviews/sb-admin-2/><br>
<https://getbootstrap.com/><br>
<https://github.com/AvinashKrSharma/vehicle-movement-animation-google-maps>

#### DISCLAIMER:
<b>Please note:</b> This script is meant for educational purposes only. All tools/ scripts in this repo are released for use "AS IS" without any warranties of any kind, including, but not limited to their installation, use, or performance. Any use of these scripts and tools is at your own risk. There is no guarantee that they have been through thorough testing in a comparable environment and we are not responsible for any damage or data loss incurred with their use.
You are responsible for reviewing and testing any scripts you run thoroughly before use in any non-testing environment.
