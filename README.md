# **Technical Exercice - Backend Dev - SYDEV**
Dans le cadre du processus d'intégration, vous devez passer un petit test technique pour montrer comment vous abordez une tâche de programmation de base.

>## **Stack**

* [Symfony](https://symfony.com/doc/current/index.html)
* [API Platform](https://api-platform.com/docs/)
* [PHP](https://www.php.net/docs.php)

>## **Documentations**

* [Symfony](https://symfony.com/doc/current/index.html)
* [Symfony fundamentals and deep into the magic](https://symfonycasts.com/tracks/symfony5)
* [Symfony - Fundamentals](https://symfonycasts.com/tracks/symfony)
* [API Platform](https://symfonycasts.com/screencast/api-platform)
* [API Platform - Security](https://symfonycasts.com/screencast/api-platform-security)
* [API Platform - Extending](https://symfonycasts.com/screencast/api-platform-extending)
* [Begineer Testing and Behavioral Testing](https://symfonycasts.com/tracks/testing)

>## **Requirements**

* `PHP` *8.0 or later*
* `Composer` *download [here](https://getcomposer.org/doc/00-intro.md)*
* `Git`
* `MySQL` 

>## **How to use?**

>>>### **Installations**

    $ git clone git@github.com:anmolvishvas/technical_exercise.git
    $ cd /path/to/technical_exercice/

    # Installation of composant
    $ composer install
    $ php bin/console doctrine:database:create --if-not-exists
    $ php bin/console doctrine:migrations:migrate --no-interaction

    # Generate the SSL keys
    $ php bin/console lexik:jwt:generate-keypair

    # Open XAMPP Control Panel and start 'Apache and 'MySQL'
    # Run server
    $ symfony server

>>>### **How to login?**

#### *Credentials*

    # To login as a director / admin:
        username: 1684483706_Anmol
        password: Anmol
    
    #To login as a collaborator / user:
        username: 1684489109_Vishvas
        password: Vishvas

#### *Steps*

1. On your browser, type `127.0.0.1:8000/api`.
2. Go on the `Login Check` section and click on `Try it out`.
3. On the Request body, enter the `login data` using the credentials provided above and execute the API.
4. After execuiting the API, a token will be provided.
5. Copy and paste the `token` in the input field you will find after clicking on the `Authorize` button, which is located at the top left of the website.

>>>### **How to Test?**

    # On the terminal, run the following commands:
    $ php bin/composer prepare-test
    $ vendor/bin/phpunit


>>>### **Useful commands**

    # Commands to run symfony server
    $ php bin/console serve

    # Commands to clear cache
    $ php bin/console cache:clear

    # Commands to test
    $ php bin/console composer prepare-test
    $ vendor/bin/phpunit

    # Commands to run PHP code fixer
    $ vendor/bin/php-cs-fixer fix src

