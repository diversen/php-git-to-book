# Demo

There is a demo at [http://gittobook.org](http://gittobook.org)

# Install

## Requirements: 

* Apache2
* php5 >= 5.3
* mysql-server
* pandoc (Epub, Docx files)
* texlive-full (for PDF support)
* kindlegen (for Mobi support)

## Build

First clone the base system into e.g. yoursite: 

    git clone https://github.com/diversen/php-git-to-book example.com

Enter the base system: 

    cd yoursite
    
Install dependencies. May take some time: 
    
    composer update

Enable apache2 host:

    // you will need to be root to use the built-in command
    sudo ./coscli.sh apache2 --en example.com

Run install command: 

    ./coscli.sh prompt-install --install

You will be asked about version to install. Choose a `tag` or use `master`. The you will be asked about about MySQL configuration - and also ServerHost (example.com). The configuration file will be rewritten `config/config.ini`. Then the system will install all the profile modules from git repos. At last the system will prompt you for a super user. Enter an email and password

Set correct perms for public files after install (e.g. upload folder)

    // you will need to be root user as we change
    // the perms to be www-data
    sudo ./coscli.sh file --chmod-files

We use a extra public directory, which you will need to add manual:

    mkdir htdocs/books
    
Change ownership (if using www-data): 

    sudo chown www-data:www-data htdocs/books

Go to http://example.com and log in and add a repo. 

## System config

If you make the above install, then the system is multi user by default. But you can make a few configuration changes in order to change this. This shows the default `gitbook.ini` file which is located in `modules/gitbook`.

~~~ini
; who can use it
; user is a user which has signed up - 
; admin is created in the install proces
gitbook_allow = 'user'
; who is allowed to use the all options in meta.yaml
; insert unescaped inline HTML for e.g. videos
gitbook_allow_ext = 'admin'
; for 'gitbook_allow' only these formats works
gitbook_exports = 'epub,html,pdf'
; assets allowed for 'gitbook_allow'
gitbook_allow_assets = 'css,jpeg,jpg,png,gif'
~~~
