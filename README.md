# Ledger App

## How to build local environment

0. Add the following lines to your /etc/hosts file.
```bash
127.0.0.1 ledger.showsider.life
```
1. Clone this repository
```bash
git clone git@github.com:anilonayy/ledger-app.git
```
2. Switch to "deployer" directory.
```bash
cd ./ledger-app/deployer
```
3. Build the environment by running the following command:
```bash
 ./deployer.sh magic
```
4. Run './deployer.sh up' to start the services.
```bash
 ./deployer.sh up
```
5. Run './deployer.sh down' to stop the services.
```bash
 ./deployer.sh down
```

(Shhh here is the fast way..)
```bash
git clone git@github.com:anilonayy/ledger-app.git
cd ./ledger-app/deployer
./deployer.sh magic
```

## What can you do with this app?

This is a simple app  to manage ledger. This project allows you:

### User
- Create a new account
- List own accounts
- Balance transfer between another accounts.
- Withdraw money from own account
- Get account balance on specific times.

### Admin
- All of user's can do.
- Give credit to user's account.
- List all or single account.
- List all or single transaction
<br />
<br />
Don't you have a time for testing? Don't worry, I have prepared a Postman collection for you. 

You can find it [here](https://www.postman.com/warped-space-758269/workspace/ledgerapp/collection/29192763-d5bca94b-3bdd-4fb6-bc74-c2cbb8e31172?action=share&creator=29192763&active-environment=29192763-4f997ae1-b7d8-48fe-bb00-fd7132147c4e).
