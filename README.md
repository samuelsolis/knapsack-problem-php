#Knapsack problem resolution

This is a simple resolution for the knapsack problem using a
 backtraking algorithm only created to teach some PHP skills. 
 
The program has a simple install php file that create a table with
a item list (with 3 fields: name, value, volume). The goal of this approach is
only to teach how to manage a mysql database of a simple way.

The dependencies is managed using composer altouth just one dependency is listed (twig).
It seems useless but the purpose is teach how to manage a program with composer.

In `/src` you can find some classes to manage the schema, the database and some stuff.
In `/templates` you can find some simple Twig templates used for the project.

The class `Backtracking` contain the recursive solution for the knapsack problem.

## How to install
Just execute `composer install` to get the dependencies.
Edit the `config.php` to configure a valid database.
Execute the install.php file to create the tables.
 
