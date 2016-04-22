taskmanager
===========

Tips:
- add 'use \DateTime' in Entity and use method 'new DateTime()' to create object with date - twig will recognize and render the datetime (note, this is exception for namespace!)
- add {'attr': {'novalidate': 'novalidate'}} to form(form) to disable HTML5 validation to present exact errors to a user
- add to an object in newAction that generates Form predefined date to present in a form before submitting ($task->setDeadline(new DateTime());)
- create single fields.html.twig and add it to config.yml to use the same template in all fields in the project (I added it manually anyway ;))
- use jQuery for hide onClick event to show details to use without reloading a page
- add list of categories from other DB by adding to Your_action_nameForm "->add('category')". Also you need to add "__toString" to appropriate Entity to parse names and provide them to the form as list to choose
- add confirmation for "Delete" Task button using SweetAlert

To improve:
- different RULEs for admin and user
- add 'validation' in Task for Resolved - if markedResolved, date has to be also set in the form
- deadline datetime - start from today 
- creation datetime with server's date, not user's date - add UTC or timestamp


