#Google Analytics 
first download package by composer with composer require elsadany/google-analytics 
- /add Elsadany\Analytics\AnalyticsServiceProvider::class, to config/app ->providers 
- /run php artisan vendor:publish the config file analyticsConfig.php 
- /put view_id from google analytics dashboard Admin->viewSettings->View ID
- /put link of your layout and the content area name 
- /put this mail analytic-ap@starlit-hangar-179521.iam.gserviceaccount.com google analytics dashboard Admin->User Management 
- /Add permissions for: put mail as read&analyse click add

- /you can get reports on /google-analytics/show
