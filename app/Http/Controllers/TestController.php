<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\MyLibrary\Verdant\XML2Array;
use App\Http\Controllers\B2bApp\RoutePackageModesController;
use App\Http\Controllers\FlightApp\QpxFlightsController;
use App\Models\HotelApp\HotelModel;
use Carbon\Carbon;
use App\Mail\VerifyMail;
use Crypt;

class TestController extends Controller
{

	public function testCode()
	{
		dd(Carbon::createFromFormat('Y/m/d h:i', '2017/06/30 00:39')->toDateTimeString());
		// $date = Carbon::parse('2017-05-06T06:50+05:30')->format('Y-m-d H:i');
		// $date1 = Carbon::parse('2017-05-06T09:05+06:30')->format('Y-m-d H:i');
		// dd($date, $date1);

		QpxFlightsController::call()->makeGlobalArray();

		$strin = ' Superior Loft - Breakfast Included 1 twin bed and 1 full bed ';
		// dd(findWord(['breakfast'], $strin));
		$search = ['special', 'offer', '-', 'included', 'breakfast'];
		$remove = ['', '', '', '',''];
		$room = proper(trimHtml(str_replace($search, $remove, strtolower($strin))));
		dd($room);
		$jsondata = '{
			    "nameFile": "Tester file.txt",
			    "ext": "txt",
			    "scanResult": "Valid",
			    "size": 8107
			}';
		$decode = json_decode($jsondata, true);
		dd($decode["size"]);
		$true = null;
		dd(displayNone($true));

		$encrypted = Crypt::encrypt('Hello world.');
		$decrypted = Crypt::decrypt($encrypted);
		dd($encrypted, $decrypted);
		dd(Crypt::encrypt(1));
		dd('email sent');
		$date = Carbon::parse('2017-07-01');
		$now = Carbon::now();
		dd($date->gte($now), $date, $now);

		$array = [
			"SID"  => '$SID',
			"S_Firstname"  => '$S_Firstname',
			"S_Lastname"  => '$S_Lastname',
			"S_Phone"  => '$S_Phone',
			"S_Email"  => '$S_Email\'',
			"User_privledge_no"  => '$User_privledge_no',
			"S_Username"  => '$S_Username',
			"S_Password" => '$S_Password',
		];

		$colums = implode('`, `', array_keys($array));
		$data = addslashes(implode("', '", $array));
		$sql = "INSERT INTO staff (`".$colums."`) VALUES ('".$data."')"; // you can do inline code too
		echo $sql;
		dd();

		$sql = "INSERT INTO staff (`".implode('`, `', array_keys($array))."`) VALUES ('".implode("', '", $array)."')";
		dd();

		$fread = 'is this \item gone yet? \"hmmm\". it\'s a ball.';
		$search= ["\\", "item"]; // use double quote for backslash and escape with backslash
	  $replace=['', ''];
	  $fread = str_replace($search, $replace, $fread);
	  dd($fread);

		$xml = '<cas:serviceResponse xmlns:cas="http://www.yale.edu/tp/cas">
		    <cas:authenticationSuccess>
		        <cas:user>yassine458</cas:user>
		    </cas:authenticationSuccess>
		</cas:serviceResponse>';

		$xml2array = XML2Array::createArray($xml);

		echo $xml2array['cas:serviceResponse']['cas:authenticationSuccess']['cas:user'];
		ddp($xml2array);

		$date = Carbon::createFromFormat('d/m/Y', '15/07/2017');
		$date->subYear(); 
		echo $date->format('d/m/Y'); // Previous year
		dd();

		dd(url('/'));

		dd(mycrypt(329));
		dd(1 == '1.0');
		dd(strlen(md5('202')), md5('202'), strlen('07afea6ad39621bbb718575b5178f5c7'));
		dd(array_diff( [312, 401, 1599, 3], [401] ));
		// $hotel = HotelModel::find(1);
		// dd($hotel->vendor);
		$modes = RoutePackageModesController::call()->model()->find(4);
		dd($modes->mode);

		dd(alpha2num('aa'));
		// include_once app_path('MyLibrary/Verdant/XML2Array.php');

