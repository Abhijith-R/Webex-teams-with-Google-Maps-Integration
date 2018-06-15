echo "Starting Environment Setup"

#Turn on Apache
echo "Starting Apache"
sudo apachectl start

# Creating a directory to place the project folder
echo "Creating the Sites folder"
cd
mkdir Sites
echo "Place the project folder in the Sites directory"
cd

# Check for Homebrew, install if we don't have it
echo "Installing Homebrew on Mac"
if test ! $(which brew); then
    echo "Installing homebrew..."
    ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
fi

# Update homebrew recipes
echo "Updating Homebrew"
brew update

#Install GNU `find`, `locate`, `updatedb`, and `xargs`, g-prefixed
echo "Installing Utils"
brew install findutils

#install mysql
echo "Installing Mysql"
brew install mysql

#Starting the sql server
mysql.server start

#install node
echo "Installing Node"
brew install node
brew update
brew upgrade node

#Install Bash 4
# brew install bash

echo "Cleaning up..."
brew cleanup

# Installing frontend(GUI) to manage the database
CASKS=(
     sequel-pro #GUI to manage the database
)
echo -e "\n\033[1mFollow the steps in 'https://websitebeaver.com/set-up-localhost-on-macos-high-sierra-apache-mysql-and-php-7-with-sslhttps' to connect sequel-pro to sql\033[0m"

echo "Installing Sequel Pro"
brew cask install ${CASKS[@]}

# Create database
echo "Creating database and a table"
echo -e "\n\033[1mDo not enter any password for this step, just press Enter/Return\033[0m";
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS mydb; use mydb; CREATE TABLE Incidents (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
incident_name VARCHAR(30) NOT NULL,
type VARCHAR(30),
address VARCHAR(50) NOT NULL,
locality VARCHAR(50),
severity VARCHAR(10) NOT NULL,
description VARCHAR(100),
caller_name VARCHAR(20),
caller_phone VARCHAR(20),
fs_address VARCHAR(100),
incident_date TIMESTAMP,
assigned_vehicle VARCHAR(20),
status VARCHAR(20) DEFAULT 'Open'
);ALTER USER 'root'@'localhost' IDENTIFIED BY 'newpassword';";

echo -e "\n\033[1mPassword for user 'root' in mysql is changed to 'newpassword'\033[0m";
echo -e "\n\033[1mTo enable Cisco Webex Teams Calling kindly refer this link 'https://developer.webex.com/sdk-for-browsers.html'\033[0m";
echo -e "\nEnvironment Setup complete";