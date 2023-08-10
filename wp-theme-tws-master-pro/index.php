<?php 

// Set the response headers to indicate JSON content
header("Content-Type: application/json");




/* 
 *
 * Theme Details
 * 
 *  */
$details_url = 'https://asifulmamun.info.bd'; // Updated Theme Details
$download_url = "https://github.com/asifulmamun/wp-theme_smafolk.is/archive/refs/tags/3.2.0.zip"; // Theme Update Link





//  GITHUB ACCESS
$access_token = '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'; // api token - github developer token
$repository = 'asifulmamun/wp-theme_smafolk.is'; // username/repository name
$branch = 'master'; // Replace with your main branch name





/* 
 *
 *  Accessing and Geather Information
 *  */
$url = "https://api.github.com/repos/$repository/branches/$branch";

$headers = array(
    'Authorization: token ' . $access_token,
    'User-Agent: TWS MASTER PRO' // Replace with a relevant name for your application
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);

$latest_commit_data = json_decode($response, true);

if ($latest_commit_data) {
    
    // Extract version from commit message
    $commit_message = $latest_commit_data['commit']['commit']['message'];
    preg_match('/Version: v?(\d+\.\d+\.\d+)/', $commit_message, $matches);
    $latest_commit_version = isset($matches[1]) ? $matches[1] : 'Unknown';

    
    // echo $latest_commit_version;
    theme_update_data($latest_commit_version, $download_url, $details_url);

}





/* 
 *
 * 
 *  API RESPONSE
 * 
 * 
 */
function theme_update_data($latest_commit_version, $download_url, $details_url){

    // Create an associative array with the desired JSON structure
    $response_api = array(
        "version" => $latest_commit_version,
        "download_url" => $download_url,
        "details_url" => $details_url
    );

    // Encode the array as JSON and output it
    echo json_encode($response_api, JSON_PRETTY_PRINT);    
}