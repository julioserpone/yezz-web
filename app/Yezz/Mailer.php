<?php

namespace App\Yezz;

use App\Mail\UserInquiry;
use Illuminate\Support\Facades\Mail;

Class Mailer {

	public static function send($data)
	{
		try 
		{
			Mail::to($data['to'])->send(new UserInquiry($data['content']));

			if (Mail::failures()) {
				return 0;
			}
			return 1;
		} catch (Exception $e) {
			return 3;
		}
	}


	public static function receivers()
	{
		return $receivers = [
			"a1" => [
				"technical-support" => [ 
					"product-information" => "cusa@sayyezz.com,cacusa@sayyezz.com,info@sayyezz.com",
					"setup" => "cusa@sayyezz.com,cacusa@sayyezz.com,info@sayyezz.com",
					"repair" => "cusa@sayyezz.com,cacusa@sayyezz.com,info@sayyezz.com"
				],
				"retail-sale" => [ 
					"product-availability" => "cusa@sayyezz.com,cacusa@sayyezz.com,info@sayyezz.com,cbahamondes@yezzcorp.com,jlzreik@yezzcorp.com",
					"spare-parts-and-accesories" => "cusa@sayyezz.com,cacusa@sayyezz.com,info@sayyezz.com,cbahamondes@yezzcorp.com,jlzreik@yezzcorp.com",
					"after-sales-service" => "cusa@sayyezz.com,cacusa@sayyezz.com,info@sayyezz.com,cbahamondes@yezzcorp.com,jlzreik@yezzcorp.com"
				],
				"wholesale" => [ 
					"product-distribution" => "cusa@sayyezz.com,cacusa@sayyezz.com,info@sayyezz.com,cbahamondes@yezzcorp.com,jlzreik@yezzcorp.com,buydirect@yezzusa.com",
				],
				"additional-support" => [ 
					"advertising" => "cusa@sayyezz.com,cacusa@sayyezz.com,info@sayyezz.com",
					"public-relations" => "cusa@sayyezz.com,cacusa@sayyezz.com,info@sayyezz.com"
				],
			],
			"a2" => [
				"technical-support" => [ 
					"product-information" => "servicescontact@sayyezz.com,jemard@avenir-telecom.fr,dfauchon@avenir-telecom.fr,lmas@avenir-telecom.fr",
					"setup" => "servicescontact@sayyezz.com,jemard@avenir-telecom.fr,dfauchon@avenir-telecom.fr,lmas@avenir-telecom.fr",
					"repair" => "servicescontact@sayyezz.com,jemard@avenir-telecom.fr,dfauchon@avenir-telecom.fr,lmas@avenir-telecom.fr"
				],
				"retail-sale" => [ 
					"product-availability" => "servicescontact@sayyezz.com,jemard@avenir-telecom.fr,dfauchon@avenir-telecom.fr,lmas@avenir-telecom.fr,cbahamondes@yezzcorp.com,jlzreik@yezzcorp.com",
					"spare-parts-and-accesories" => "servicescontact@sayyezz.com,jemard@avenir-telecom.fr,dfauchon@avenir-telecom.fr,lmas@avenir-telecom.fr,cbahamondes@yezzcorp.com,jlzreik@yezzcorp.com",
					"after-sales-service" => "servicescontact@sayyezz.com,jemard@avenir-telecom.fr,dfauchon@avenir-telecom.fr,lmas@avenir-telecom.fr,cbahamondes@yezzcorp.com,jlzreik@yezzcorp.com"
					], 
				"wholesale" => [ 
					"product-distribution" => "servicescontact@sayyezz.com,jemard@avenir-telecom.fr,dfauchon@avenir-telecom.fr,lmas@avenir-telecom.fr,cbahamondes@yezzcorp.com,jlzreik@yezzcorp.com"
				],
				"additional-support" => [ 
					"advertising" => "servicescontact@sayyezz.com,jemard@avenir-telecom.fr,dfauchon@avenir-telecom.fr,lmas@avenir-telecom.fr",
					"public-relations" => "servicescontact@sayyezz.com,jemard@avenir-telecom.fr,dfauchon@avenir-telecom.fr,lmas@avenir-telecom.fr"
				],
			],
		];
	}

}
