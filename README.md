IbanFrst
============

A Symfony 4.4 project.

#Install project #clone project from Github 

## git clone https://github.com/Najehi/IbanFirst.git

#install dependencies

## composer install

#To run project,run the web server 

Runs the app in the development mode.

Open http://localhost:8000 to view it in the browser or with postman

## php -S localhost:8000 -t public

#wallet api uri 

GET  http://localhost:8000/wallets/list  //get wallets list

GET http://localhost:8000/wallets/-{id}  // get wallet detail

GET http://localhost:8000/wallets/-{id}/balance/{date}  //get wallet balance for a given date

POST http://localhost:8000/wallets/create  //submit new wallet


#Financial Movements api uri

GET http://localhost:8000/financialMovements/history  //Retrieve financial movements history

GET http://localhost:8000/financialMovements/-{id}  //Retrieve financial movements details


#Unit test, Run phpunit with the command
## .\vendor\bin\simple-phpunit


