<?php

class twitterSlide {

    function __construct($init) {
        $this->tweetArray = $init;


    }

    function getBox($feedData, ) {
        return "
    <div class='tweet-box'>
        <h2>Latest Tweets</h2>
        <div class='tweets-widget'>            
            <ul class='tweet-list'>
            <?php
            foreach($feedData as $tweet) {
                $latestTweet = $tweet->text;
                $latestTweet = preg_replace('/https:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href='https://$1' target='_blank'>https://$1</a>', $latestTweet);
                $latestTweet = preg_replace('/@([a-z0-9_]+)/i', '<a class='tweet-author' href='https://twitter.com/$1' target='_blank'>@$1</a>', $latestTweet);
                $tweetTime = date('D M d H:i:s',strtotime($tweet->created_at));
            ?>
                <li class='tweet-wrapper'>
                    <div class='tweet-thumb'>
                        <span><a href='<?php echo $tweet->user->url; ?>' title='<?php echo $tweet->user->name; ?>'><img alt='' src='<?php echo $tweet->user->profile_image_url; ?>'></a></span>
                    </div>
                    <div class='tweet-content'>
                        <h3 class='title' title='<?php echo $tweet->text; ?>'><?php echo $latestTweet; ?></h3>
                        <span class='meta'><?php echo $tweetTime; ?> - <?php echo $tweet->favorite_count; ?> Favorite</span>
                    </div>
                </li>
            <?php } ?>       
            </ul>
        </div>
    </div>
    ";
    }

 
    function getUserInfo($profilePic, $userName, $userScreenName) {
        return "
        <div class='user-info'>
        <img src='<?php echo $profilePic; ?>' class='img-thumbnail' />
        <h2><?php echo $userName; ?></h2>
        <a href='https://twitter.com/<?php echo $userScreenName; ?>' target='_blank'>@<?php echo $userScreenName; ?></a>
        </div>
            ";
    }

    function getTweetInfo($tweetsNum, $followerNum) {
        return "
        <div class='tweet-info'>
            <div class='fnum'><div>Tweets</div><div class='badge'><?php echo $tweetsNum; ?></div></div>
            <div class='fnum'><div>Followers</div><div class='badge'><?php echo $followerNum; ?></div></div>
        </div>
        ";
    }
}