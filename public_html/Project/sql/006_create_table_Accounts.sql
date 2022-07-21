CREATE TABLE IF NOT EXISTS Accounts(
    //bank accounts
    id int AUTO_INCREMENT PRIMARY KEY,
    account_number VARCHAR(12) NOT NULL ,
    user_id int ,
    balance decimal(12,2) DEFAULT 0.00,
    account_type VARCHAR(255),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES Users(id)
)