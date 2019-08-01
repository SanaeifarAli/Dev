# Dev_ProductComments Task2 for Magento 2

This extension is the second task to test magento 2 skill.

 - [Task Description](#task-description)
 - [Setup](#setup)
 - [Usage](#usage)
 - [Support](#support)
 - [Authors](#authors)
 - [License](#license)

## Task Description

Before starting any work on extension please read the full description
After completing this task you will learn and know how to use: - models
- blocks
- views
- UI components in admin panel - saving and reading data
- plugins
- observers
- service contracts
- emails and usage of Mailtrap 
- API endpoints
(tables, table fields, attributes, and anything else related to database MUST be created via module schema scripts)

**Task**
Create new extension and name it "Dev_ProductComments".
Add new product attribute that will determine if customers can leave comments on certain products. It should be of a Yes/No type under 'General' tab. Make sure that its not visible on frontend.
Products that are allowed for commenting will be displayed in a list. To do so, create a block that can be used by site administrators to be placed in any CMS page or block with possibility to limit the amount of products shown.
When customer opens product with commenting enabled, approved comments and a form to add new comment should be shown in a new tab next to description. Certain rules should be applied:
* Each field in the comment form is validated - so you can enter only valid email, no special characters, etc (make sure to validate not only on frontend but also backend when submitting a request)
* If comment was successfully added, customer should see success message after submitting comment, otherwise display error message.
* Comments are stored in a separate table in the database, which belongs to your module.
All comments are shown in the Magento backend, in separate menu tab under Dev -> Product Comments.
(NOTE: make sure that page title is Product Comments, when creating grids prioritize XML approach over directly constructing them with PHP)

* Grid title - "Product Comments".
Export action is not required. Default sort is by date, descending.
* Grid should function as default, e.g. all columns sortable / filterable, option to select entries per page, pagination.

* Grid consists of the following fields:
Date - date when comment was added.
Product Name - name of product comment was added to.
(in database it should be stored as integer of the entity, make use of UI column meta modifiers to show product name).
Author Name - first name and last name of the customer who added comment.
Comment - comment text (please note, that there might be large comments so take care that it does not brake grid layout).
Status - status of comment. Default state - Not Approved

* Extension should allow two mass-actions: change status (approve/unapprove) and delete. * Grid row should have an edit action that leads to selected comment edit form.
Comment edit page

* Action buttons:
Back - Leads back to grid.
Delete - Deletes comment.
Save and Continue - Saves comment and stays at current edit page.
Save - Saves comment and redirects back to comment grid.

* Form fields:
Product - should be rendered as select field (UI component) from where you can search and select single product.
Customer name - text field, required.
Customer email - text field, required.
Comment - textarea field, required.
Status - select field with values Approved and Not Approved. Defaults to Not approved. Required.
Remember to validate all fields and add success/error messages.
There should be Add Comment button in grid that allows to create a new comment for product. Fields are same as Comment edit page. Only difference, when comment is being created from the admin panel, Customer name and Customer email should be pre-filled with administrator data and disabled. Remember to make sure that fields were not changed, you can verify it in controller.
An email with the comment and information that the comment is waiting for approval should be sent to customer upon submission. Use observers for that.

To send email from local environment you will need to install Mailtrap extension: https://mailtrap.io/
Create an API endpoint to get all comments for a certain product (usage of service contract implementation is required)
Important

Make sure to follow https://devdocs.magento.com/guides/v2.2/ext-best-practices/extension- coding/coding-best-practices.html
Useful notes and resources
Don't write business logic at entry point level (controllers, cron, plugins, observer) use custom models so that functionality would be reusable.
S.O.L.I.D in Magento - http://www.dckap.com/blog/why-should-every-developer-follow-solid- principles/
     
Your best friend in this journey - https://devdocs.magento.com/


## Usage

**Frontend**
- http://yourDomain/productcomments

**CRUD**
- http://yourDomain/rest/V1/signup
- http://yourDomain/rest/V1/signupCreate
- http://yourDomain/rest/V1/signupUpdate
- http://yourDomain/rest/V1/signupDelete

**Admin**
- http://yourDomain/admin/productcomments

## Settings

## Support
- If there are any comments,question or recommendation please let me know at AliSanaeifar@yahoo.com

## Authors
 
 - **Ali Sanaeifar**  
 AliSanaeifar@yahoo.com

## License

This project is not licensed.

***That's all folks!***
