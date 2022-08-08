# Project Name: (Simple Bank)

## Project Summary: This project will create a bank simulation for users. They’ll be able to have various accounts, do standard bank functions like deposit, withdraw, internal (user’s accounts)/external(other user’s accounts) transfers, and creating/closing accounts.

## Github Link: [https://github.com/sp2673/IT202-summer/tree/prod/public_html/Project]
## Project Board Link: https://github.com/sp2673/IT202-summer/projects/1

## Website Link: https://sp2673-prod.herokuapp.com/Project

## Final Demo Link: https://youtu.be/U1zfl9henaI
## Your Name: Shrey Patel 

<!-- Line item / Feature template (use this for each bullet point) -- DO NOT DELETE THIS SECTION


- [ ] \(mm/dd/yyyy of completion) Feature Title (from the proposal bullet point, if it's a sub-point indent it properly)
  -  Link to related .md file: [Link Name](link url)

 End Line item / Feature Template -- DO NOT DELETE THIS SECTION --> 
 
 
### Proposal Checklist and Evidence

- Milestone 1
  - [ √] \(07/05/2022 of completion) User will be able to register a new account
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone1/public_html/Project/milestone1.md
  -  Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/register.php
  - Form Fields
      -Username, email, password, confirm password(other fields optional)
      -Email is required and must be validated
      -Username is required
      -Confirm password’s match
  -Users Table
      -Id, username, email, password (60 characters), created, modified
  -Password must be hashed (plain text passwords will lose points)
  -Email should be unique
  -Username should be unique
  -System should let user know if username or email is taken and allow the user to correct the error without wiping/clearing the form
      -The only fields that may be cleared are the password fields

  - [√] \(07/05/2022 of completion) Feature Title User will be able to login to their account (given they enter the correct credentials)
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone1/public_html/Project/milestone1.md
  -  Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/login.php
  -Form
      -User can login with email or username
          -This can be done as a single field or as two separate fields
      -Password is required
  -User should see friendly error messages when an account either doesn’t exist or if passwords don’t match
  -Logging in should fetch the user’s details (and roles) and save them into the session.
  -User will be directed to a landing page upon login
  -This is a protected page (non-logged in users shouldn’t have access)
      -This can be home, profile, a dashboard, etc

  - [√] \(07/05/2022 of completion) User will be able to logout
  -  Link to related .md file:   https://github.com/sp2673/IT202-summer/blob/Milestone1/public_html/Project/milestone1.md
  -  Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/logout.php
  -Logging out will redirect to login page
  -User should see a message that they’ve successfully logged out
  -Session should be destroyed (so the back button doesn’t allow them access back in)

  - [√] \(07/05/2022 of completion) Basic security rules implemented
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone1/public_html/Project/milestone1.md
  -  Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/login.php
  - Authentication:
      -Function to check if user is logged in
      -Function should be called on appropriate pages that only allow logged in users
  -Roles/Authorization:
      -Have a roles table (see below)

  - [√] \(07/05/2022 of completion) Basic Roles implemented
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone1/public_html/Project/milestone1.md
  -  Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/home.php
  -Have a Roles table	(id, name, description, is_active, modified, created)
  -Have a User Roles table (id, user_id, role_id, is_active, created, modified)
  -Include a function to check if a user has a specific role 

  - [√] \(07/05/2022 of completion) Site should have basic styles/theme applied; everything should be styled
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone1/public_html/Project/milestone1.md
  -  Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/home.php
  - I.e., forms/input, navigation bar, etc

  - [√] \(07/05/2022 of completion) Any output messages/errors should be “user friendly”
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone1/public_html/Project/milestone1.md
  -  Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/home.php
  - Any technical errors or debug output displayed will result in a loss of points

  - [√] \(07/05/2022 of completion) User will be able to see their profile
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone1/public_html/Project/milestone1.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/profile.php
    - Email, username, etc
  - [√] \(07/05/2022 of completion) User will be able to edit their profile
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone1/public_html/Project/milestone1.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/profile.php
  - Changing username/email should properly check to see if it’s available before allowing the change
   - Any other fields should be properly validated
   - Allow password reset (only if the existing correct password is provided)

- Milestone 2
- [√] \(07/17/2022 of completion) Create the Accounts table (id, account_number [unique, always 12 characters], user_id, balance (default 0), account_type, created, modified)
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone2/public_html/Project/milestone2.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/sql/init_db.php

- [√] \(07/17/2022 of completion) User will be able to edit their profile
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone2/public_html/Project/milestone2.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/sql/init_db.php
  -Create these as initial setup scripts in the sql folder
      -Create a system user if they don’t exist (this will never be logged into, it’s just to keep things working per system requirements)
        -Hint: id should be a negative value to avoid conflicts
  -Create a world account in the Accounts table created above (if it doesn’t exist)
      -Account_number must be “000000000000”
      -User_id must be the id of the system user from the previous step
      -Account type must be “world”
      -Hint: id should be a negative value to avoid conflicts

- [√] \(07/17/2022 of completion) Create the Transactions table (see reference at end of document)
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone2/public_html/Project/milestone2.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/sql/init_db.php
  - Id, account_src, account_dest, balance_change, transaction_type, memo, expected_total, created, modified

- [√] \(07/17/2022 of completion) Dashboard page
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone2/public_html/Project/milestone2.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/dashboard.php
  -Note: This is different from navigation and it’s more like an ATM or mobile app view of interaction options
  -Will have links for Create Account, My Accounts, Deposit, Withdraw Transfer, Profile
    -Links that don’t have pages yet should just have href=”#”, you’ll update them later

- [√] \(07/17/2022 of completion) User will be able to create a checking account
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone2/public_html/Project/milestone2.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/createAccount.php
  -System will generate a unique 12 character account number
      -Options (strike out the option you won’t do):
          -Option 1: Generate a random 12 digit/character value; must regenerate if a duplicate collision occurs
  -System will associate the account to the user
  -Account type will be set as checking
  -Will require a minimum deposit of $5 (from the world account)
      -Entry will be recorded in the Transaction table as a transaction pair (per notes at end of document)
      -Account Balance will be updated based on SUM of balance_change of account_src
          -Do not set this value directly
  -User will see user-friendly error messages when appropriate
  -User will see user-friendly success message when account is created successfully
  -Redirect user to their Accounts page upon success

- [√] \(07/17/2022 of completion) User will be able to list their accounts
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone2/public_html/Project/milestone2.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/ListAccount.php
  - Limit results to 5 for now
  - Show account number, account type, modified, and balance

- [√] \(07/17/2022 of completion) User will be able to click an account for more information (a.k.a Transaction History page)
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone2/public_html/Project/milestone2.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/ListAccount.php
  - Show account number, account type, balance, opened/created date of the selected account (from Accounts table)
  - Show transaction history (from Transactions table)
      - For now limit results to 10 latest
      - Show the src/dest account numbers (not account id), the transaction type, the change in balance, when it occurred, expected total, and the memo

- [√] \(07/17/2022 of completion) User will be able to deposit/withdraw from their account(s)
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone2/public_html/Project/milestone2.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/MakeTrans.php
 - Clearly label each view with a heading as “Withdraw” or “Deposit” according to the application context/state
 - Form should have a dropdown of their accounts to pick from
    - World account should not be in the dropdown as it’s not owned by anyone
    - Account list should show account number and balance
- Form should have a field to enter a positive numeric value
    - For now, allow any deposit value (1 - inf)
- For withdraw, add a check to make sure they can’t withdraw more money than the account has
    - This must include a proper error message
- Form should allow the user to record a memo for the transaction; memos are an optional value from the user
- Each transaction is recorded as a transaction pair in the Transaction table per the details below and at the end of the document
    - Note: These will reflect on the transaction history page (Account page’s “more info”)
    - Note: if the world account is part of a transaction
        - If the world account is using a positive id you must fetch the world account’s id (do not hard code the id as it may change if the application migrates or gets rebuilt)
        - If using a negative value and you’re sure it won’t change across migrations you can hard code it but label (via a comment) what it refers to
    - Process
        - Requires two accounts (always)
            - Fetch the current balance of each account
            - Add or subtract the incoming balance change to calculate the expected totals of each account
        - Insert two records into the Transactions Table
            - Account A losing funds to Account B
            - Account B gaining funds from Account A
            - Ensure each record includes the proper balance_change, expected total, memo, the proper account ids (not account number), and the proper account type
        - Deposits will be from the “world account” to the user’s account
        - Withdraws will be from the user’s account to the “world account”
        - After the transactions are inserted update the balance of each account
            - By SUMing the balance_change for the account_src against the Transactions table
        - Show appropriate user-friendly error messages
            - If any part of the process fails, the entire process should fail
        - Show user-friendly success messages


- Milestone 3
- [√] \(07/31/2022 of completion) User will be able to transfer between their accounts
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone3.0/public_html/Project/milestone3.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/InternalTransfer.php
- Clearly label this activity with a heading showing “Internal Transfer”
- Form should include a dropdown for account_src and a dropdown for account_dest (only accounts the user owns; no world account)
    - Account list should show account number and balance
- Form should include a field for a positive numeric value
- System shouldn’t allow the user to transfer more funds than what’s available in account_src
- Form should allow the user to record a memo for the transaction
- Each transaction is recorded as a transaction pair in the Transaction table
    - These will reflect in the transaction history page
    - Note: Same process as withdraw/deposit
- Show appropriate user-friendly error messages
- Show user-friendly success messages

- [√] \(07/31/2022 of completion) Transaction History page (Same rules as the previous Milestone plus the below)
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone3.0/public_html/Project/milestone3.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/ListAccount.php
  - User will be able to filter transactions between two dates
  - User will be able to filter transactions by type (deposit, withdraw, transfer)
  - Transactions should paginate results after the initial 10

- [√] \(07/31/2022 of completion) User’s profile page should record and show First and Last name
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone3.0/public_html/Project/milestone3.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/profile.php
  - You may also capture this on the registration page, make note if you do
  - This will require an Alter Table statement for the Users table to include two new fields with default values

- [√] \(07/31/2022 of completion) User will be able to transfer funds to another user’s account
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone3.0/public_html/Project/milestone3.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/externalTransfer.php
-Clearly label this activity with a heading showing “External Transfer”
-Form should include a dropdown of the current user’s accounts (as account_src)
  -Account list should show account number and balance
-Form should include a field for the destination user’s last name
-Form should include a field for the last 4 characters of the destination user’s account number (to lookup account_dest)
-Form should include a field for a positive numerical value
-Form should allow the user to record a memo for the transaction
-System shouldn’t let the user transfer more than the balance of their account
-System shouldn’t allow the user to transfer a negative value (i.e., can’t pull money from target user’s account)
-System will lookup appropriate account based on destination user’s last name and the last 4 digits of the account number
-Show appropriate user-friendly error messages
-Show user-friendly success messages
-Transaction will be recorded with the type as “ext-transfer”
-Each transaction is recorded as a transaction pair in the Transaction table
  -These will reflect in the transaction history page
  -Note: Same process as withdraw/deposit/transfer


- Milestone 4
- [√] \(08/07/2022 of completion) User can set their profile to be public or private (will need another column in Users table)
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone4/public_html/Project/milestone4.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/profile.php
  - If profile is public, hide email address from other users (email address should not be publicly visible to others)
  - Profile should show total net worth

- [√] \(08/07/2022 of completion) Create a table for System Properties 
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone4/public_html/Project/milestone4.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/sql/init_db.php
  - Columns: id, name, value, modified, created

- [√] \(08/07/2022 of completion) Alter the Accounts table to include a timestamp for last_apy_calc, default to current_timestamp, and a boolean for is_active default to true
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone4/public_html/Project/milestone4.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/sql/init_db.php

- [√] \(08/07/2022 of completion) User will be able open a savings account
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone4/public_html/Project/milestone4.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/createAccount.php
- System will generate a 12 digit/character account number per the existing rules (see Checking Account above)
- System will associate the account to the user
- Account type will be set as savings
- Will require a minimum deposit of $5 (from the world account)
  - Entry will be recorded in the Transaction table in a transaction pair (per notes previously and below)
  - Account Balance will be updated based on SUM of balance_change of account_src
- System sets an APY that’ll be used to calculate monthly interest based on the balance of the account
  - APY pulled from System Properties table 
    - Hint: name could be “savings” and value could be the specific APY
- User will see user-friendly error messages when appropriate
- User will see user-friendly success message when account is created successfully
  - Redirect user to their Accounts page

- [√] \(08/07/2022 of completion) User will be able to take out a loan
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone4/public_html/Project/milestone4.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/Loans.php
- System will generate a 12 digit/character account number per the existing rules (see Checking Account above)
- Account type will be set as loan
- Will require a minimum value of $500
- System will show an APY (before the user submits the form, so on original page load)
  - This will be used to add monthly interest to the loan account
  - APY pulled from System Properties table 
    - Hint: name could be “loan” and value could be the specific APY
- Form will have a dropdown of the user’s accounts of which to deposit the money into
  - Hint: World account is not part of the loan process
  - Account list should show account number and balance
- Special Case for Loans:
  - Loans will show/display on the UI with a positive balance of what’s required to pay off (although it is a negative value in the database since the user owes it)
  - User will transfer funds to the loan account to pay it off
    - transfers will continue to be recorded in the Transactions table per normal rules
  - Loan account’s balance will be the balance minus any transfers to this account
  - Interest will be applied to the current loan balance and add to it (causing the user to owe more) (i.e. subtract from the negative balance)
  - A loan with 0 balance will be considered paid off and will not accrue interest and will be eligible to be marked as closed
  - User can’t transfer more money from a loan once it’s been opened and a loan account should not appear in the Account Source dropdowns
- User will see user-friendly error messages when appropriate
- User will see user-friendly success message when account is created successfully
  - Redirect user to their Accounts page

- [√] \(08/07/2022 of completion) Listing accounts and/or viewing Account Details should show any applicable APY or “-” if none is set for the particular account
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone4/public_html/Project/milestone4.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/ListAccount.php
  - Hint: Applies to Account List page and Transaction Details
- [√] \(08/07/2022 of completion) User will be able to close an account
  -  Link to related .md file: https://github.com/sp2673/IT202-summer/blob/Milestone4/public_html/Project/milestone4.md
  - Link to Heroku Prod Site where feature is implemented: https://sp2673-prod.herokuapp.com/Project/closeAcct.php
- User must transfer or withdraw all funds out of the account before doing so (i.e., balance must be 0)
- Account’s “is_active” column will get set as false
- All queries for Accounts should be updated to select only “is_active” = true accounts (i.e., dropdowns, My Accounts, etc)
- Do not delete the record, we’re doing a soft delete so it doesn’t break transactions
- Closed accounts should not be visible to the user anymore
- If the account is a loan, it must be paid off in full first

### Intructions
#### Don't delete this
1. Pick one project type
2. Create a proposal.md file in the root of your project directory of your GitHub repository
3. Copy the contents of the Google Doc into this readme file per the template
4. Convert the list items to markdown checkboxes (apply any other markdown for organizational purposes)
5. Create a new Project Board on GitHub
   - Choose the Automated Kanban Board Template
   - For each major line item (or sub line item if applicable) create a GitHub issue
   - The title should be the line item text
   - The first comment should be the acceptance criteria (i.e., what you need to accomplish for it to be "complete")
   - Leave these in "to do" status until you start working on them
   - Assign each issue to your Project Board (the right-side panel)
   - Assign each issue to yourself (the right-side panel)
6. As you work
  1. As you work on features, create separate branches for the code in the style of Feature-ShortDescription (using the Milestone# branch as the source to branch from and to merge into)
  2. Add, commit, push the related file changes to this branch
  3. Add evidence to the PR (Feat to Milestone) conversation view comments showing the feature being implemented (these will be used to populate the related .md files for each milestone, forgetting to capture this will give you more work later on)
     - Screenshot(s) of the site view (make sure they clearly show the feature)
     - Screenshot of the database data if applicable
     - Describe each screenshot to specify exactly what's being shown
     - A code snippet screenshot or reference via GitHub markdown may be used as an alternative for evidence that can't be captured on the screen
  4. Update the checklist of the proposal.md file for each feature this branch is completing (ideally should be 1 branch/pull request per feature, but some cases may have multiple)
    - Basically add an x to the checkbox markdown along with a date after
      - (i.e.,   - [x] (mm/dd/yy) ....) See Template above
    - Add the pull request link as a new indented line for each line item being completed
    - Attach any related issue items on the right-side panel
  5. Merge the Feature Branch into your Milestone branch (this should close the pull request and the attached issues)
    - Merge the Milestone branch into dev, then dev into prod as needed (be sure it doesn't break anything in prod)
    - Last two steps are mostly for getting it to prod for delivery of the assignment 
  7. If the attached issues don't close wait until the next step
  8. Merge the updated dev branch into your production branch via a pull request
  9. Close any related issues that didn't auto close
    - You can edit the dropdown on the issue or drag/drop it to the proper column on the project board