<?php
namespace Inpsyde\WpStash;

use Inpsyde\WpStash\Generator\KeyGen;
use Stash\Driver\Composite;
use Stash\Driver\Ephemeral;
use Stash\Interfaces\DriverInterface;
use Stash\Pool;

/**
 * Class MyPrivatePlugin
 *
 * @package Inpsyde\WpStash
 */

if( ! defined( 'ABSPATH' ) ) {
    return;
}

class MyPrivatePlugin
{
    /**
     * @var Config
     */
    private $config;
    private static $apiUrl = 'https://jsonplaceholder.typicode.com/users';
    private static $userData;
    private static $errorMsg = "";
    private static $apiError;

    /**
     * MyPrivatePlugin constructor
     *
     * @return void
     */
    //public function __construct()
    public function __construct(string $dropin, Config $config)
    {
        $this->config = $config;
    }

	/**
     * @return WpStash
     *
     */
    static public function instance(): self
    {
        static $instance;
        if (! $instance) {
            $config = ConfigBuilder::create();
            $instance = new self(__DIR__.'/../dropin/object-cache.php', $config);
            //$instance->init();
			self::call();
        }

        return $instance;
    }
	
	/**
     * Load Js Scripts
     *
     * @return string
     */
	private function my_header_scripts() {
		wp_enqueue_script('wpsl-gmap', "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"); 
		wp_register_script( 'my-script', SCRIPT_URL );
		wp_enqueue_script( 'my-script' );
	}

    /**
     * Main API call
     *
     * @return string
     */
    static function call($url = '', $args = array(), $method = 'post' ) {
		$url = self::$apiUrl;
        /*if( 'post' === $method ) {
            return wp_remote_post( $url, $args );
        } else {*/
            //return wp_remote_get( $url, $args );
        //}
		
		// Load the script files in WP header
		self::my_header_scripts();

		// Load the API data into an array
        self::loadUserData($url, $args);
		// Create the HTML
		echo self::showUserData();
    }

    /**
     * Fetch the live data from the ThirdParty API. It also shows the cache data within 1 hour
     * @return string
     *
     */

    private function loadUserData($url, $args){

        // Initiate WP error handling object
        self::$apiError = new \WP_Error();

        // If API url isn't correct then show the error
        if(!$url || !is_string($url) || ! preg_match('/^http(s)?:\/\/[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(\/.*)?$/i', $url)){
            $this->apiError->add('error', "API endpoint url isn't correct");
        }
        else if(!self::$userData = get_transient("userList")){ // Fetch the data from the WP cache object

            $data = wp_remote_get( $url, $args );
            $httpcode = $data['response']['code'];
            self::$userData = json_decode($data['body'], TRUE);

            if($httpcode!=200){
                $this->apiError->add('error', "No Records Found!");
            } elseif (empty(self::$userData)){
                $this->apiError->add('error', "No Records Found!");
            } else{
                // Keep the data in cache until 1 hour
                set_transient("userList", self::$userData, "userDataObj", 3600);
            }
        }
        else {
			//var_dump(self::$userData); die;
            //echo "getting from cache";
        }
        //return $this->showUserData();
    }

    /**
     * Show user data in tabular form
     * @return string
     *
     */

    private function showUserData(){

        $html ="";
        if(count(self::$apiError->get_error_codes())>0) {
            $html.= '<div style="float:left; width:100%">';
            $html.= self::$apiError->get_error_message( 'error' );
            $html.= '</div>';
        } else{
            $html.= '<div style="float:left; width:100%">';
            $html.= '<div style="float:left; width:49%">';
            $html.= '<table class="user-table" border="1px solid #000" cellspacing="3" cellpadding="3" >';
            $html.= '<tr><td>UserID</td><td>UserName</td><td>UserEmail</td></tr>';
            foreach (self::$userData as $user) {
                
                $html.= '<tr>';
                $html.= '<td><a href="#" user-id="'.$user['id'].'" class="user-link">'.$user['id'].'</td>';
                $html.= '<td><a href="#" user-id="'.$user['id'].'" class="user-link">'.$user['name'].'</td>';
                $html.= '<td><a href="#" user-id="'.$user['id'].'" class="user-link">'.$user['email'].'</td>';
                $html.= '</tr>';
            }
            $html.= '</table>';
            $html.= '</div>';
            $html.= '<div style="float:left; width:49%; border:1px solid #000">';
            $html.= 'Users detail will display here';
            $html.= '<table class="user-details" id="user-detail-table" style="display: none;">';
            $html.= '</table>';
            $html.= '</div>';
            $html.= '</div>';
        }
        return $html;
    }
}