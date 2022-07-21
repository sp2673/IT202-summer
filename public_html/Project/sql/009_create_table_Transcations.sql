CREATE TABLE IF NOT EXISTS Transactions(
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_src int NOT NULL,
    account_dest int NULL,
    balance_change int,
    transaction_type VARCHAR(20),
    memo TEXT DEFAULT NULL,
    expected_total int,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,

    FOREIGN KEY (account_src) REFERENCES Accounts(id),
    FOREIGN KEY (account_dest) REFERENCES Accounts(id)

)