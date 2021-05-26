<?php
/**
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Recent tweets
*
* @version  2.0
*****************************************************
*/

/*
*****************************************************
*      ACTIONS AND FILTERS
*****************************************************
*/
add_action( 'widgets_init', 'reg_wm_twitter' );



/*
* Widget registration
*/
function reg_wm_twitter() {
	register_widget( 'wm_twitter' );
} // /reg_wm_contact_info





/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/
class wm_twitter extends WP_Widget {

	/**
	 * @var  string Transient cache variable name (saving user data)
	 */
	private $user_transient;

	/**
	 * @var  string Option name storing tweets cache
	 */
	private $tweets_option;

	/**
	 * @var  string Option name to store Twitter API variables
	 */
	private $twitter_api;



	/*
	*****************************************************
	*      widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'wm-twitter';
		$name = '<span>' . WM_THEME_NAME . ' ' . __( 'Twitter', 'clifden_domain_adm' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'wm-twitter',
			'description' => __( 'Displays your recent tweets', 'clifden_domain_adm' )
			);
		$control_ops = array();

		//Set globals
		$this->user_transient = WM_THEME_SHORTNAME . '_twitter_v2_user_';
		$this->tweets_option  = WM_THEME_SHORTNAME . '_twitter_v2_tweets_';
		$this->twitter_api    = WM_THEME_SHORTNAME . '_twitter_v2_api';

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
	} // /__construct



	/*
	*****************************************************
	*      widget options form in admin
	*****************************************************
	*/
	function form( $instance ) {
		extract( $instance );

		$title    = ( isset( $title ) ) ? ( $title ) : ( null );
		$username = ( isset( $username ) ) ? ( $username ) : ( null );
		$count    = ( isset( $count ) && 0 < absint( $count ) ) ? ( absint( $count ) ) : ( 3 );
		$userinfo = ( isset( $userinfo ) ) ? ( $userinfo ) : ( null );
		$replies  = ( isset( $replies ) ) ? ( $replies ) : ( null );

		//Twitter API 1.1
		$twitterApi          = get_option( $this->twitter_api );
		$consumer_key        = ( isset( $twitterApi['consumer_key'] ) ) ? ( $twitterApi['consumer_key'] ) : ( '' );
		$consumer_secret     = ( isset( $twitterApi['consumer_secret'] ) ) ? ( $twitterApi['consumer_secret'] ) : ( '' );
		$access_token        = ( isset( $twitterApi['access_token'] ) ) ? ( $twitterApi['access_token'] ) : ( '' );
		$access_token_secret = ( isset( $twitterApi['access_token_secret'] ) ) ? ( $twitterApi['access_token_secret'] ) : ( '' );

		//HTML to display widget settings form
		?>
		<p class="wm-desc"><?php _e( 'Displays recent tweets from specific Twitter account. Also displays Twitter account details. Tweets are being cached to reduce the page load.', 'clifden_domain_adm' ) ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'clifden_domain_adm' ) ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Twitter username:', 'clifden_domain_adm' ) ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of tweets to display:', 'clifden_domain_adm' ) ?></label><br />
			<input class="text-center" type="number" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $count; ?>" size="5" maxlength="2" min="1" max="10" />
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'userinfo' ); ?>" name="<?php echo $this->get_field_name( 'userinfo' ); ?>" type="checkbox" <?php checked( $userinfo, 'on' ); ?>/>
			<label for="<?php echo $this->get_field_id( 'userinfo' ); ?>"><?php _e( 'Display Twitter user info', 'clifden_domain_adm' ); ?></label>
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'replies' ); ?>" name="<?php echo $this->get_field_name( 'replies' ); ?>" type="checkbox" <?php checked( $replies, 'on' ); ?>/>
			<label for="<?php echo $this->get_field_id( 'replies' ); ?>"><?php _e( 'Display reply tweets', 'clifden_domain_adm' ); ?></label>
		</p>

		<p class="wm-desc-separator">
			<strong><?php _e( 'Twitter API settings', 'clifden_domain_adm' ) ?></strong><br />
			<?php _e( 'To set the fields below you need to <a href="https://dev.twitter.com/apps" target="_blank">create a Twitter Application</a>. See theme user manual for more info.', 'clifden_domain_adm' ) ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'consumer_key' ); ?>"><?php _e( 'Consumer key:', 'clifden_domain_adm' ) ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'consumer_key' ); ?>" name="<?php echo $this->get_field_name( 'consumer_key' ); ?>" type="text" value="<?php echo esc_attr( $consumer_key ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'consumer_secret' ); ?>"><?php _e( 'Consumer secret:', 'clifden_domain_adm' ) ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'consumer_secret' ); ?>" name="<?php echo $this->get_field_name( 'consumer_secret' ); ?>" type="text" value="<?php echo esc_attr( $consumer_secret ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'access_token' ); ?>"><?php _e( 'Access token:', 'clifden_domain_adm' ) ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'access_token' ); ?>" name="<?php echo $this->get_field_name( 'access_token' ); ?>" type="text" value="<?php echo esc_attr( $access_token ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'access_token_secret' ); ?>"><?php _e( 'Access token secret:', 'clifden_domain_adm' ) ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'access_token_secret' ); ?>" name="<?php echo $this->get_field_name( 'access_token_secret' ); ?>" type="text" value="<?php echo esc_attr( $access_token_secret ); ?>" />
		</p>

		<?php
	} // /form



	/*
	*****************************************************
	*      process and save the widget options
	*****************************************************
	*/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$old_instance = array(
				'username' => isset( $instance['username'] ) ? ( $instance['username'] ) : ( '' ),
				'count'    => isset( $instance['count'] ) ? ( $instance['count'] ) : ( '' ),
			);

		$instance['title']    = $new_instance['title'];
		$instance['username'] = sanitize_title( trim( strip_tags( $new_instance['username'] ) ) ); //remove non-alfanumeric characters
		$count                = ( 0 < absint( $new_instance['count'] ) ) ? ( absint( $new_instance['count'] ) ) : ( 3 );
		$instance['count']    = $count;
		$instance['userinfo'] = $new_instance['userinfo'];
		$instance['replies']  = $new_instance['replies'];

		//Twitter API 1.1
		$twitterApi                        = array();
		$twitterApi['consumer_key']        = trim( $new_instance['consumer_key'] );
		$twitterApi['consumer_secret']     = trim( $new_instance['consumer_secret'] );
		$twitterApi['access_token']        = trim( $new_instance['access_token'] );
		$twitterApi['access_token_secret'] = trim( $new_instance['access_token_secret'] );
		//remove empty values
		$twitterApi = array_filter( $twitterApi );
		//save Twitter API variables globally
		update_option( $this->twitter_api, $twitterApi );

		//Flush Tweets cache if username or count changed
		if (
				$instance['username'] != $old_instance['username']
				|| $instance['count'] != $old_instance['count']
			) {
			delete_transient( WM_THEME_SHORTNAME . '_tweets_id_' . esc_attr( $instance['username'] ) );
		}

		return $instance;
	} // /update



	/*
	*****************************************************
	*      output the widget content
	*****************************************************
	*/
	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$username = ( isset( $username ) ) ? ( $username ) : ( '' );
		$replies  = ( isset( $replies ) && $replies ) ? ( false ) : ( true );
		$count    = ( isset( $count ) && 0 < absint( $count ) ) ? ( absint( $count ) ) : ( 3 );
		if ( 10 < $count ) {
			$count = 10;
		}
		$user = $tweets = array();

		//Twitter API 1.1
		$twitterApi          = get_option( $this->twitter_api );
		$consumer_key        = ( isset( $twitterApi['consumer_key'] ) ) ? ( $twitterApi['consumer_key'] ) : ( '' );
		$consumer_secret     = ( isset( $twitterApi['consumer_secret'] ) ) ? ( $twitterApi['consumer_secret'] ) : ( '' );
		$access_token        = ( isset( $twitterApi['access_token'] ) ) ? ( $twitterApi['access_token'] ) : ( '' );
		$access_token_secret = ( isset( $twitterApi['access_token_secret'] ) ) ? ( $twitterApi['access_token_secret'] ) : ( '' );

		//Get tweets
		if (
				$consumer_key
				&& $consumer_secret
				&& $access_token
				&& $access_token_secret
			) {

			//Names of options storing cached data
			$userOption   = $this->user_transient . esc_attr( $username );
			$tweetsOption = $this->tweets_option . esc_attr( $username );

			//Get cache (per user name) if available
			$user = get_transient( $userOption );
			// $user = ''; //For debugging

			if ( $user ) {
			//get cached tweets
				$tweets = get_option( $tweetsOption );
			} else {
			//get new tweets and set new cache
				//Load the helper class
				require_once 'twitter-api/twitteroauth.php';

				//Set the connection
				$twitterConnection = new TwitterOAuth(
						$consumer_key,
						$consumer_secret,
						$access_token,
						$access_token_secret
					);

				//Get the tweets
				$tweets = $twitterConnection->get(
						'statuses/user_timeline',
						array(
								'screen_name'     => $username,
								'count'           => 12,
								'exclude_replies' => $replies
							)
					);

				if ( 200 != $twitterConnection->http_code ) {
				//if response is not "OK", just get cached tweets
					$tweets = get_option( $tweetsOption, $tweets );
				} elseif ( ! empty( $tweets ) ) {
				//if we get tweets, process them
					$i = 0;
					$tweetsProcessed = array();
					foreach ( $tweets as $tweet ) {
						$i++;
						if ( 1 === $i && isset( $tweet->user ) ) {
							$user = array(
									'name'        => (string) $tweet->user->name,
									'screen_name' => (string) $tweet->user->screen_name,
									'description' => (string) $tweet->user->description,
									'image'       => (string) $tweet->user->profile_image_url,
									'utc_offset'  => ( isset( $tweet->user->utc_offset ) ) ? ( (int) $tweet->user->utc_offset ) : ( 0 ),
									'followers'   => absint( $tweet->user->followers_count )
								);
						}
						$tweetsProcessed[] = array(
								'text'    => trim( $this->wm_filter_tweet( $tweet->text ) ),
								'created' => strtotime( $tweet->created_at )
							);
						if ( $count === $i ) {
							break;
						}
					}
					$tweets = $tweetsProcessed;
				}

				//Set cache
				if ( $user ) {
					set_transient( $userOption, $user, WM_TWITTER_CACHE_EXPIRATION );
				}
				update_option( $tweetsOption, $tweets );
			}
		}

		//Outputting the widget HTML
		$out = $before_widget;

		//if the title is not filled, no title will be displayed
		if ( isset( $title ) && '' != $title && ' ' != $title ) {
			$out .= $before_title . apply_filters( 'widget_title', $title ) . $after_title;
		}

		//$out .= $this->wm_get_tweet( $count, $username, $userinfo );
		if ( $tweets ) {
			$outUser    = $outTweets = '';
			$timeFormat = get_option( 'date_format' ) . ', ' . get_option( 'time_format' );

			//output user info
			if ( $userinfo && ! empty( $user ) ) {
				$outUser .= '<div class="user-info">';
				$outUser .= '<a href="http://twitter.com/' . $username . '"><img src="' . $user['image'] . '" alt="' . $user['screen_name'] . '" title="' . $user['screen_name'] . '" /></a>';
				$outUser .= '<h3><a href="http://twitter.com/' . $username . '">' . $username . '</a></h3>';
				$outUser .= ( $user['description'] ) ? ( $user['description'] ) : ( '' );
				$outUser .= '</div>';
			}

			//output tweets list
			if ( is_array( $tweets ) && ! empty( $tweets ) ) {
				foreach ( $tweets as $tweet ) {
					if ( isset( $tweet['text'] ) ) {
						$outTweets .= '<li class="icon-twitter">' . $tweet['text'];
						$outTweets .= ( $user ) ? ( '<div class="tweet-time">' . date_i18n( $timeFormat, $tweet['created'] + $user['utc_offset'] ) . '</div>' ) : ( '' );
						$outTweets .= '</li>';
					}
				}
			}

			$out .= $outUser . '<ul>' . $outTweets . '</ul>';
		} else {
			$out .= do_shortcode( '[box color="red" icon="warning"]' . __( 'No tweets.', 'clifden_domain' ) . '[/box]' );
		}

		echo $out . $after_widget;
	} // /widget



	/*
	* Filter tweets
	*
	* $text = TEXT [text to process]
	*/
	private function wm_filter_tweet( $text ) {
		//fix for some special characters that might be in the actual tweet, but breaks WP database record (breaks serialization of array)
		$text = esc_textarea( $text );
		$text = html_entity_decode( str_replace( '&#039;', "'", $text ) );

		//create links from Twitter predefined strings
		$text = preg_replace(
			'/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',
			"<a href=\"$1\" class=\"twitter-link\">$1</a>",
			$text );
		$text = preg_replace(
			'/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',
			"<a href=\"http://$1\" class=\"twitter-link\">$1</a>",
			$text );
		$text = preg_replace(
			"/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i",
			"<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>",
			$text );
		$text = preg_replace(
			"/#(\w+)/",
			"<a class=\"twitter-link\" href=\"http://search.twitter.com/search?q=\\1\">#\\1</a>",
			$text );
		$text = preg_replace(
			"/@(\w+)/",
			"<a class=\"twitter-link\" href=\"http://twitter.com/\\1\">@\\1</a>",
			$text );

		return $text;
	} // /wm_filter_tweet
} // /wm_twitter

?>