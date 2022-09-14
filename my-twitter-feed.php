
<style><?php include 'tweet.css'?></style>
<?php
/**
* Plugin Name: My Twitter Feed
* Plugin URI: https://mediaengagement.org/
* Description: This plugin uses PHP to connect to the Twitter API and populate a Twitter feed in browser.
* Version: 0.1
* Author: CME
* Author URI: https://mediaengagement.org/
**/
use Abraham\TwitterOAuth\TwitterOAuth;


// connects to Twitter API to retrieve ten most recent tweets from the provided user
function getFeed() {
    /*
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
    */

    require "vendor/autoload.php";


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
    
    // retrieves and displays recent Tweet data
    $feedData= getFeed();
    
    // Get user info
    $profilePic = str_replace("normal", "400x400", $feedData[0]->user->profile_image_url_https);
    $userName = $feedData[0]->user->name;
    $userScreenName = $feedData[0]->user->screen_name;
    $tweetsNum = $feedData[0]->user->statuses_count;
    $followerNum = $feedData[0]->user->followers_count;
    
    ?>
	<div class="slider-container">
	    <section class="twitter-slider">
        <div class="swiper mySwiper container">
            <div class="swiper-wrapper content">
            <?php foreach($feedData as $tweet) { ?>
                <div class="swiper-slide card">
                <div class="card-content">
                    <div class="author-box">
                    <!--<img src="images/img1.jpg" alt="">-->
                    <div class="author-user">
                        <a href="https://twitter.com/engagingnews" class="author-image" target="_blank" rel="noopener noreferrer">
                                                    <img src="https://pbs.twimg.com/profile_images/1318321223202492416/sruJceRD_normal.jpg" alt="engagingnews" width="48" height="48">
                                            </a>  

                        <a href="https://twitter.com/engagingnews" target="_blank" rel="noopener noreferrer" class="author-name" style="color: rgb(0, 0, 0);">Engaging News</a>            
                    
                        <a href="https://twitter.com/engagingnews" class="ctf-author-screenname" target="_blank" rel="noopener noreferrer" style="color: rgb(0, 0, 0);">@engagingnews</a> 
                    
                    </div>
                    </div>
                </div>
                </div>
                
                <?php } ?>
            </div>
            </div>
        </section>
	</div>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>

      

<div class="swiper-wrapper content">
        <?php foreach($feedData as $tweet) {
              $latestTweet = $tweet->text;
              $latestTweet = preg_replace('/https:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="https://$1" target="_blank">https://$1</a>', $latestTweet);
              $latestTweet = preg_replace('/@([a-z0-9_]+)/i', '<a class="tweet-author" href="https://twitter.com/$1" target="_blank">@$1</a>', $latestTweet);
              $tweetTime = date("D M d H:i:s",strtotime($tweet->created_at));
        ?>
        <div class="swiper-slide card">
          <div class="card-content">

            <li class="tweet-wrapper">
                <div class="tweet-thumb">
                    <span><a href="<?php echo $tweet->user->url; ?>" title="<?php echo $tweet->user->name; ?>"><img alt="" src="<?php echo $tweet->user->profile_image_url; ?>"></a></span>
                </div>
                <div class="tweet-content">
                    <h3 class="title" title="<?php echo $tweet->text; ?>"><?php echo $latestTweet; ?></h3>
                    <span class="meta"><?php echo $tweetTime; ?> - <?php echo $tweet->favorite_count; ?> Favorite</span>
                </div>
            </li>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>


    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


    <?php
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

