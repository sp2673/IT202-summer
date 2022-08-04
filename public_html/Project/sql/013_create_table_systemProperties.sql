CREATE TABLE IF NOT EXISTS `System Properties`
(
    id             int auto_increment,
    first_updated   TIMESTAMP default CURRENT_TIMESTAMP,
    last_updated TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    APY            decimal (12,2) default 0.00,
    PRIMARY KEY (id)
)