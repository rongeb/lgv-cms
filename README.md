LGV - CMS
---------



Introduction
-------------
 
Welcome to the repository of "LGV CMS".

I share my work because I think it can be really useful for developping web sites with public or private access.
I add more features step by step in order to fit most demanding needs for building a web site. 
The cms runs on Laminas (formerly Zend Framework). 


Principles of the cms
----------------------

Intro
------
I worked for many companies in order to develop their own back-office for their web sites.
But unfortunately they did not designed their back-office to have common modules or components able to be used for their other web sites or web application. 
So I decided to design a solution in order to create customizable web sites easily and to have modules re-usable. 
The main concept is that your web page is build from blocks.
You think and design your web page as ordered blocks. You declare your web page and its blocks in the cms.
You stay focused on the design of your web page and particularly on its blocks.
The app will take care to display (or hide)  your web page following your configuration.


Benefits
---------
Modularity and Scalability:
Thanks to Laminas, on the back-end side, you can easily add features through zend modules or through your own php library.
On the front-end side, you have to think your web page as blocks, blocks that have their own blocks.
By this way you can stay focused on the UI.

- Maintainability :
You know what's going on. You have the control of the code.
It is easily maintainable because it applies the MVC pattern flavour from Zend Framework.
I offer a simple way to organize your cms with zend.

- Native features :
You have by default features like :
    - Access Control List
    - Files Management
    - Blog
    - Extranet
    - ...


Principles
-----------
Let's talk about the principles of the cms:
- Page (Module: Rubrique): it's a web page, the main container.
When you create a new page, the related phtml file is created in the sitepublic or in the siteprivate view folder.
Just verify that you have the appropriate rights to manage files from the application.

- Section (Module: Sous-Rubrique) : a page has one or many sections. 
a section does not represent a section tag in html, it represents a piece of your page.

- Content (Module: Contenu, Galerie, Blogcontent): a section has one or many contents.
I have divided content in three types :
    - stdContent : html content that you can edit with an editor + title and subtitle
    - imgContent : std content plus images
    - blogContet : imgContent plus another fields like author, date...
    - mapContent : stdContent enriched with GPS coordinates and its information details

It's up to you to create a new content type or just to modify an existing one.

In the add or edit forms you have the list of the files uploaded.
You can to copy to the clipboard the path of an image and add it in your htlm editor.

- Links (Module: Linktocontenu): A content is related to a page but if you want to share the same content into another page,
it allows to create a new content. it could be the perfect copy of the targeted content or you can customize it.
In fact it's more than a link, you can customize the appearance of your link by adding an image, html, title... 
A use case could be that you want to create a shortcut to an article of your blog in your index page, you can easily 
customize the content in order to fit the design of your page.

- Html templates: Probably you use the same html code to represent the same type of content. 
For instance, when you display a gallery of images, the html template is the same for all images.
Instead of repeating manually the code in the html editor, you create once the template and it will be available in the forms that manage the contents.
You just have to select the template and it will be pasted in the html editor.

- Message (Module: Message): It's a message sent by visitors through a form

- Comment (Module: Commentaire): It's a comment sent. It is related to a content

By default messages and comments are stored in the database.
You can also send it by email. The code have been commented in the modules.
You just have to uncomment and put values in the related configuration files (folder EmailConfig in a module)
The email sending is done by smtp client but you have also the option to send emails from visitor through sendmail.
You just have to comment smtp client code and uncomment sendmail code inside the controller.

- Files (Module: Fichiers): All the files or images included in your content are managed by this module.
If you want to add or update files of a content, you will find all the files and their link in a table
in the management page (add or update page) of your content.
In your content you will put the link of the file. You will find example.

- Loginmgmt (Module : Loginmgmt): You can manage back office users.
You have by default three roles: 
    - anonymous: this is the default role associated to a visitor of your public web site or blog. Of course you do not 
    have to declare this type of user
    - user: has an access to the back-office except loginmgmt
    - guest: has an access to the private space of your web site (through siteprivate feature)
    - administrator: has an access to the back-office and to the login management module

- MyAcl (Module : MyAcl): In this module you can manage role and url allowed by role.
The role is stored in a session (configuration is in the Application module)

- Pagearrangement (Module: Pagearrangement): It allows to see the hierarchy of the elements (sections, contents) of a page.
You can change the position of sections and contents.
By clicking on a button you can go to the form that you allow to update the selected element.
It is very useful to have an overview of your page
That's the object sent by the controller to the view.

- Privatespace (Module: Privatespace): It allows to declare an extranet in addition to your public web site.

- Privatespacelogin (Module: Privatespacelogin): It allows to manage users of the extranet you have created.

- Siteprivate (Module: Siteprivate): 
    It allows to:
        - manage the display of the pages related to a private space (Extranet).
        - manage the subscription of a new user 
        - manage the case of a user who forgot his password.
        - manage comment's form 
        - manage contact's form
    
    
- Sitepublic (Module: Sitepublic):
    It allows to:
        - manage the display of the pages related to your public web site.
        - manage contact's form
 
- Pagews (Module: Pagews):  this web service send in a json format a pagearrangement object.
It means you can get all the html content related to a page organized through the pagearrangement object.
It allows to get this content through an ajax request and not from a viewmodel object from Zend Framework.
It is useful if you use a front-end framework.

You have 3 endpoints:
1) getallpagesbyspaceid
     get pages related to a space
1) getpagearrangementbypagename
     get all the objects related to the page by filename
2) getpagearrangementbypageid
    get all the objects related to the page by id

        Please notice that these web services are by default available for any user profile

