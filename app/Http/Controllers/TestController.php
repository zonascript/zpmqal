<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
	public function test()
	{

		$url = 'http://partners.api.skyscanner.net/apiservices/hotels/liveprices/v2/NZ/USD/en-US/-36.84,174.76-latlong/2017-05-01/2017-05-03/2/1?apiKey=prtl6749387986743898559646983194';

		// $url = 'http://partners.api.skyscanner.net/apiservices/hotels/livedetails/v2/details/H4sIAAAAAAAEAE2IMQ6DMBAE_7L12bo1DgbX1GkIDQihFOks00CF8vecUiGNdkdzYUde8Jwh-FQ3jfbTONiW97G5pvVdlLLXjSn61FoPyuQ0Gi_V_OdWqbcahAI2EkwehNSzlFVQkR1DT35_bQ2jI34AAAA1?apikey=_ClqLu_vLGuMJCqSmDq2Fs6EBKAs5WeiRAE4JWRoGyJipDSzrGM7iyojhHRnUc15A8CIfl_yDMXdeMK164_8O7Q%3D%3D&HotelIds=135466155';

		$result = $this->httpGet($url);

		pre_echo(json_decode($result));
		dd(json_decode($result));

		$city = 'auckland, new zealand';

		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . str_replace (" ", "+", $city) . "&sensor=false";

		return httpGet($url);

		return $this->geocode($city);

		$result = $this->httpGet('https://maps.googleapis.com/maps/api/geocode/json?address=auckland+new+zealand&key=AIzaSyC-IDStnRaA8ueCCENLDL_s0nCzehhTrF0');

		dd($result);
	}

	public function httpGet($url){
		$ch = curl_init();  

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"GET");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		curl_setopt($ch, CURLOPT_HTTPHEADER,[
				'Content-Type: application/x-www-form-urlencoded', 
				'Accept: application/json'
			]);

		$output = curl_exec($ch);

		curl_close($ch);
		return $output;
	}

	function geocode($city){

   $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . str_replace (" ", "+", $city) . "&sensor=false";

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $details_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $geoloc = json_decode(curl_exec($ch), true);

   return $geoloc;
	}


	public function helloTravel($id)
	{
		$html = '';
		if (file_exists(public_path('HT/'.$id.'.html'))) {
			$html = file_get_contents(public_path('HT/'.$id.'.html'));
			$html = str_replace(['<script', '</script>'], ['<div hidden', '</div>'], $html);
		}
		return view('public.hello_travel', ['html' => $html,'id' => $id]);
	}

	public function saveHelloTravel($id, Request $request)
	{
		$files = listFolderFiles(public_path('HT'));


		$html = file_get_contents(public_path('ht_a/index.html'));
		$data = $html.$request->html;

		$myfile = fopen(public_path('ht_a/index.html'), "w") or die("Unable to open file!");
		fwrite($myfile, $data);
		fclose($myfile);

		if ($id < count($files)+1) {
			$id = $id+1;
			return url('hellotravel').'/'.$id;
		}else{
			return 'done';
		}
	}

	public function showfile()
	{
		$file = file_get_contents(storage_path('bookings/test.txt'));
		dd($file);
		dd_pre_echo(json_decode($file));
		dd(json_decode($file));
	}

	public function getAgodaHtml()
	{
		$rawHtml = $this->httpGetAgoda($url);
		$filePath = saveInStorage($response, 'knysna-za', 'html', 'agoda');

		$html = file_get_contents(storage_path('agoda/knysna-za_1489687261.html'));
		preg_match_all("/images\s*:\s*\[.*?\],/s", $html, $matches);
		$images = $matches[0][0];
		$images = ltrim($images,"images: ");
		$images = rtrim($images,",");
		$images = json_decode($images);
		// dd(json_decode($images));
		include app_path('MyLibrary/simple_html_dom.php');
		// $url = 'https://www.agoda.com/the-russel-hotel/hotel/knysna-za.html';
		$url = 'http://b2b.flygoldfinch.dev/agoda_text.html';
		$html = file_get_html(storage_path('agoda/test.html'));
		$rooms = [];

		foreach($html->find('tr') as $row) {
	    $tdTexts = $row->find('td[class=room_col]',0);
	    if (!is_null($tdTexts)) {
		    $roomtypeObj = $tdTexts->find('span', 0);
		    $roomtype = '';
				if(isset($roomtypeObj->plaintext)){
	    		$roomtype = $roomtypeObj->plaintext;
				}

				$imgObj = $tdTexts->find('img', 0);
		    $img = '';
				if(isset($imgObj->src)){
	    		$img = $imgObj->src ;
				}

	   		$rooms[] = ['roomtype' => $roomtype, 'image' => $img];
	    }
		}
		$result = (object)["rooms" => $rooms, "images" => $images];
		dd_pre_echo($result);
		
	}

	public function httpGetAgoda($url)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYPEER=> false,
		  // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		return $response;
	}

	public function fixData()
	{
		$file = file_get_contents('D:/apis/Booking/data/Asia_1.tsv');
		$file = str_replace('\\t\\n\\r', '[@]', $file);
		fopen('D:/apis/Booking/data_new/Asia_1.tsv', "w") or die("Unable to open file!");
		fwrite($myfile, $data);
		fclose($myfile);
	}

	

}