		$xmlPath  = file_get_contents(mylocal_path('test/rsp.xml'));
		$xml2array = XML2Array::createArray($xmlPath);
		ddp($xml2array);
		$obj = simplexml_load_string($xmlPath);


		dd($obj);
		$path = public_path('test/agoda/html/singapore-sg_1492877215.html');
		// $path = public_path('test/agoda/html/singapore-sg_1492877425.html');
		// singapore-sg_1492877215.html
		// singapore-sg_1492877425.html
		$this->extractHtml($path);



		dd(httpGet('https://maps.googleapis.com/maps/api/geocode/json?address=auckland+new+zealand'));
		for ($i=1; $i < 990; $i++) { 
		$lessId = $i*100;
		$longId = ($i+1)*100;
		echo 'mysql -u aashwinjain -p\'Aashwin123#\' -e \'UPDATE `booking_destinations` SET `city_hotel` = (SELECT `city_hotel` FROM booking_hotels WHERE booking_hotels.city_unique = booking_destinations.city_unique LIMIT 1 ) WHERE id > '.$lessId.' AND id <= '.$longId.';'."' trawish_hotels\n\n";
		}

		dd();
		saveInStorage('this is text', 'agoda_rooms', 'html', 'mylocal/testnew');
		dd();
		pre_echo(carbonParse('2017-04-28T14:55')->format('H:i'));
		dd(carbonParse('2017-04-28T14:05'));

		dd(httpGet('https://www.cleartrip.com/flights/international/results?from=SIN&to=DPS&depart_date=27/04/2017&adults=1&childs=0&infants=0&class=Economy&airline=&carrier=&intl=y&sd=1490978924381&page=loaded'));

		$timestamp = 1491065325;
								 // 1490979882
		// echo date('d/m/Y', $timestamp);
		$datetimeFormat = 'Y-m-d H:i:s';

		$date = new \DateTime();
		$date->setTimestamp($timestamp);
		echo $date->format($datetimeFormat);


		/*$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://content.googleapis.com/qpxExpress/v1/trips/search?key=AIzaSyB1AiUDyhG1GDosrt5Qe9Ee-rUTgA2SEmU&alt=json",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "{\"request\":{\"slice\":[{\"origin\":\"DEL\",\"destination\":\"SIN\",\"date\":\"2017-04-27\"}],\"passengers\":{\"adultCount\":2,\"infantInLapCount\":0,\"infantInSeatCount\":0,\"childCount\":0,\"seniorCount\":0},\"solutions\":250,\"refundable\":false}}",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/json",
		    "postman-token: 5cc34775-8ae1-7e33-8e34-ebe197703e39"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}*/
		

	}
	// https://www.booking.com/hotel/za/house-of-house-guest-house.html



	public function sendEmail()
	{
		$test = (object)[
				"email" => "ajay@flygoldfinch.com",
				"name" => "Ajay Kumar",
				"link" => url('/')
			];

		\Mail::to($test)->send(new VerifyMail($test));
	}

	public function extractHtml($path)
	{
		include_once app_path('MyLibrary/simple_html_dom.php');

		$html = file_get_html($path);
		$titleObj = $html->find('td[class=room_col]');
		dd($titleObj);
		$title = isset($titleObj->plaintext) ? $titleObj->plaintext : '';

		$result = false;
		if (findWord('Object moved', $title)) {
			$newUrlObj = $html->find('a', 0);
		}

		return $result;
	}

	public function testBookingHtml()
	{
		$html = httpGet('https://www.booking.com/hotel/za/house-of-house-guest-house.html');
		dd($html);
	}

	public function testClearTrip()
	{
		return view('test.cleartrip');
	}

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

	public function geocode($city){

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
		$file = file_get_contents(storage_path('mylocal/bookings/test.txt'));
		dd($file);
		dd_pre_echo(json_decode($file));
		dd(json_decode($file));
	}


	public function decode()
	{
		$file = file_get_contents(storage_path('mylocal/test/file.json'));
		dd_pre_echo(json_decode($file));
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
