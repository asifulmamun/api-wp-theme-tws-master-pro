<?php 

// Set the response headers to indicate JSON content
header("Content-Type: application/json");




/* 
 *
 * Theme Details and github
 * 
 *  */
$git = "";
if($git == ""){
    require_once './token.php';
    $access_token = $git_access_token; // api token - github developer token
}

$repository = 'asifulmamun/tws'; // username/repository name
$branch = 'main'; // Replace with your main branch name




/* 
 *
 *  Accessing and Geather Information
 *  */
$url = "https://api.github.com/repos/$repository/releases/latest";


$headers = array(
    "Accept: application/vnd.github+json",
    "Authorization: Bearer $access_token",
    "X-GitHub-Api-Version: 2022-11-28",
    "User-Agent: TWS MASTER PRO", // Replace with a relevant name for your application
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
    $commit_message = $latest_commit_data["tag_name"];
    preg_match('/v?(\d+\.\d+\.\d+)/', $commit_message, $matches);
    $latest_commit_version = isset($matches[1]) ? $matches[1] : '1.0.0';

    theme_update_data($latest_commit_version, $repository);
    
    // test response
    // echo $latest_commit_data["tag_name"];
    // echo '<pre>';
    // var_dump($latest_commit_data);
    // echo '</pre>';
}





/* 
 *
 * 
 *  API RESPONSE
 * 
 * 
 */
function theme_update_data($latest_commit_version, $repository){

    $details_url = "https://github.com/$repository"; // Updated Theme Details
    $download_url = "https://github.com/$repository/archive/refs/tags/v$latest_commit_version.zip"; // Theme Update Link


    // Create an associative array with the desired JSON structure
    $response_api = array(
        "version" => $latest_commit_version,
        "download_url" => $download_url,
        "details_url" => $details_url
    );

    // Encode the array as JSON and output it
    echo json_encode($response_api, JSON_PRETTY_PRINT);    
}