- Searchws (Module: Searchws): This web service allows to search words contained in your pages.

        You have 3 endpoints :    
            1) For the public website 
                - getpublicpages
            2) For the extranet
                - getprivatepages
            3) For the back-office
                - getallpages
        
            It accepts POST http request. 
            The content-type can be application/json or application/x-www-form-urlencoded.
            
            Body example in a json format: {
                "search": my words separated by a whitespace 
            }
            
            An example of a response in a json format :
            
            {
                "results": [
                    {
                        "contenttitle": "Image Slider 1",
                        "contentsubtitle": "",
                        "contenthtml": "\r\nLorem Ipsum\r\n\r\nCassium viderit etiam magis habemus.Cassium viderit etiam magis habemus\r\n\r\nLearn more Examples",
                        "contentcreation": "2018-09-28 18:37:31",
                        "pagefilename": "index.phtml",
                        "pagetitle": "One Page",
                        "sectiontitle": "Home",
                        "pagerank": "1",
                        "sectionrank": "1",
                        "contentrank": "1",
                        "occurences": [
                            "lorem",
                            "ipsum"
                        ]
                    }
                ]
            }

- Uploadmgmt (Module: Uploadmgmt): This module allows a user of an extranet to upload files. 
Through an admnistration pages, you can download, validate, modify or delete the documents. 
It could be pictures, office documents, videos, compressed files.

- Publishing (Module: Publishing): It allows an administrator of the back-office to publish a page or not.
It means a user of the back-office can create a page and its contents but it is only an administrator of the site who give the authorization to publish.


Position
---------
In order to build your web site properly, you must give a position to your page, sections and contents.
The first page called if you don't provide id or pagename will be the page with the smaller rank.
If you want to prepare a section or content but you don't want to show it, you just have to put a number below 0.


Layout
-------
You can use different layout for the web site. I use EdpModuleLayouts from Evan Coury.
It's easy to configure, you can configure it in the module.config.php of the application module.
You already have the code in module.config.php.


Database
---------
You need to execute the sql script in order to create the database.
It is located in data/database folder.
The connection settings is located in the module/Application/src/Application/DBconnection.
If you need to connect to another databases, you can add your own class or simply add method in the existing class.
All Dao classes extends Parentdao class that instantiate connection to the database. 
I use pdo driver for Mysql.


Third Party Library
-------------------
You want to use a third party library or your own php library and call it in your project. 
You have to put the library in a folder inside the vendor folder.
You declare your library in composer.json file. In order to validate your changes, launch composer update.
 
 
Internationalization
---------------------
The default language enabled is the english language.
Now I must confess I have developed in french. So the native language is french and strings are translated in english.
In fact, I didn't think I will share this project. 
It explains why you have modules name with french words.
For the ui of the back-office, if you want to translate to another language, you have to create
and edit a new po file with a po editor.
The method to translate a string is ... translate('string'). If you want to add a translate method outside views and controllers, you need to use the method translate in ExtLib located in the vendor folder.
You also have to download the js file that contains the translation of tiny mce in your language.
http://www.tinymce.com/i18n/


Cache
------
Data related to the files bank of your project is stored in a file cache.
If you add, update or delete a file, the cache is flushed and it has been re-created.
The cache strategy used in this cms don't need to enable or import a php module.
In production mode you can uncomment configuration cache located in application.config.php
Do not forget to set write permission on data/cache folder and its subfolders
You have another cache methods supported by zend(apc, memcached, redis...), it's up to you to add another cache strategy.
http://framework.zend.com/manual/current/en/modules/zend.cache.storage.adapter.html
The configuration is located in the module.config.php in the application module.


Laminas Framework
---------------------
You don't need to know zend framework to use the cms but if you want to customize the behaviour of the
the back-office or add new features it could be a good idea to have knowledges of the framework.
All the code and configuration can be customized to fit your needs. 

I have a lot of ideas to improve and optimize this project.
If yout want to contribute, you are welcome.


Installation
-------------
- git (https://git-scm.com/):
You can clone the project :
git clone https://rongeb@bitbucket.org/rongeb/lgv_cms.git

dependencies :
The project is built on top of Laminas. It works with php >= 7.1.
If you want to use a newer version of Laminas, you have to use composer.
The project include the vendor folder containing all the dependencies.
First remove composer.lock files.
Then with the command line, you go to the root folder of the project and you type :
php composer.phar install
More information on composer:
https://getcomposer.org/download/


- urls of the applications
You can find the url of the module in their config folder in the module.config.php
These are relative url usefull to start :
     * backoffice login : /backofficeaccess
     * public web page : /sitepublic/displaypublicpage/your page without phtml extension
     * extranet login : /siteprivate?myspace=token of your private space (you will find the token in the database)
     * extranet web page : /siteprivate/displayprivatepage/your page without phtml extension

- Default login to connect to the back-office:
    - user : lgvcmsAdmin
    - password : lgvcmsAdmin
    - url : /backofficeaccess

- Default login to connect to the extranet :
    - user : anit_private@anit.org
    - password : anit_private@anit.org
    - url : /siteprivate?myspace=token_of_the_privatespace_stored_in_the_space_table

- In the index.php file in the public folder, you can define the environment where the application have been installed 
with the global variable ANIT_ENVIRONMENT. By default, it is the value 'dev' that is defined. 
'dev' allows to disable the application configuration cache and to display the exception. If you put another value, the
the application configuration cache will be enabled and the debug mode will be disabled.

- Database
    - The configuration of the database is located in module/Application/src/DBConnection/DBConnection.php
    - MySql 5 or above is required

- PHP
    - php >= 7.1 for Laminas
  
    
 PLEASE HELP AND SUPPORT THIS PROJECT
 ------------------------------------
 This project is huge for only one developer.
 If you think this project could be interesting 
 or if you have any contribution (bugfix, feature...) 
 it will be a pleasure to enrich the project.