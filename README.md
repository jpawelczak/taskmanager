Task Manager
============
My project during Coderslab bootcamp based on Symfony2, Twig, Doctrine, FOSUserBundle, HWIOAuthBundle, KnpPaginator, Bootstrap, jQuery.

IDE: PHP Storm.

Note: HWIOAuthBundle doesn't connect to FB, because I would have to register the app at first.

## Tips:
- add 'use \DateTime' in Entity and use method 'new DateTime()' to create object with date - twig will recognize and render the datetime (note, this is exception for namespace!)
- add {'attr': {'novalidate': 'novalidate'}} to form(form) to disable HTML5 validation to present exact errors to a user
- add to an object in newAction that generates Form predefined date to present in a form before submitting ($task->setDeadline(new DateTime());)
- create single fields.html.twig and add it to config.yml to use the same template in all fields in the project (I added it manually anyway ;))
- use jQuery for hide onClick event to show details to use without reloading a page
- add list of categories from other DB by adding to Your_action_nameForm "->add('category')". Also you need to add "__toString" to appropriate Entity to parse names and provide them to the form as list to choose
- add confirmation for "Delete" Task button using SweetAlert
- add email confirmation for registration in fos_user just by enabling it in config.yml. Remember to set postfix on your server and mailer in parameters.yml!
- using fos_user and ROLEs you can block access to stags, e.g. 'path: ^/category/new , role: ROLE_ADMIN' -> only The Admin can create new Categories. You can check in twig ROLE and show or hide a link "Create a new category" as required.
- add sorting Tasks using knp paginator bundle -> https://github.com/KnpLabs/KnpPaginatorBundle/tree/2.5.3 
- add HWIOAuthBundle to support login via FB (and other services)
- deployed the app on AWS

## To improve/ TODO:
- deploy app on AWS
- create a simple questionnaire (e.g. date of birth day, anniversary)
- create predefined tasks based on answers (e.g. create Task to choose a present and seperate to buy it)
- creation datetime with server's date, not user's date - add UTC or timestamp
