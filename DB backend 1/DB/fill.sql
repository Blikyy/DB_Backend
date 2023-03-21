INSERT INTO `flight`(`id`, `where`, `to`) VALUES (NULL,'Praha','Tokyo'), (NULL,'Praha','Vídeň'), (NULL,'Paříž','Praha');
INSERT INTO `user`(`id`, `name`, `surname`, `fly_id`) VALUES (NULL,'Nikolas','Erlebach',(SELECT `id` FROM `flight` WHERE `to`="Tokyo")), (NULL,'Jan','Novák',(SELECT `id` FROM `flight` WHERE `to`="Vídeň")), (NULL,'Adam','Adam',(SELECT `id` FROM `flight` WHERE `to`="Praha"));
