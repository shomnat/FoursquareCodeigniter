<?php

class FoursquareController extends Controller {

        public $foursquareObj;

	function FoursquareController()
	{
		parent::Controller();
                $this->load->library('session');
                $this->load->library('foursquare');
	}

	public function callback()
	{
		// Please put in your keys here.
                //echo $_REQUEST['oauth_token'];
		$consumer_key = 'your_consumer_key';
		$consumer_secret = 'your_consumer_secret';
                $foursquareObj = new $this->foursquare($consumer_key, $consumer_secret);
                //echo($_REQUEST['oauth_token']);
                $foursquareObj->setToken($_REQUEST['oauth_token'],$this->session->userdata('secret'));
                $token = $foursquareObj->getAccessToken();
                $foursquareObj->setToken($token->oauth_token, $token->oauth_token_secret);


                                try {
                    //Making a call to the API

                $history = $foursquareObj->get_history();
                $checkins = $history->response['checkins'];
                $number_of_checkins = count($checkins);



                echo "<p> Your total number of check ins is $number_of_checkins </p> ";
                echo "<p>";
                echo "<table border=\"1\" align=\"center\">";
                echo "<tr><th>Name</th>";
                echo "<th>Date</th>";
                echo "<th>Icon</th></tr>";

                for ( $counter = 0; $counter < $number_of_checkins; $counter += 1) {

                    $checkin = $checkins[$counter];
                    $checkin_venue = $checkin['venue'];
                    $checkin_venue_name = $checkin_venue['name'];
                    $checkin_date = $checkin['created'];
                    $checkin_venue_pcategory = $checkin_venue['primarycategory'];
                    $checkin_venue_pcategory_iconurl = $checkin_venue_pcategory['iconurl'];

                        echo "<tr><td>";
                        echo $checkin_venue_name;
                        echo "</td><td>";
                        echo $checkin_date;
                        echo "</td><td>";
                        echo "<img src=\"$checkin_venue_pcategory_iconurl\">";
                        echo "</td></tr>";
                }
                echo "</table>";
                echo "</p>";



                 } catch (Exception $e) {
                   echo "Error: " . $e;
                 }


	}

        function index() {

            try
            {
            // Please put in your keys here.
            $consumer_key = 'your_consumer_key';
	    $consumer_secret = 'your_consumer_secret';

            $foursquareObj = new $this->foursquare($consumer_key, $consumer_secret);
            $results = $foursquareObj->getAuthorizeUrl();

            $loginurl = $results['url'] . "?oauth_token=" . $results['oauth_token'];

            $this->session->set_userdata('secret', $results['oauth_token_secret']);
            }
            catch (Execption $e) {
                  //If there is a problem throw an exception
                }

            echo "<a href='" . $loginurl . "'>Login Via Foursquare</a>";
           //Display the Foursquare login link
            echo "<br>";

        }



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/home.php */