taskmanager
===========

Tips:
- add 'use \DateTime' in Entity and use method 'new DateTime()' to create object with date - twig will recognize and render the datetime (note, this is exception for namespace!)
- add {'attr': {'novalidate': 'novalidate'}} to form(form) to disable HTML5 validation to present exact errors to a user
- add to an object in newAction that generates Form predefined date to present in a form before submitting ($task->setDeadline(new DateTime());)
- create single fields.html.twig and add it to config.yml to use the same template in all fields in the project

To improve:
- add 'validation' in Task for Resolved - if markedResolved, date has to be also set in the form
- add confirmation for "Delete" Task button
- add 'validation' to Comment forms and return errors from 'validation' to twig
- deadline datetime - start from today 
- creation datetime with server's date, not user's date - add UTC or timestamp


