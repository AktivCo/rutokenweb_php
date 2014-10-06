<?
//Настройки подключения
	   
mysql_connect("host", "login", "password");
mysql_select_db("db_name");
mysql_query("SET NAMES utf8");
/*
if (!isset($_GET['action'])) $_GET['action']="";
if($_GET['action']=="install"){
	mysql_query("DROP TABLE `sample_users`");
	mysql_query("CREATE TABLE `sample_users` (
	`user_id` int(11) unsigned NOT NULL auto_increment,
	`user_login` varchar(30) NOT NULL,
	`user_xkey` varchar(64) NOT NULL,
	`user_ykey` varchar(64) NOT NULL,
	`r_xkey` varchar(64) NOT NULL,
	`r_ykey` varchar(64) NOT NULL,
	PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

}
*/
?>