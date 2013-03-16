### Installation

----------

#### Step 1


##### Preparing for Installation

Step 1 is setting up your system for the installation process. This just includes
giving the proper permissions to a select few directories and files so platform
can write to them.

Files and Directories to be modified for platform Installation:

	`platform/application/config/`

	`platform/application/config/application.php`

	`public/platform/themes/compiled/`

Once these permissions are set, you can proceed onto Step 2.

<img src="/platform/manuals/img/installation/step1.jpg">

-----------

#### Step 2


##### Database Setup

Step 2 consists of setting your database driver and credentials for the database
installation process. Simply provide Platform with your database driver
( such as mysql ), server, username, password, and database name you wish to use.

Platform will only let you continue past this step if it can connect to the database.
Notification of connectivity is provided under the Step 2 text on the left.

Once connected, you may proceed onto step 3.

<img src="/platform/manuals/img/installation/step2.jpg">

-----------

#### Step 3

##### Administration - User Setup

In Step 3 you will be creating your initial adminsitrative user for Platform.
You will simply need to provide a first and last name, a valid email, and
matching password.

Once again, Platform will not let you go past this step until the fields have
passed validation once again.  There will be notification on the left under
Step 3 updating you on your validation process.

Once validated, you may proceed onto step 4.

<img src="/platform/manuals/img/installation/step3.jpg">

-----------

#### Step 4

##### Complete

Congratulations, if you reached Step 4 Platform has been successfully installed,
but you are not done quite yet! We highly recommend that you delete your
installation folders once you are done installing to prevent any future mishaps.

Folders:

	`platform/installer/*`

	`public/installer/*`

And now your done! Have some fun with Platform!

<img src="/platform/manuals/img/installation/step4.jpg">
