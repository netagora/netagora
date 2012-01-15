Installation
============

1- Clone the repository with Git:

    $ git clone git@github.com:netagora/netagora.git

2- Rename `app/config/parameters.ini.dist` to `app/config/parameters.ini`

    $ mv app/config/parameters.ini.dist app/config/parameters.ini

3- Edit the `app/config/parameters.ini` file with your database settings:

    [parameters]
        database_driver="pdo_mysql"
        database_host="localhost"
        database_port=
        database_name="netagora"
        database_user="root"
        database_password=""
        mailer_transport="smtp"
        mailer_host="localhost"
        mailer_user=""
        mailer_password=""
        locale="en"
        secret="1fc014198d06fefe2a75ea46a09a50426d42bf6e"

4- Install Bundles

    $ cd /path/to/netagora
    $ bin/vendors install