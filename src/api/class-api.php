<?php
namespace My_Plugin\API;

/**
 * Class API
 *
 * @package My_Plugin\API
 */

if( ! defined( 'ABSPATH' ) ) {
    return;
}

class API
{
    /**
     * @var Config
     */
    private $config;
    private $apiUrl = 'https://jsonplaceholder.typicode.com/users';
    //private $apiUrl = 'https://jsonplaceholder.com/users';
    private $userData;
    private $errorMsg = "";
    private $apiError;

    /**
     * API constructor
     *
     * @return void
     */
    public function __construct()
    //public function __construct(string $dropin, Config $config)
    {
        $this->config = $config;
    }

    /**
     * Main API call
     *
     * @return string
     */
    public function call( $url = '', $args = array(), $method = 'post' ) {
        $url = $this->apiUrl;
        /*if( 'post' === $method ) {
            return wp_remote_post( $url, $args );
        } else {*/
            //return wp_remote_get( $url, $args );
        //}
        return $this->loadUserData($url, $args);
    }

    /**
     * Fetch the live data from the ThirdParty API. It also shows the cache data within 1 hour
     * @return string
     *
     */

    private function loadUserData($url, $args){

        // Initiate WP error handling object
        $this->apiError = new \WP_Error();

        // If API url isn't correct then show the error
        if(!$url || !is_string($url) || ! preg_match('/^http(s)?:\/\/[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(\/.*)?$/i', $url)){
            $this->apiError->add('error', "API endpoint url isn't correct");
        }
        else if(!$this->userData = get_transient("userList")){ // Fetch the data from the WP cache object

            $data = wp_remote_get( $url, $args );
            $httpcode = $data['response']['code'];
            $this->userData = json_decode($data['body'], TRUE);

            if($httpcode!=200){
                $this->apiError->add('error', "No Records Found!");
            } elseif (empty($this->userData)){
                $this->apiError->add('error', "No Records Found!");
            } else{
                // Keep the data in cache until 1 hour
                set_transient("userList", $this->userData, "userDataObj", 3600);
            }
        }
        else {
            //echo "getting from cache";
        }
        return $this->showUserData();
    }

    /**
     * Show user data in tabular form
     * @return string
     *
     */

    private function showUserData(){

        $html ="";
        if(count($this->apiError->get_error_codes())>0) {
            $html.= '<div style="float:left; width:100%">';
            $html.= $this->apiError->get_error_message( 'error' );
            $html.= '</div>';
        } else{
            $html.= '<div style="float:left; width:100%">';
            $html.= '<div style="float:left; width:49%">';
            $html.= '<table class="user-table" border="1px solid #000" cellspacing="3" cellpadding="3" >';
            $html.= '<tr><td>UserID</td><td>UserName</td><td>UserEmail</td></tr>';
            foreach ($this->userData as $user) {
                
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