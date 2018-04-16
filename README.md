#Google Analytics
## Installation
composer require elsadany/google-analytics dev-master
###  config/app ->providers
```json
Elsadany\Analytics\AnalyticsServiceProvider::class,
```
- run command
`php artisan vendor:publish`
- now You can put details in config file `analyticsConfig.php`
#-`view_id` 
```json
from google analytics dashboard Admin->viewSettings->View ID
```
#-`extend`
- /put link of your layout 
#-`ContentArea`
- /put the content area name 
##`service_path`
#First get the service json key from https://console.developers.google.com/
-/1 create project 
-/ go to Credentials > create credentials -> service account key
->Service account -> new service key -> fill inputs and put role owner  then create
-/ put downloaded file in any path 
put the puth with the file name in config
 -/Enable APIs and services -> google analytics Api
 ##now the last step 
 -/put the client_email from the downloaded json file in google analytics dashboard Admin->User Management 
- /Add permissions for: put mail as read&analyse click add
#- /now you can get reports on /google-analytics/show
