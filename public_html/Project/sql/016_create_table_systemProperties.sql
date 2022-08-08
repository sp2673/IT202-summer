CREATE TABLE IF NOT EXISTS `System Properties`
(
     `id` int AUTO_INCREMENT not null,
    `name`      varchar(20) not null unique,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `APY` decimal (12,2) DEFAULT 0.00,
    PRIMARY KEY (`id`)
)
