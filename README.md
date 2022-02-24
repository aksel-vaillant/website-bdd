# website-bdd

Realized by Aksel Vaillant, Nicolas Boisseau, Clément Le Batard.   
Computer science students at ENSIM - Le Mans Université [FRANCE]   
Under the direction of Mr. Madeth May

------------------

### Programming languages and library

We used HTML, the Bootstrap library with some CSS, JS and most importantly, PHP and MySQL to communicate with a database and get all our dynamic data onto the page.

### What did we do on this project? 

#### Part 1 - Entity-relationship model

  - We built a model from attributes and datas from 3 documents provided: including an invoice, a customer and an order spreadsheet.
  - We implemented it with phpMyAdmin in MySQL.
  => 18 tables 

#### Part 2 - HMI and SQL requests

  - Manage customers
      - Create and edit a customer file.
      - Consult the list of customers.
      - Search a customer file by id or name. 

  - Manage orders
      - Create, edit, delete, consult an order file.
      - Export all order files in an Excel spreadsheet.


  - Sadly, we didn't had enought time to generate an invoice, make the payment with points and follow all the steps of the order.

### Export datas using Excel

![image](https://user-images.githubusercontent.com/82941071/150694866-38b9bc56-02bc-4cbc-8b18-e1e1c5805c17.png)

Be sure to enable the "wrap text" option on the column containing all articles.  
