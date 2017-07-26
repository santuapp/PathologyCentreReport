PathologyCentre Reporting System
=================================

"Steps to prepare the source code to build/run properly & Steps to create and initialize the database"

1. Install latest version of XAMPP with PHP 5.4.0 or higher.
2. Download the composer from getcomposer.org
3. When you install the composer, you will have to choose the "php.exe" file.
4. To check the composer installation, type the below code in command prompt "composer -V"
5. After this, run composer global require ``fxp/composer-asset-plugin:1.1.4``
6. If point 5 is giving any error, please add "--no-plugins" in the end i.e. composer global require ``fxp/composer-asset-plugin:1.1.4 --no-plugins``
7. Extract the source code in server root directory.
8. Open command promt inside Source folder where composer.json file exists and run "composer update" without doubt quotes. This point might take sometime depending on internet connection since it downloads the complete Yii2 framework and extensions required with in the project.
9. After you install the application, run command "init" (windows) or "php init" (for linux) to initialize the application with a specific environment. Select "development" environment.
10. Create two new databases named as "pathology" & "pathology_tests" and adjust the components['db'] configuration in Source/common/config/main.php & Source/tests/codeception/config/config-local.php respectively. 
11. Run DB scripts which are available in Source/DB folder for both the databases.
12. Delete components['db] & components['mailer] from main-local.php else there will be conflicts.
13. Open command prompt inside Source/tests/codeception/frontend and run "php codecept.phar build"
14. After this, run "php codecept.phar run"
15. Follow point number 11 & 12 for Source/tests/codeception/common.
16. Go to browser URL and type following for admin URL: <root>/Source/backend/web/
17. Use following credentials, **email: admin@pathologylabs.com & password: admin123**
18. Setup type of tests and view the list of users.
19. Change URL to: <root>/Source/
20. Following the dummy users to test the system:

**Operator**

	email: operator@pathologylabs.com
	password: password
	
**Patient**

	name: Patient
	email: patient@pathologylabs.com
	passcode: PL123
	
Please note: Dummy data in the system doesn't belong to any real data and it is being used for testing purpose only. 

I have created a demo account in gmail for sending real emails.


