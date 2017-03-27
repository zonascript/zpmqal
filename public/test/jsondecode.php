<?php 
require __DIR__.'/../../app/Http/helpers.php';

echo var_dump(substr('2017-04-16 00:00:00', 10));

$recoveredData = file_get_contents('file.json');
$recoveredArrays = json_decode($recoveredData, true);
pre_echo($recoveredArrays);

exit;

$table = [];

for ($i=1; $i <= 10 ; $i++) { 
	$table[] = [
			"id" => $i,
			"title" => "A".$i,
			"text" => [
					"subject" => "Subject".$i,
					"word" => "Lorem ipsum dolor sit amet..."
				],
		];
}
echo '<table>
			<tr>
				<th>id</th>
				<th>title</th>
				<th>text</th>
			</tr>';
foreach ($table as $key => $value) {
	echo '<tr>
		<td>'.$value['id'].'</td>
		<td>'.$value['title'].'</td>
		<td>'.$value['text'].'</td>
	</tr>';
}
echo '</table>';
pre_echo(json_decode(json_encode($table)));

echo urlencode('api_version=5
&hotels=[{"ta_id":97497,"partner_id":"229547","partner_url":"http://partner.com/deeplink/to/229547"},{"ta_id":97832,"partner_id":"id34234","partner_url":"http://partner.com/deeplink/to/id34234"}]
&start_date=2013-07-01
&end_date=2013-07-03
&party=[{“adults": 2}]
&lang=en_US
&currency=USD
&user_country=US
&device_type=d
&query_key=6167a22d1f87d2028bf60a8e5e27afa7_191_1360299600000_2_2');

echo "<br/><br/><br/>";


var_dump(14 % 5);
if (2 % 2 == 0) {
	echo 'even';
	var_dump('even');
}


$a=array("a"=>"red","b"=>"green","c"=>"blue");
$a[] = array_shift($a);
// pre_echo($a);


// var_dump(!is_object(json_decode('')));

$a1 = [
	"request" => [
		"slice" => [
			[
				"origin" => null,
				"destination" => null,
				"date" => null,
			]
		],
		"passengers" => [
			"adultCount" => null,
			"infantInLapCount" => null,
			"infantInSeatCount" => 0,
			"childCount" => null,
			"seniorCount" => 0
		],
		"solutions" => 1000,
		"refundable" => false
	]
];

$a2 = [
	"request" => [
		"slice" => [
			[
				"origin" => 12,
				"destination" => 21,
				"date" => 214,
			],
			[
				"origin" => 54,
				"destination" => 64,
				"date" => 76,
			]
		],
		"passengers" => [
			"adultCount" => null,
			"infantInLapCount" => null,
			"infantInSeatCount" => 0,
			"childCount" => null,
			"seniorCount" => 0
		],
		"solutions" => 1000,
		"refundable" => false
	]
];

// dd_pre_echo(array_merge($a1, $a2));

// $date = "2017-03-12T07:00+08:00";

// $date = new DateTime('2012-09-09T21:24:34Z');
// echo $date->format('Y-m-d H:i:s'); 


// $a = 'http://images.flygoldfinch.dev/';

// if (preg_match('/http:// /',$a))
    // echo 'true';

// if (strpos($a, 'http://') !== false) {
//     echo 'true';
// }

// $stack = array("banana", "orange", "apple", "raspberry");
// $stack[] = array_shift($stack);
// echo '<pre>'; print_r($stack); echo '</pre>'; 

// echo 'INSERT INTO `images`(`relationId`, `type`, `imagePath`, `url`, `status`, `statusby`, `created_at`, `updated_at`) <br/> VALUES';

// for ($i=1; $i <= 8 ; $i++) { 
// 	echo "('IHC1','path','images/cruise/$i.jpg','/','Active','ajay',now(),now()),<br/>";
// }

// echo date("H:i A", strtotime('08:30:00'));
// $fare = 'INR4200';
// $price = substr($fare, 3);
// echo $price+8989;



// $request = [];
// foreach ($recoveredArrays as $key => $value) {
// 	$request[$value->vendor][] = $value;
// }
// pre_echo($request);

// foreach ($recoveredArrays as $key => $value) {
// 	unlink($value);
// }

// foreach ($recoveredArrays->data as $key => $value) {
// 	echo "('$value->sortOrder','$value->selectable','$value->defaultCurrencyCode','$value->lookupId','$value->parentId','$value->timeZone','$value->iataCode','$value->destinationName','$value->destinationType','$value->destinationId','$value->latitude','$value->longitude'),<br/>";
// }

exit;

function nested_jsonDecode1($string, $is_array = false){
	
	// $string = str_replace(array("\r", "\\n", "\\t"), "", $string);
	$search = ['\\', '"[', ']"', '"{', '}"'];
	$repalce = ['', '[', ']', '{', '}'];
	$string = str_replace($search,$repalce,$string);

	return is_bool($is_array) ? json_decode($string, $is_array) : '';
}


class Foo
{
   private $__aaa = null;

   public function __construct($aaa)
   {
      $this->__aaa = $aaa;
   }

   public static function static($aaa = null)
   {
      return new Foo($aaa);
   }

   public function doX($sub)
   {
      return $sub;
   }
}

echo Foo::static()->doX(10);

exit;
$string  = '[{"NoOfAdults":"2","ChildAge":[]},{"NoOfAdults":"2","ChildAge":["2"]},{"NoOfAdults":"2","ChildAge":["5","10"]}]';

$re = json_decode($string,false);

$re->A = $string;

// var_dump(is_string($re));
// pre_echo($re);
$string2 = json_encode($re);

pre_echo(json_decode($string2,true));

$re1 = jsonDecodeMulti($string2,true);

$re1['A']['B'] = '{"DepartureDate":"12\/11\/2016","RoomGuests":[{"NoOfAdults":"2","ChildAge":"[]"},{"NoOfAdults":"2","ChildAge":"[\"2\"]"}]}';

$string3 = json_encode($re1);
echo $string3;

echo "String 3<br/>";
pre_echo(jsonDecodeMulti($string3));


function jsonDecodeMulti1($string){

	$string = is_object($string) ? json_decode(json_encode($string),true) : $string;
	
	if (is_string($string)) {
		$json_decoded = json_decode($string,true);
		$array = [];
		if (is_array($json_decoded)) {
			foreach ($json_decoded as $je_key => $je_value) {
				$array[$je_key] = jsonDecodeMulti($je_value);
			}
			return $array;
		}
		else{
			return $string;
		}
	}
	elseif(is_array($string)) {
		$array = [];
		foreach ($string as $key => $value) {
			$array[$key] = jsonDecodeMulti($value);
		}
		return $array;
	}
	else{
		return false;
	}
}




$recoveredData = file_get_contents('file.json');
$recoveredArrays = json_decode($recoveredData, true);
// echo '<pre>'; print_r($recoveredArrays); echo '</pre>'; 

$request_initialize = [
	"hotelCode" => ['tjso'],
	"HotelName" => [],
	"CheckInDate" => [],
	"CheckOutDate" => [],
	"StarRating" => [],
	"Latitude" => [],
	"Longitude" => [],
	"Address" => [],
	"Description" => [],
	"GuestNationality" => [],
	"PreferredCurrency" => [],
	"EndUserIp" => [],
	"HotelPolicy" => [],
	"Location" => [],
	"Attractions" => [],
	"Facilities" => [],
	"Images" => [],
	"HotelContactNo" => [],
	"FaxNumber" => [],
	"Email" => [],
	"RoomFacilities" => [],
	"Services" => [],
];

$arr = [
	"HotelCode" => ["This is test"],
	"HotelName" => "This is test",
	"CheckInDate" => "This is test",
	"CheckOutDate" => "This is test",
	"StarRating" => "This is test",
	"Latitude" => "This is test",
	"Longitude" => "This is test",
	"Address" => "This is test",
	"Description" => "This is test",
	"GuestNationality" => "This is test",
	"PreferredCurrency" => "This is test",
	"EndUserIp" => "This is test",
	"HotelPolicy" => "This is test",
	"Location" => "This is test",
	"Attractions" => "This is test",
	"Facilities" => "This is test",
	"Images" => "This is test",
	"HotelContactNo" => "This is test",
	"FaxNumber" => "This is test",
	"Email" => "This is test",
	"RoomFacilities" => "This is test",
	"Services" => "This is test",
];

// echo '<pre>'; print_r(array_merge($request_initialize,$arr)); echo '</pre>'; 


?>