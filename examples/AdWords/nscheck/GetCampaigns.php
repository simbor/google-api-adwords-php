<?php
/**
 * This example gets all campaigns in the account. To add a campaign, run
 * AddCampaign.php.
 *
 * Tags: CampaignService.get
 *
 * Copyright 2012, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsAdWords
 * @subpackage v201309
 * @category   WebServices
 * @copyright  2012, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 * @author     Adam Rogal <api.arogal@gmail.com>
 * @author     Eric Koleda
 */

// Include the initialization file
require_once __DIR__ . '/init.php';

/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 */
function GetCampaignsExample(Google_Api_Ads_AdWords_Lib_AdWordsUser $user) {
  // Get the service, which loads the required classes.
  $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);

  // Create selector.
  $selector = new Google_Api_Ads_AdWords_v201309_Selector();
  $selector->fields = array('Id', 'Name');
  $selector->ordering[] = new Google_Api_Ads_AdWords_v201309_OrderBy('Name', 'ASCENDING');

  // Create paging controls.
  $selector->paging = new Google_Api_Ads_AdWords_v201309_Paging(0, Google_Api_Ads_AdWords_v201309_AdWordsConstants::RECOMMENDED_PAGE_SIZE);

  do {
    // Make the get request.
    $page = $campaignService->get($selector);

    // Display results.
    if (isset($page->entries)) {
      foreach ($page->entries as $campaign) {
        printf("Campaign with name '%s' and ID '%s' was found.\n",
            $campaign->name, $campaign->id);
      }
    } else {
      print "No campaigns were found.\n";
    }

    // Advance the paging index.
    $selector->paging->startIndex += Google_Api_Ads_AdWords_Lib_AdWordsConstants::RECOMMENDED_PAGE_SIZE;
  } while ($page->totalNumEntries > $selector->paging->startIndex);
}

// Don't run the example if the file is being included.
if (__FILE__ != realpath($_SERVER['PHP_SELF'])) {
  return;
}

try {
  // Get AdWordsUser from credentials in "../auth.ini"
  // relative to the AdWordsUser.php file's directory.
  $user = new Google_Api_Ads_AdWords_Lib_AdWordsUser();

  // Log every SOAP XML request and response.
  $user->LogAll();

  // Run the example.
  GetCampaignsExample($user);
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}
