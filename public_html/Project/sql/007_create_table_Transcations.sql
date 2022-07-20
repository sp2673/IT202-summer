CREATE TABLE `Transactions`
(
    id             int auto_increment,
    act_src_id     int not null,
    act_dest_id    int null,
    amount         decimal(12, 2),
    action_type    varchar(10), 
    memo           TEXT default null,
    expected_total decimal(12, 2),
    created        TIMESTAMP default CURRENT_TIMESTAMP,
    updated        TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key (id),
    /*foreign key (act_src_id , act_dest_id) references `Bank Accounts` (id),*/
    constraint ZeroTransferNotAllowed CHECK(amount != 0)
)