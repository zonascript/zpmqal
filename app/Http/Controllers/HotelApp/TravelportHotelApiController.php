<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MyLibrary\Verdant\XML2Array;


class TravelportHotelApiController extends Controller
{
	public $provider = '1G';
	public $credentials = '';
	public $requestPath = '';
	public $responsePath = '';
	public $targetBranch = 'P105159';


	public function hotels(Array $params = [])
	{
		$this->hotelRooms();

		$params = [
				"adults" => 2,
				"location" => 'SIN',
				"hotelName" => '',
				"checkInDate" => '2017-06-17',
				"checkOutDate" => '2017-06-19',
			];
		$xmlReq = $this->makeHotelRequestXml($params);
		$xmlRsp = $this->runRequest($xmlReq);
		$xmlToArray = $this->xmlToArray($xmlRsp);
		dd($xmlToArray);
	}


	public function hotelRooms(Array $params = [])
	{
		$params = [
				"hotelChain" => 'HI',
				"hotelCode" => '02591',
				"adults" => 2,
				"location" => 'SIN',
				"name" => '',
				"checkInDate" => '2017-06-17',
				"checkOutDate" => '2017-06-19',
			];
		$xmlReq = $this->makeHotelRoomRequestXml($params);
		$xmlRsp = $this->runRequest($xmlReq);
		$xmlToArray = $this->xmlToArray($xmlRsp);
		dd($xmlToArray);
	}

	public function makeHotelRequestXml(Array $params)
	{
		$params = (object) $params;
		
		$adults = $params->adults;
		$location = $params->location;
		$hotelName = $params->hotelName;
		$checkInDate = $params->checkInDate;
		$checkOutDate = $params->checkOutDate;

		$message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
			<soapenv:Header/>
			<soapenv:Body>
				<hot:HotelSearchAvailabilityReq xmlns:com="http://www.travelport.com/schema/common_v29_0" xmlns:hot="http://www.travelport.com/schema/hotel_v29_0" AuthorizedBy="user" TargetBranch="'.$this->targetBranch.'" TraceId="trace">
					<com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
					<hot:HotelSearchLocation>
						<hot:HotelLocation Location="'.$location.'"/>
					</hot:HotelSearchLocation>
					<hot:HotelSearchModifiers NumberOfAdults="'.$adults.'">
						<com:PermittedProviders>
							<com:Provider Code="'.$this->provider.'"/>
						</com:PermittedProviders>
						<hot:HotelName>'.$hotelName.'</hot:HotelName>
					</hot:HotelSearchModifiers>
					<hot:HotelStay>
						<hot:CheckinDate>'.$checkInDate.'</hot:CheckinDate>
						<hot:CheckoutDate>'.$checkOutDate.'</hot:CheckoutDate>
					</hot:HotelStay>
				</hot:HotelSearchAvailabilityReq>
			</soapenv:Body>
		</soapenv:Envelope>';
		$message = trimHtml($message);

		$this->requestPath = 'request/'.clean(bcrypt(timestamp())).'.xml';
		$this->saveAsFile($message, $this->requestPath);

		return $message;
	}


