<?php

namespace Elsadany\Analytics;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Google_Client;
use Google_Service_AnalyticsReporting;
use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_Dimension;
use Google_Service_AnalyticsReporting_ReportRequest;
use Google_Service_AnalyticsReporting_GetReportsRequest;

class analyticsController extends Controller {

    public function index() {
        $view_id = config('analyticsConfig.view_id');
        $analytics = self::initializeAnalytics();


        $yearsessions = $this->getresult($analytics, $view_id, '365daysAgo', 'today', 'ga:sessions');
        $monthsessions = $this->getresult($analytics, $view_id, '30daysAgo', 'today', 'ga:sessions');
        $weeksessions = $this->getresult($analytics, $view_id, '7daysAgo', 'today', 'ga:sessions');
        $daysessions = $this->getresult($analytics, $view_id, '1daysAgo', 'today', 'ga:sessions');
        $data['year'] = $this->printResults($yearsessions);
        $data['month'] = $this->printResults($monthsessions);
        $data['week'] = $this->printResults($weeksessions);
        $data['day'] = $this->printResults($daysessions);
        $analytic = $this->getinitializeAnalytics();
        $pageviwesobject = self::getReport($analytic, $view_id, '30daysAgo', 'today', array(
                    'ga:pagePath'));

        $pagesourceobject = self::getReport($analytic, $view_id, '30daysAgo', 'today', array(
                    'ga:source'));
        $pagecountryobject = self::getReport($analytic, $view_id, '30daysAgo', 'today', array(
                    'ga:country'));
        $pagedataobject = self::getReport($analytic, $view_id, '30daysAgo', 'today', array(
                    'ga:deviceCategory'));
        $pagesystemobject = self::getReport($analytic, $view_id, '30daysAgo', 'today', array(
                    'ga:operatingSystem'));

//        dd($pagedefault);
        $pageviews = self::getResults($pageviwesobject);
        $data['pagesource'] = self::getResults($pagesourceobject);
        $data['pagesource'] = collect($data['pagesource'])->sortBy('sessions')->reverse()->toArray();
        $pagecountry = self::getResults($pagecountryobject);
        $pagedata = self::getResults($pagedataobject);
        $operatingsystems = self::getResults($pagesystemobject);
        $data['all'] = array_sum(array_column($pagedata, 'sessions'));
        $data['pagecountry'] = collect($pagecountry)->sortBy('sessions')->reverse()->toArray();
        $pageviews = collect($pageviews)->sortBy('sessions')->reverse()->toArray();
        $data['pageviews'] = array_slice($pageviews, 0, 9);
        $data['pagecountry'] = array_slice($data['pagecountry'], 0, 9);
//        dd($data['pagecountry']);
        $data['pagesource'] = array_slice($data['pagesource'], 0, 9);
        $data['pagedata'] = $pagedata;
        $data['systems'] = collect($operatingsystems)->sortBy('sessions')->reverse()->toArray();
        $channels = self::testgetReport($analytic, $view_id, '30daysAgo', 'today', array(
                    'ga:channelGrouping'));
        $data['channels'] = self::getResults($channels);
      
        // $results = self::getReport($analytics, '157316086');
        // $results = self::getReport($analytics, '157273183');

        return view('backend.googleAnalytics.index', $data);
    }

    /**
     * Initializes an Analytics Reporting API V4 service object.
     *
     * @return An authorized Analytics Reporting API V4 service object.
     */
    private static function getinitializeAnalytics() {

        // Use the developers console and download your service account
        // credentials in JSON format. Place them in this directory or
        // change the key file location if necessary.
        $KEY_FILE_LOCATION = __DIR__ . '/service-account-credentials.json';

        // Create and configure a new client object.
        $client = new \Google_Client();
        $client->setApplicationName("Hello Analytics Reporting");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new \Google_Service_AnalyticsReporting($client);

        return $analytics;
    }

    private static function initializeAnalytics() {

        $KEY_FILE_LOCATION = __DIR__ . '/service-account-credentials.json';

        // Create and configure a new client object.
        $client = new Google_Client();
        $client->setApplicationName("Hello Analytics Reporting");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new \Google_Service_Analytics($client);

        return $analytics;
    }

