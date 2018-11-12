<?php
	function getIP() {
		return ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) ? $_SERVER['HTTP_CLIENT_IP'] : ( ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'] );
	}	
	
	function locateByIP() {
		$ip = getIP(); // Real IP
		//$ip = '50.243.250.102'; // USA Office
		//$ip = '190.8.168.76'; // Venezuela Office
		//$ip = '62.106.66.69'; // France Office
		include_once( 'geo-tagging/geoip.inc' );
		$geoIP = geoip_open( 'geo-tagging/GeoIP.dat', GEOIP_STANDARD );
		$geoIPv6 = geoip_open( 'geo-tagging/GeoIPv6.dat', GEOIP_STANDARD );
		return ( geoip_country_code_by_addr( $geoIP, $ip ) ) ? geoip_country_code_by_addr( $geoIP, $ip ) : ( ( geoip_country_code_by_addr_v6( $geoIPv6, $ip ) ) ? geoip_country_code_by_addr_v6( $geoIPv6, $ip ) : false );
	}

	$location = strtolower( locateByIP() );