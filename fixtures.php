<?php

require_once 'idiorm.php';

ORM::configure('sqlite:./db.sqlite');

ORM::get_db()->exec(
"
DROP TABLE IF EXISTS user;
CREATE TABLE IF NOT EXISTS `user` (
  `id` integer PRIMARY KEY AUTOINCREMENT,
  `facebookid` text NOT NULL,
  `name` text NOT NULL
) ;"
);

ORM::get_db()->exec(
"
DROP TABLE IF EXISTS messages;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` integer PRIMARY KEY AUTOINCREMENT,
  `content` text NOT NULL,
  `sender_fbid` text NOT NULL,
  `receiver_fbid` text NOT NULL,
  FOREIGN KEY (sender_fbid) REFERENCES user(facebookid),
  FOREIGN KEY (receiver_fbid) REFERENCES user(facebookid)
) ;"
);

echo "I installed the database";
 
?>