    /**
     * Queries the Analytics Reporting API V4.
     *
     * @param service An authorized Analytics Reporting API V4 service object.
     * @return The Analytics Reporting API V4 response.
     */
    private static function testgetReport($analytics, $view_id, $from, $to, $dimensions_arr) {

        // Create the DateRange object.
        $dateRange = new \Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($from);
        $dateRange->setEndDate($to);

        // Create the Metrics object.
        $sessions = new \Google_Service_AnalyticsReporting_Metric();
        $sessions->setExpression("ga:sessions");
        $sessions->setAlias("sessions");
        $bouncerate = new \Google_Service_AnalyticsReporting_Metric();
        $bouncerate->setExpression("ga:bounceRate");
        $bouncerate->setAlias("bounce");
        $users = new \Google_Service_AnalyticsReporting_Metric();
        $users->setExpression("ga:users");
        $users->setAlias("users");
        $newusers = new \Google_Service_AnalyticsReporting_Metric();
        $newusers->setExpression("ga:newUsers");
        $newusers->setAlias("newusers");
        $avgsessions = new \Google_Service_AnalyticsReporting_Metric();
        $avgsessions->setExpression("ga:avgSessionDuration");
        $avgsessions->setAlias("avgsessions");
        $pagesessions = new \Google_Service_AnalyticsReporting_Metric();
        $pagesessions->setExpression("ga:avgTimeOnPage");
        $pagesessions->setAlias("Avgtime");
        // Create dimensions objects
        $dimensions = array();

        foreach ($dimensions_arr as $dim_txt) {
            $dimension = new \Google_Service_AnalyticsReporting_Dimension();
            $dimension->setName($dim_txt);
            $dimensions[] = $dimension;
        }

        // Create the ReportRequest object.
        $request = new \Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($view_id);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($newusers, $sessions, $bouncerate, $users, $avgsessions,$pagesessions));
        $request->setDimensions($dimensions);

        $body = new \Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($request));
        return $analytics->reports->batchGet($body);
    }

    private static function getReport($analytics, $view_id, $from, $to, $dimensions_arr) {

        // Create the DateRange object.
        $dateRange = new \Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($from);
        $dateRange->setEndDate($to);

        // Create the Metrics object.
        $sessions = new \Google_Service_AnalyticsReporting_Metric();
        $sessions->setExpression("ga:sessions");
        $sessions->setAlias("sessions");

        // Create dimensions objects
        $dimensions = array();

        foreach ($dimensions_arr as $dim_txt) {
            $dimension = new \Google_Service_AnalyticsReporting_Dimension();
            $dimension->setName($dim_txt);
            $dimensions[] = $dimension;
        }

        // Create the ReportRequest object.
        $request = new \Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($view_id);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($sessions));
        $request->setDimensions($dimensions);

        $body = new \Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($request));
        return $analytics->reports->batchGet($body);
    }

    /**
     * Parses and prints the Analytics Reporting API V4 response.
     *
     * @param An Analytics Reporting API V4 response.
     */
    private static function getResults($reports) {
        $return = [];
        $results = array(
            'dimensions' => array(),
            'metrics' => array());
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $header = $report->getColumnHeader();
            $dimensionHeaders = $header->getDimensions();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();

            for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                $row = $rows[$rowIndex];
                $dimensions = $row->getDimensions();
                $metrics = $row->getMetrics();
                for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                    $results[$dimensionHeaders[$i]] = $dimensions[$i];
                    // print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
                }

                for ($j = 0; $j < count($metrics); $j++) {
                    $values = $metrics[$j]->getValues();
                    for ($k = 0; $k < count($values); $k++) {
                        $entry = $metricHeaders[$k];
                        $results[$entry->getName()] = $values[$k];
//	            print($entry->getName() . ": " . $values[$k] . "\n");
                    }
                }
                // print("\n");
                $return[] = $results;
            }
        }
        return $return;
    }

    private function getFirstProfileId($analytics) {
        // Get the user's first view (profile) ID.
        // Get the list of accounts for the authorized user.
        $accounts = $analytics->management_accounts->listManagementAccounts();

        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();

            // Get the list of properties for the authorized user.
            $properties = $analytics->management_webproperties
                    ->listManagementWebproperties($firstAccountId);

            if (count($properties->getItems()) > 0) {
                $items = $properties->getItems();
                $firstPropertyId = $items[0]->getId();

                // Get the list of views (profiles) for the authorized user.
                $profiles = $analytics->management_profiles
                        ->listManagementProfiles($firstAccountId, $firstPropertyId);

                if (count($profiles->getItems()) > 0) {
                    $items = $profiles->getItems();

                    // Return the first view (profile) ID.
                    return $items[0]->getId();
                } else {
                    throw new Exception('No views (profiles) found for this user.');
                }
            } else {
                throw new Exception('No properties found for this user.');
            }
        } else {
            throw new Exception('No accounts found for this user.');
        }
    }

    function getresult($analytics, $profileId, $from, $to, $type) {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
                        'ga:' . $profileId, $from, $to, $type
        );
    }

    function printResults($results) {
        // Parses the response from the Core Reporting API and prints
        // the profile name and total sessions.
        if (count($results->getRows()) > 0) {

            // Get the profile name.
            $profileName = $results->getProfileInfo()->getProfileName();

            // Get the entry for the first entry in the first row.
            $rows = $results->getRows();

            $sessions = $rows[0][0];
            $result = $sessions;
            // Print the results.
        } else {
            $result = '';
        }
        return $result;
    }

}