	public function makeHotelRoomRequestXml(Array $params)
	{
		$params = (object) $params;
		$hotelChain = $params->hotelChain;
		$hotelCode = $params->hotelCode;
		$name = $params->name;
		$adults = $params->adults;
		$checkInDate = $params->checkInDate;
		$checkOutDate = $params->checkOutDate;

		// $message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
		// 	 <soapenv:Header/>
		// 	 <soapenv:Body>
		// 			<hot:HotelDetailsReq TargetBranch="'.$this->targetBranch.'" xmlns:hot="http://www.travelport.com/schema/hotel_v29_0">
		// 				 <com:BillingPointOfSaleInfo OriginApplication="UAPI" xmlns:com="http://www.travelport.com/schema/common_v29_0"/>
		// 				 <hot:HotelProperty HotelChain="'.$hotelChain.'" HotelCode="'.$hotelCode.'"/>
		// 				 <hot:HotelDetailsModifiers NumberOfAdults="'.$adults.'" RateRuleDetail="Complete">
		// 						<com:PermittedProviders xmlns:com="http://www.travelport.com/schema/common_v29_0">
		// 							 <com:Provider Code="'.$this->provider.'"/>
		// 						</com:PermittedProviders>
		// 						<hot:HotelStay>
		// 							 <hot:CheckinDate>'.$checkInDate.'</hot:CheckinDate>
		// 							 <hot:CheckoutDate>'.$checkOutDate.'</hot:CheckoutDate>
		// 						</hot:HotelStay>
		// 				 </hot:HotelDetailsModifiers>
		// 			</hot:HotelDetailsReq>
		// 	 </soapenv:Body>
		// </soapenv:Envelope>';

		$message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
		   <soapenv:Header/>
		   <soapenv:Body>
		      <hot:HotelDetailsReq xmlns:hot="http://www.travelport.com/schema/hotel_v40_0" xmlns:com="http://www.travelport.com/schema/common_v40_0" xmlns:hotel="http://www.travelport.com/schema/hotel_v40_0" TargetBranch="'.$this->targetBranch.'">
		         <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
		         <hotel:HotelProperty HotelChain="'.$hotelChain.'" HotelCode="'.$hotelCode.'"/>
		         <hotel:HotelDetailsModifiers NumberOfAdults="1" NumberOfRooms="1" RateRuleDetail="Complete">
		            <com:PermittedProviders>
		               <com:Provider Code="1G"/>
		            </com:PermittedProviders>
		            <hotel:HotelStay>
		               <hotel:CheckinDate>2017-05-25</hotel:CheckinDate>
		               <hotel:CheckoutDate>2017-05-30</hotel:CheckoutDate>
		            </hotel:HotelStay>
		         </hotel:HotelDetailsModifiers>
		      </hot:HotelDetailsReq>
		   </soapenv:Body>
		</soapenv:Envelope>';

		/*$message = '<HotelDetailsReq xmlns="http://www.travelport.com/schema/hotel_v40_0" TraceId="f476958e-1050-4e49-884a-2e3081f9f98f" AuthorizedBy="Travelport" TargetBranch="'.$this->targetBranch.'" ReturnMediaLinks="true">
		  <BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v40_0" OriginApplication="uAPI" />
		  <HotelProperty HotelCode="'.$hotelCode.'" HotelChain="'.$hotelChain.'" />
		  <HotelDetailsModifiers NumberOfAdults="1" RateRuleDetail="Complete">
		    <PermittedProviders xmlns="http://www.travelport.com/schema/common_v40_0">
		      <Provider Code="1G" />
		    </PermittedProviders>
		    <HotelStay>
		      <CheckinDate>2017-06-18</CheckinDate>
		      <CheckoutDate>2017-06-20</CheckoutDate>
		    </HotelStay>
		  </HotelDetailsModifiers>
		</HotelDetailsReq>';*/

		$this->requestPath = 'request/'.clean(bcrypt(timestamp())).'.xml';
		$this->saveAsFile($message, $this->requestPath);
		return $message;
	}



	public function xmlToArray($xml)
	{
		$array = XML2Array::createArray($xml);
		return $array;
	}


	public function runRequest($message){ // Run the request
		$soap_do = $this->initializeHeader($message); //initialize header

		// Run the request
		$result = curl_exec($soap_do);
		
		if (curl_errno($soap_do) != ''){
			return '<error>something went wrong</error>';
		}

		curl_close($soap_do);

		$this->responsePath = 'response/'.clean(bcrypt(timestamp())).'.xml';
		$this->saveAsFile($result,$this->responsePath);

		return $result;
	}


	public function saveAsFile($data, $name)
	{
		$path = mylocal_path('travelport/hotels/'.$name);
		$myfile = fopen($path, "w") or die("Unable to open file!");
		fwrite($myfile, $data);
		fclose($myfile);
		return $path;
	}


	public function initializeHeader($message){ //Initialize all the header contents
		$auth = base64_encode($this->credentials);
		// Initialize the CURL object with the uAPI endpoint URL
		$soap_do = curl_init ("https://americas.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/HotelService"); // Endpoint URL

		// This is the header of the request
		$header = array(
		"Content-Type: text/xml;charset=UTF-8", 
		"Accept: gzip,deflate", 
		"Cache-Control: no-cache", 
		"Pragma: no-cache", 
		"SOAPAction: \"\"",
		"Authorization: Basic ".$auth, 
		"Content-length: ".strlen($message),
		);		
		
		//curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30); // Timeout options
		//curl_setopt($soap_do, CURLOPT_TIMEOUT, 30); 
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false); // Verify nothing about peer certificates
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); // Verify nothing about host certificate
		curl_setopt($soap_do, CURLOPT_POST, true ); 
		curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message); 
		curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);

		return $soap_do;
	}



	public function __construct()
	{
		$this->credentials = env('TRAVELPORT_USER_ID').':'.env('TRAVELPORT_PASSWORD');
	}


}
