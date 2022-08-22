
<?php
/**
* Plugin Name: My Twitter Feed
* Plugin URI: https://mediaengagement.org/
* Description: This plugin uses PHP to connect to the Twitter API and populate a Twitter feed in browser.
* Version: 0.1
* Author: CME
* Author URI: https://mediaengagement.org/
**/
include "twitterAPI.php";
include "twitterapi/src/TwitterOAuth.php";



// connects to Twitter API to retrieve ten most recent tweets from the provided user
function getFeed() {
    
    $settings = array(
        'oauth_access_token' => "1732894075-MlvumVFZBVeBftcr52NmgZwnfho8rq0EkyrDJsn",
        'oauth_access_token_secret' => "eskrvmAkcfeOGAK12EvVoHnt341mYPUhJRAt1CBdnSAy8",
        'consumer_key' => "NRK4DnChojCvFCDrwVRM8OxVy",
        'consumer_secret' => "RuGc6eLEvMqC49uD5CABAXp2pCAdB63iXyujHf32WdLeymY7AT"
    );

    $url            = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    $getfield       = '?screen_name=EngagingNews';
    $request_method = 'GET';

    $twitter_instance = new Twitter_API_WordPress( $settings );

    $result = $twitter_instance
        ->set_get_field( $getfield )
        ->build_oauth( $url, $request_method )
        ->process_request();

    $data = json_decode($result);
    return $data;
    
    /*
    // authorization information
    $consumerKey       = "NRK4DnChojCvFCDrwVRM8OxVy";
    $consumerSecret    = "RuGc6eLEvMqC49uD5CABAXp2pCAdB63iXyujHf32WdLeymY7AT";
    $accessToken       = "1732894075-MlvumVFZBVeBftcr52NmgZwnfho8rq0EkyrDJsn";
    $accessTokenSecret = "eskrvmAkcfeOGAK12EvVoHnt341mYPUhJRAt1CBdnSAy8";
    
    // Twitter account username
    $twitterID = 'EngagingNews';
    
    // Number of tweets
    $tweetNum = 10;
        
    // Authenticate with twitter
    $twitterConnection = new TwitterOAuth(
        $consumerKey,
        $consumerSecret,
        $accessToken,
        $accessTokenSecret
    );

    // Get the user timeline feeds
    $feedData = $twitterConnection->get(
        'statuses/user_timeline',
        array(
            'screen_name'     => $twitterID,
            'count'           => $tweetNum,
            'exclude_replies' => false
        )
    );
    */
    // updates public variable so that it stores the most recent tweets    
    return $feedData;
    
}

function displayFeed($feed) {
    
    // test run to see if html will be displayed
    echo "<p>hello</p>";
    
    /*
    // Get the user timeline feeds
    // Get user info
    $profilePic = str_replace("normal", "400x400", $this->twitterData[0]->user->profile_image_url_https);
    $userName = $this->twitterData[0]->user->name;
    $userScreenName = $this->twitterData[0]->user->screen_name;
    $tweetsNum = $this->twitterData[0]->user->statuses_count;
    $followerNum = $this->twitterData[0]->user->followers_count;
    */
}

// add action so that most recent posts from twitter feed are retrieved when page is loaded
add_action( 'wp_footer', 'callDisplayFeed', 10);
function callDisplayFeed() {
    $data = getFeed();
    // test run to see if html will be displayed
    print_r($data);
    
    
}

function activate() {
    // remove rewrite rules and then recreat rewrite rules
    flush_rewrite_rules();

    // when user clicks activate this code will run
    // stuff to initially set up plugin (ex making table in database to store plugins data)


}

function deactivate() {

    //Code to delete the plugin and clean up after it would be added here.        

    // removes action hook that displays the recent tweets
    remove_action( 'wp_footer', 'callDisplayFeed', 10);


    // sets array that holds the data to null
}

function uninstall(){
    //When the user clicks "uninstall" this code will run.

    //Code to delete the plugin and clean up after it would be added here.        

    // removes action hook that displays the recent tweets
    remove_action( 'wp_footer', 'callDisplayFeed', 10);

    // sets array that holds the data to null
}


//Register the activation hook.
register_activation_hook(__FILE__, 'activate'); 
//Register the deactivation hook.
register_deactivation_hook(__FILE__, 'deactivate'); 
//Register the uninstall hook.
register_uninstall_hook(__FILE__,  'uninstall'); 

