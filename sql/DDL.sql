DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
  (
     `idusers`    INT(11) NOT NULL auto_increment,
     `name`       VARCHAR(255) NOT NULL,
     `witemail`   VARCHAR(255) NOT NULL,
     `gmail`      VARCHAR(255) NOT NULL,
     `password`   VARCHAR(255) NOT NULL,
     `group`      VARCHAR(255) NOT NULL,
     `department` VARCHAR(255) NOT NULL,
     `imageurl`   VARCHAR(255) DEFAULT NULL,
     PRIMARY KEY (`idusers`),
     UNIQUE KEY `witemail_unique` (`witemail`)
  ); 
