<?
##################################
# BoxingRoll configuration file #
#################################
$Config = array();
$Config['mysql'] = array();
##############################################################################################
# MySQL Database Configuration
# 	$WCFConfig['mysql']['hostname']
# 	$WCFConfig['mysql']['username']
# 	$WCFConfig['mysql']['password']
# 	$WCFConfig['mysql']['dbname']
# 	$WCFConfig['mysql']['charset']
# 	$WCFConfig['mysql']['prefix']
#
# Database connection settings for different databases
# 	Default:
# 	hostname: localhost
# 	username: root
# 	password:
# 	charset: UTF8
# 	prefix: armory_
#	error: flase
##############################################################################################
$Config['mysql']['hostname'] = '127.0.0.1';
$Config['mysql']['username'] = 'root';
$Config['mysql']['password'] = 'mangos';
$Config['mysql']['dbname'] = 'boosterroll';
$Config['mysql']['charset'] = 'UTF8';
$Config['mysql']['error'] = true;
?>