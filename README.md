# Introduction

Want to own your own stock exchane? Look no futher. This project has it all:
trading your favorite stocks, following the price trends and more. 

The technologies used:
- PHP
- Twig
- PHP-DI
- Tailwind CSS
- MySQL

## Features

- You can view changes to stocks on the market
- Search your favorite companys
- Add them to your portfolio by buying or shorting. Sell to take the profit.
- View your order history for each stock on transactions page.
- If you have more than enoug of stock shares, transfer to a friend.

## Requirements

- PHP 7.4.32
- Composer
- MySQL 8.0.31

## Getting Started

1. Clone the repository:
   git clone https://github.com/renars1988/crypto-project.git

2. Install dependencies:
   composer install

3. Create account at https://finnhub.io/register to get your API key.

4. Rename .env.example to .env.

5. Enter your API key and database settings in the .env file.

6. Import database.sql schema in to your database.

7. Run the server from public folder:
   php -S localhost:8000
   
## See it in action:   
-Register:
![register](https://user-images.githubusercontent.com/44839765/209731759-3863c542-150e-4056-9eae-15148c3797df.gif)

-Buy, Sell, Short:
![buy2](https://user-images.githubusercontent.com/44839765/209733114-a73ef8d1-32f4-4575-b11f-73334f32fc85.gif)



