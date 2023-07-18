<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://i.ibb.co/yq5Q3ss/qq-ghub.png" width="400"></a></p>

<p align="center">
<a href="https://laravel.com/"><img src="https://img.shields.io/badge/-Laravel-FF2D20?logo=laravel&logoColor=white" alt="Laravel"></a>
<a href="https://www.mysql.com/"><img src="https://img.shields.io/badge/-MySQL-4479A1?logo=mysql&logoColor=white" alt="MySQL"></a>
</p>

## About 

The project is a Laravel-based internet banking application that enables users to register, log in, and perform various banking operations. Users can open both regular and savings accounts, deposit and withdraw money, and transfer funds between accounts. The application also incorporates a two-factor authentication (2FA) system to enhance security. Additionally, the savings account feature allows users to buy and sell cryptocurrencies and view their holdings in a portfolio.

### ⬇️ Preview

🟣 Log in page:
<p align="center"><img src="login.gif" width="1200"></p>

🟣 Two-factor authentication:
<p align="center"><img src="two-factor.gif" width="1200"></p>

🟣 Create accounts and delete:
<p align="center"><img src="create_new_account.gif" width="1200"></p>

🟣 Deposit and withdraw money:
<p align="center"><img src="deposit.gif" width="1200"></p>

🟣 Transfer money between accounts:
<p align="center"><img src="transfer.gif" width="1200"></p>

🟣 Buy cryptocurrencies:
<p align="center"><img src="buy_crypto.gif" width="1200"></p>

🟣 View portfolio and sell cryptocurrencies:
<p align="center"><img src="portfolio.gif" width="1200"></p>

### ⬇️ How to run project locally

1. Clone or download the project
```
git clone https://github.com/Trotsijs/products-page.git
```
2. Run these commands in the project directory to install dependencies
```
composer install
```
and
```
npm install
```
3. Rename `.env.example` to `.env`
4. Get an API key from [CoinMarketCap API](https://coinmarketcap.com/api/)
5. Add the API key to the `.env` file as `CRYPTO_API_KEY=your_api_key`
6. Create a database and add the database credentials to the `.env` file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
7. Run this command to migrate the database
```
php artisan migrate
```

9. Start server by running this command
```
php artisan serve
```
10. Run this command to compile assets
```
npm run dev
``` 

11. Go to http://127.0.0.1:8000 in your browser
