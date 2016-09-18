# Laravel test project

**Step 1: Required Software**

* Virtualbox 5.0.2+ [Download link](http://download.virtualbox.org/virtualbox/5.0.2/)
* Vagrant 1.8.1+ [Download link](https://www.vagrantup.com/downloads.html)
* Git [Download link](https://git-scm.com/downloads)

Install all the software above

**Step 2: Clone the repo**

* Create a folder called dev
* Open terminal and navigate to the newly created folder
* in terminal run the following command
	* **~/Desktop/dev:$ ** *git clone https://github.com/pjcjonas/ng-laravel.git .*
		* note: the fullstop at the end, this will clone all the files into the current location

**Step 3: Booting vagrant**

* Once the code has been brought down, make sure you are in the same folder as the location of the **Vagrantfile**
* run the following command
	* **~/Desktop/dev:$** *vagrant up*
		* This will boot up the vagrant machine, barring that you installed all the software listed in step 1.
* As soon as vagrant is up and you can see the prompt again, run **vagrant ssh**.
	* This will log you into the vagrant scotch box.
	* **NOTE:** set '*always_populate_raw_post_data*' to '-1' in php.ini within the scotch box env

**Step 4: Running migrations**

* Once you ran ***vagrant ssh***, and you are now in the root of the vagrant machine run ***cd /var/www***
	* This will navigate you to the site files as hosted on the vagrant box
* To migrate run the following command
	* ***$: php artisan migrate:refresh***
		* this will first roll back and then re-run

**Step 5: Seeding**

* after the migrations have been run, you need to seed data into the tables, runn the following 2 commands
	* ***$: php artisan db:seed --class=ClientInvoiceSeeder***
	* ***$: php artisan db:seed --class=UsersTableSeeder***
		* These will populate the tables with test data.
		* **NOTE:** in the /database/seeds/UsersTableSeeder.php, you can customize the user logins there

**step 6: Login**

* Update your hosts file add the following entry:
	* ***192.168.33.10           dev.box***
* Once the hosts file has been updated you can visit the site at http://dev_box
	* You can log in now using the details you specified

**Step 7: API REQEUSTS**

* Send the following json object, be sure to update the client credentials else it will fail to validate.
>	{
>		"email" : "{Please Update}",
>		"password" : "blue3232",
>		"method" : "upsertInvoice",
>		"data" : {
>			"invoice": [
>				{
>					"number": "INV5433",
>					"date": "2015-01-01 14:21:53",
>					"line_items": [
>						{
>							"name": "Keyboard",
>							"price": 545.47,
>							"currency": "ZAR",
>							"quantity": 3
>						},
>						{
>							"name": "Mouse",
>							"price": 125.35,
>							"currency": "ZAR",
>							"quantity": 3
>						}
>					]
>				}
>			]
>		}
>	}


**AFFECTED FILES**

* Migrations
	* *database\migrations\2016_09_14_092045_create_client_table.php*
	* *database\migrations\2016_09_14_102213_createInvoiceTable.php*
	* *database\migrations\2016_09_14_103525_createLineItemTable.php*
	* *database\migrations\2016_09_14_112812_createRelatioships.php*
	* *database\migrations\2016_09_17_105019_createAdminTable.php*

* Seeds
	* *database\seeds\ClientInvoiceSeeder.php*
	* *database\seeds\UsersTableSeeder.php*

* Controllers
	* *app\Http\Controllers\api.php*
	* *app\Http\Controllers\DashboardController.php*
	* *app\Http\Controllers\LoginController.php*
		* *app\Http\Controllers\Auth\AuthController.php*

* Libraries
	* *app\libraries\api\ApiCore.php*
	* *app\libraries\api\ApiErrors.php*
	* *app\libraries\api\ApiMethods.php*
	* *app\libraries\api\ApiModel.php*
	* *app\libraries\api\ApiTables.php*
	* *app\libraries\api\ApiUtils.php*

* Views
	* *resources\views\login.blade.php*
	* *resources\views\dashboard.blade.php*
	* *resources\views\templates\master.blade.php*

* JavaScript
	* *public\js\main.js*
