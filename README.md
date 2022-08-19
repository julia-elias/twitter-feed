# twitter-feed
Installation, activation, and uninstallation functions are included in the my-twitter-feed.php file. 

I have included the twitterapi folder in the repository in case I decide to use the TwitterOAuth library, but for now, I am trying to use the class included in the twitterAPI.php file to connect to the Twitter API and retrieve the most recent posts.

The problem that I am having is in the my-twitter-feed.php file, where I add an action hook in the activate() function so that the Twitter data is collected and a feed is generated whenever the wp_footer is called. However, I am not able to view the html that is supposed to be shown. The action hook that I added is supposed to call the displayFeed() function, which is also included in the my-twitter-feed.php file. At the moment, this function is just supposed to display "hello" as a test run, but in the future, it will be calling getFeed() and will be calling the needed functions from the twitterSlide.php file (whuich still needs fixed) in order to generate the Twitter feed on the webpage.
