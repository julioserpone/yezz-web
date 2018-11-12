<?php 

use \Torann\GeoIP\GeoIP;


namespace App\Yezz;


class Location
{
	function getIP() {
		return ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) ? $_SERVER['HTTP_CLIENT_IP'] : ( ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'] );
	}

	public static function setLang($lang){
		\App::setlocale($lang);
	}

	public static function setLocation()
    { 
    	  $obj  = new Location;
          $uip  = $obj->getIP();
          $gip  = geoip()->getLocation($uip);
          $code = array();
          $code['language'] = "en";
          $code['country']  = "";
          if($gip!=null)
          {
            $client_country = $gip->iso_code;
            $client_country = strtolower($client_country);
            $code['country']= $client_country;
            $country_language = \App\Country::select('languages.code')
            ->join('languages','language_id','=','languages.id')
            ->where('countries.code',$client_country)
            ->first();
            
            if($country_language!=null)
            {
              $code['language'] = $country_language->code;
            }else{
              $code['language'] = "en";
            }

          }else{
            $code['language'] = "en";
          }


          return $code;
        }



}


?>