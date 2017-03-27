<?php 

function userDetail(){
	$userdetail = null;
		
	for ($i=0; $i <5 ; $i++) { 
		$userdetail = findUser();
		if (isset($userdetail->id)) {
			break;
		}
	}
	return $userdetail;
}

function findUser()
{
	$user = [];

	if (in_array(url('/'), [env('B2B_URL'), env('LOCAL_B2B_URL'),  env('TEST_URL')])) {
		$user = Auth::user();
		$user->profile_pic = urlImage($user->image_path);
		$user->fullname = $user->firstname.' '.$user->lastname;
	}
	elseif (in_array(url('/'), [env('BACKEND_URL'), env('LOCAL_BACKEND_URL')])) {
		$user = Auth::guard('backend')->user();
		$user->profile_pic = urlImage($user->image_path);
		$user->fullname = $user->firstname.' '.$user->lastname;
	}
	elseif (in_array(url('/'), [env('ADMIN_URL'), env('LOCAL_ADMIN_URL')])) {
		$user = Auth::guard('admin')->user();
		$user->profile_pic = urlImage('images/profile.jpg');
		$user->fullname = $user->firstname.' '.$user->lastname;
	}
	return $user;
}

function isLocalhost()
{
	$domain = explode('.', url('/'));

	$return = false;

	if (is_array($domain) && $domain[count($domain)-1] == 'dev') {
		$return = true;
	}

	return $return;
}
 
function removeAndSym($string){
	if (findWord('&amp;', $string)) {
		$string = str_replace( "&amp;", "&", $string);
		return removeAndSym($string);
	}else{
		return $string;
	}
}


function listFolderFiles($dir){
	$ffs = scandir($dir);
	$result = [];
	foreach($ffs as $ff){
		if($ff != '.' && $ff != '..'){
			if(is_dir($dir.'/'.$ff)){
				$resultTemp = listFolderFiles($dir.'/'.$ff);
				$result = array_merge($resultTemp, $result);

			}else{
				$result[] = $dir.'/'.$ff;
			}
		}
	}
	return $result;
}


/*
| this function is for finding word from string 
*/

function findWord($word, $string)
{
	$result = false;

	if (strpos($string, $word) !== false) {
		$result = true;
	}

	return $result;
}

function pre_echo($array){
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function dd_pre_echo($array){
	pre_echo($array);
	exit;
}

function ddPreEcho($array){
	pre_echo($array);
	exit;
}

function echoHtml($html)
{
	echo trimHtml($html);
}

function trimHtml($html)
{
	return trim( preg_replace('/\s+/', ' ', preg_replace('/\t+/', '',$html)));
}

function proper($Word){
	return ucwords(strtolower($Word));
}

function roundUp($value){
	return round($value, 2, PHP_ROUND_HALF_UP);
}

function countObject($object){
	return count((array)$object);
}



function nested_jsonDecode($string, $is_array = false){

	$string = is_object($string) ? json_decode(json_encode($string),true) : $string;
	
	if (is_string($string)) {
		$json_decoded = json_decode($string,true);
		$array = [];
		if (is_array($json_decoded)) {
			foreach ($json_decoded as $je_key => $je_value) {
				$array[$je_key] = json_decodeMulti($je_value);
			}
			return rejson_decode($array, $is_array);
		}
		else{
			return $string;
		}
	}
	elseif(is_array($string)) {
		$array = [];
		foreach ($string as $key => $value) {
			$array[$key] = json_decodeMulti($value);
		}
		return rejson_decode($array, $is_array);
	}
	else{
		return $string;
	}

}

/*================This code is not working and has some bug ====================

function nestedJsonDecode($string, $is_array = false){

	$result = [];
	if (is_object($string)) {
		$result = (object)[];
		foreach ($string as $key => $value) {
			$result_temp = nested_jsonDecode($value);
			$result->$key = $result_temp == '' ? $value : $result_temp;
		}
	}
	elseif (is_array($string)) {
		$result = [];
		foreach ($string as $key => $value) {
			$result_temp = nested_jsonDecode($value, true);
			$result[$key] = $result_temp == '' ? $value : $result_temp;
		}
	}
	else{
		$result_temp = json_decode(fixjson($string), $is_array);
		$result_temp = $result_temp == '' ? json_decode($string, $is_array) : $result_temp;
		$result = $result_temp == '' ? $string : $result_temp;
	}

	return is_bool($is_array) ? $result : '';
}*/


function is_url_exist($url){
	$ch = curl_init($url);    
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if($code == 200){
		 $status = true;
	}else{
		$status = false;
	}
	curl_close($ch);
	return $status;
}

		

function implode_kv($array){
	return implode(', ', array_map(
		function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
		$array,
		array_keys($array)
	));
}

/*
| this function for get cost into inr passed array should be like this 
| $array = ["USD" => 459];
*/
function getInrCost($array){

	/*===========================if object===========================*/
	$array = is_object($array) ? rejson_decode($array, true) : $array;

	/*====================Initializing $cost here====================*/
	$cost = 0;
	
	if (bool_array($array)) {
		foreach ($array as $key => $value) {
			$exchange = (object)[];
			$rate = 1;
			if ($key != 'INR') {

				/*=================trying to get exchange into five attempt=================*/

				for ($attempt = 1; $attempt <= 5 ; $attempt++) { 
					$exchange = currencyExchange($key,'INR');
					
					/*saveInFile(
						json_encode(["Currency" => $key, "Exchange" => $exchange]), 
						'Api/Currency/attempt_'.$attempt.'getInrCost_', 'json'
					);*/

					if (isset($exchange->results->rate->Rate)) {
						break;
					}
				}

				$rate = ifset($exchange->results->rate->Rate, 1);
			}

			$cost += $value*$rate;
		} 
	}

	return $cost;

}

/*
| this function is save image locally and then send a http request
| to another server then that server download the image using copy or 
| file_get_contents then it returns path of the remote dir 
| remote url is image.trawish.com
*/
function imageUpload($image)
{
	$imageName = md5(time()).'.'.$image->getClientOriginalExtension();
	$image->move(public_path('images/tmp'), $imageName);
	
	$domain = isLocalhost() 
						? 'http://images.flygoldfinch.dev/' 
						: 'http://images.trawish.com/';

	$name = httpPost($domain.'image/download', [
			'url' => url('images/tmp/'.$imageName)
		]);

	unlink(public_path('images/tmp/').$imageName);

	return $name;
}


function httpGet($url){
	$ch = curl_init();  

	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	//  curl_setopt($ch,CURLOPT_HEADER, false); 

	$output = curl_exec($ch);

	curl_close($ch);
	return $output;
}


function httpPost($url, $data = null,  $header = [])
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);     
	$result = curl_exec($ch);
	
	return $result;
}


function currencyExchange($From, $To){

	$url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22'.$From.$To.'%22)&env=store://datatables.org/alltableswithkeys';

	/*===================================== this url for demo =====================================
	$url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDEUR%22,%20%22USDJPY%22,%20%22USDBGN%22,%20%22USDCZK%22,%20%22USDDKK%22,%20%22USDGBP%22,%20%22USDHUF%22,%20%22USDLTL%22,%20%22USDLVL%22,%20%22USDPLN%22,%20%22USDRON%22,%20%22USDSEK%22,%20%22USDCHF%22,%20%22USDNOK%22,%20%22USDHRK%22,%20%22USDRUB%22,%20%22USDTRY%22,%20%22USDAUD%22,%20%22USDBRL%22,%20%22USDCAD%22,%20%22USDCNY%22,%20%22USDHKD%22,%20%22USDIDR%22,%20%22USDILS%22,%20%22USDINR%22,%20%22USDKRW%22,%20%22USDMXN%22,%20%22USDMYR%22,%20%22USDNZD%22,%20%22USDPHP%22,%20%22USDSGD%22,%20%22USDTHB%22,%20%22USDZAR%22,%20%22USDISK%22)&env=store://datatables.org/alltableswithkeys';*/

	$response = httpGet($url);
	$response = rejson_decode(simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA));
	return $response;
}



function travelFeed(){
	$url = 'http://www.travelbizmonitor.com/Includes/xmlInclude/Travelbizmonitorrss.xml';
	$response = httpGet($url);
	$response = rejson_decode(simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA));
	return $response;
}


function fixjson($string){
	$search = ['\\', '"[', ']"', '"{', '}"'];
	$repalce = ['', '[', ']', '{', '}'];
	return $string = str_replace($search,$repalce,$string);
}

function removeLeadingZero($value=0)
{
	return +$value;
}


/*
| this function is to get 
*/
function getPax($roomGuests){
	$roomGuests = rejson_decode($roomGuests, true);
	$result = '';

	if (bool_array($roomGuests)) {

		$result = ["NoOfAdults" => 0,"NoOfChild" => 0, "ChildAge" => []];
		foreach ($roomGuests as $key => $value) {
			$result['NoOfAdults'] += isset($value['NoOfAdults']) ? $value['NoOfAdults'] : 0;
			if (isset($value->ChildAge)) {
				$result['ChildAge'] = array_merge($result['ChildAge'], $value['ChildAge']); 
			}
		}
		$result['NoOfChild'] = count($result['ChildAge']);
	}

	return rejson_decode($result);
}


/*
| this function for decode array which contain it self and json with and json may 
| contain json it self
*/

function json_decodeMulti($string, $is_array = true){

	$result = null;

	if (is_string($string)) {
		$json_decoded = json_decode($string,true);
		$array = [];
		if (is_array($json_decoded)) {
			foreach ($json_decoded as $je_key => $je_value) {
				$array[$je_key] = json_decodeMulti($je_value);
			}
			$result = $array;
		}
		else{
			$result = $string;
		}
	}
	elseif(is_array($string)) {
		$array = [];
		foreach ($string as $key => $value) {
			$array[$key] = json_decodeMulti($value);
		}
		$result = $array;
	}
	elseif (is_object($string)) {
		$result = json_decodeMulti(rejson_decode($string, true), $is_array);
	}
	else{
		$result = $string;
	}

	return rejson_decode($result, $is_array);

}


function ifset(&$var, $else = '') {
	return isset($var) ? $var : $else;
}

function ifsetEqual(&$var, $value) {
	return (isset($var) &&  $var == $value) ? true : false;
}

/*
|--------------------------------------------------------------------------
| How to use this "Isset_Multi" function 
|--------------------------------------------------------------------------
|
| This fucntion is call like this 
|
| // This is the "Key Array" which have to search.
| $search = ["Name","Email"]; 
|
| // this is the array where we have to find above keys
| $array = ["Name"=>"Ajay", "Email"=>"ajay@flygoldfinch.com", "Status" => "Active"];
|
| $bool = Isset_Multi($search,$array); // true
|
*/

function Isset_Multi($search,$array){
	$array = is_object($array) ? json_decode(json_encode($array), true) : $array;

	$return = (
		is_array($search) &&  is_array($array) &&  
		(count(array_intersect_key(array_keys($array), $search)) === count($search))
	) ?  TRUE : FALSE;
	return $return;
}



function sub_string($string, $length = 50, $start = 0){
	return strlen($string) >= $length ? substr($string,$start,$length).'...' : $string; 
}

// this funtion is made for impoding multidimetional array
function implode_r($g, $p) {
	return is_array($p) 
					? implode($g, array_map(__FUNCTION__, array_fill(0, count($p), $g), $p)) 
					: $p;
}

// this funtion is made for checking multidimetional array is int or not
function is_IntArray($array){
	return ctype_digit(implode_r('', $array));
}

function Bool_Array($Array){
	return (is_array($Array) && !empty($Array)) ? TRUE : FALSE;
}

function Bool_Object($Array){
	return (is_object($Array) && !empty($Array)) ? TRUE : FALSE;
}

function is_xml($string){
	return preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $string) ? true : false;
}

function xmlToJson($xml){
	return simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
}

function Move_ArrayUp($Array){
	$new = [];
	if (bool_array($Array)) {
		foreach($Array as $key => $value) {
				$new += $value;
		}
		return $new;
	}
	else{
		return false;
	}

}

/**
 * Simple function to replicate PHP 5 behaviour
 */
function microtime_float()
{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
}

function timeStart()
{
	$timeStart = microtime_float();
	echo "<br> Start Time : ".$timeStart. "<br>";
	return $timeStart;
}

function timeEnd($timeStart = null)
{
	$timeEnd = microtime_float();

	echo "<br> End Time : ".$timeEnd."<br>";

	if (!is_null($timeStart)) {
		$time = $timeEnd - $timeStart;
		echo "<br> Total time it take to execute : <b>$time seconds<b><br>";
	}
	return $timeEnd;
}

// this function to get full 24 hr time from am to pm
function timeFull($time='')
{
	$time =  str_replace(' : ', ':', $time);
	return date("H:i", strtotime($time));
}

function addDaysinDate($date,$days, $format = "Y-m-d"){
	$date = strtotime("+".$days." days", strtotime($date));
	return  date($format, $date);
}


/*this function for fix array according to need like for hotel or flight*/
function totalRoomGuest($roomGuests){
	
}

function secToDay($sec)
{
	return $sec/(60*60*24);

}

function date_differences($EndDate,$StartDate, $format = 'Y-m-d'){

	$EndDate_T = new DateTime();
	$StartDate_T = new DateTime();

	if ($format != 'Y-m-d') {
		$EndDate_T = new DateTime(Date_Formatter($EndDate, $format, 'Y-m-d'));
		$StartDate_T = new DateTime(Date_Formatter($StartDate, $format, 'Y-m-d'));
	}
	else{
		$EndDate_T = new DateTime($EndDate);
		$StartDate_T = new DateTime($StartDate);
	}

	$interval = $EndDate_T->diff($StartDate_T);
	$differences = $interval->format('%a');
	return $differences;
}

function getDefaultDateTime($date)
{
	$result = false;

	if ($date != '') {
		$dateTimeObj = new DateTime($date);
		return $dateTimeObj->format('Y-m-d H:i:s');
	}

	return $result;
}



function date_formatter($Date, $CurrentFormat = null, $DesireFormat = null){
	$DesireFormat = $DesireFormat == null ? 'Y-m-d' : $DesireFormat;
	$CurrentFormat = $CurrentFormat == null ? 'Y-m-d' : $CurrentFormat;

	$date = DateTime::createFromFormat($CurrentFormat, $Date);
	return ($date != FALSE) ? $date->format($DesireFormat) : FALSE; 
}

function getDateTime($dateTime, $dateformat = 'Y-m-d', $timeformat = 'H:i'){

	$dt = new DateTime($dateTime);
	$date = $dt->format($dateformat);
	$time = $dt->format($timeformat);
	return (object)["date" => $date, "time" => $time];
}

/* 
| this is simple funtion to convert time into hour and min but the 
| $time should be like 01:00:00
*/
function convertInHourMin($time){
	$timeArray = explode(':', $time);
	if (isset($timeArray[0]) && isset($timeArray[1])) {
		$hour = +$timeArray[0]." h ";
		$min = +$timeArray[1] == 0 ? '' : $timeArray[1].' min';

		return $hour.$min;
	}
}


function starRating($count){
	$stars = '';

	if (is_numeric($count)) {
		for ($i=1; $i < 5 ; $i++) { 
			if ($i <= $count ) {
				$stars .= '<i class="fa fa-star font-gold font-size-13"></i>';
			}
			else{
				$stars .= '<i class="fa fa-star font-size-13"></i>';
			}
		}
	}
	return $stars;
}

function getStarImage($Count, $width = 18, $height = 18){
	
	global $Server_Name;
	
	$html = '';
	for($x = 1; $x <= $Count; $x++) {
		$html .= '<img src="'.urlImage('images/icon/star.gif').'" width="'.$width.'" height="'.$height.'">';
	}
	return $html;
}


function getArrayValueByPath($array, $path) {
		$temp = &$array;

		foreach($path as $key) {
				$temp =& $temp[$key];
		}
		return $temp;
}

function getPackageId($id = 0){
	return 'FGF'.str_pad($id, 5, '0', STR_PAD_LEFT);
}

function getUniqueId($id, $prefix = '', $count = 5){
	return $prefix.str_pad($id, $count, '0', STR_PAD_LEFT);
}


function timeStamp(){
	date_default_timezone_set('Asia/Kolkata');
	$DateTime_Obj = new DateTime();
	$DateTime_Array =  (array) $DateTime_Obj;
	return $TimeStamp = $DateTime_Obj->getTimestamp();
}



//Merge two arrays alternatively
function alternativelyMerge($array1=[], $array2 =[])
{
	if (count($array1) > count($array2)) {
		$bigArray = array_values($array1);
		$smallArray = array_values($array2);
	}
	else{
		$bigArray = $array2;
		$smallArray = $array1;
	}


	$new = [];
	
	for ($i=0; $i<count($bigArray); $i++) {
		if (isset($bigArray[$i])) {
			$new[] = $bigArray[$i];
		}

		if (isset($smallArray[$i])) {
			$new[] = $smallArray[$i];
		}
	}
	return $new;
}


function saveInFile($data = 'NoData', $name = '', $extn = 'txt', $path = 'test/SaveInFile'){

	$myfile = fopen($path.'/'.$name.'_'.timestamp().".".$extn, "w") or die("Unable to open file!");
	fwrite($myfile, $data);
	fclose($myfile);
}

function saveInStorage($data = 'NoData', $name = '', $extn = 'txt', $path = 'test/SaveInFile'){
	$path = storage_path($path);
	$filePath = $path.'/'.$name.'_'.timestamp().".".$extn;
	$myfile = fopen($filePath, "w") or die("Unable to open file!");
	fwrite($myfile, $data);
	fclose($myfile);
	return $filePath;
}

function json_decodeElse($string, $else, $objectBool = false){
	$result = json_decode($string, $objectBool);
	return $result == '' ? $else : $result;
}


function makeObject($array){
	return json_decode(json_encode($array));
}

function rejson_decode($array, $is_array = false){
	return is_bool($is_array) ? json_decode(json_encode($array), $is_array) : '';
}

function pdfHotelDesc($html){
	return str_replace(['<b>', '</b> <br />'], ['<b class="capitalize">', '</b>'], $html);
}


function echoLocation($origin = '', $destination = '')
{
	$location = '';
	// ==============================if origin is null============================
	if ($origin == '') {
		$location = $destination;
	}
	
	// ===========================if destination is null==========================
	elseif ($destination == '') {
		$location = $origin;
	}

	// ===================if origin same as destination is null===================
	elseif ($origin == $destination) {
		$location = $origin;
	}

	// ===================if origin and destination is not same===================
	else{
		$location = $origin.' - '.$destination;
	}

	// returning location but if it is not null 
	return $location == '' ? 'In transit' : $location;
}


function do_get_request($url)
{
	$url = htmlspecialchars_decode($url);

	$headers = @get_headers($url);
	
	if (isset($headers[0]) && $headers[0] == 'HTTP/1.1 200 OK') {
		return file_get_contents( $url );
	}else{
		return null;
	}
}

/*
| Helper function for Url
*/

/*=================================Redirect Url=================================*/
function newRedirectUrl($url){

	$newUrlObj = new \App\Http\Controllers\Common\RedirectController;
	
	return $newUrlObj->newUrl($url);

}

/*===================================follow-ups==================================*/

function followUps(){
	$followUpsObj = new \App\Http\Controllers\B2bApp\FollowUpController;
	$followUps = $followUpsObj->all();
	return $followUps;
}

/*===================================follow-ups==================================*/
function toDo(){
	$toDoObj = new \App\Http\Controllers\B2bApp\ToDoController;
	$toDo = $toDoObj->all();
	return $toDo;
}


/*===================================follow-ups==================================*/
function pendingLeads(){
	$leadsObj = new \App\Http\Controllers\B2bApp\ClientController;
	$leads = $leadsObj->pendingClients();
	return $leads;
}

/*=================================default image=================================*/

function urlImage($path = '')
{
	$url = '';

	if (findWord('http://', $path) || findWord('https://', $path)) {
		$url = $path;
	}
	else{

		$path = ltrim(str_replace('//', '/', str_replace("\\", '/', $path)), '/');
		$domain = isLocalhost() 
						? 'http://images.flygoldfinch.dev/' 
						: 'http://images.trawish.com/';
		
		$url = $domain.$path;
	}
	
	return $url;

}

/*
| this function is to fix skyscanner images array
*/
function ssImageArrayFix($images = [], $imageHost = '')
{
	$images = rejson_decode($images, true);
	$result = [];
	foreach ($images as $ikey => $iValues) {
		$types = array_keys($iValues);
		if (isset($types[0])) {
			$result[] = 'http://'.$imageHost.$ikey.$types[0];
		}
	}
	return $result;
}
	

	

function activityMode($key)
{
	$found = null;
	$modes = [
			 'sic' => 'SIC',
			 'no'  => 'No Transfer',
			 'private' => 'Private',
			 'selfdrive' => 'Self Drive'
		];

	if (isset($modes[$key])) {
		$found = $modes[$key];
	}
	return $found;
}


function activityTiming($key)
{
	$found = null;
	$timing = [
			'noon' => 'Noon',
			'morning'	=> 'Morning', 
			'evening'	=> 'Evening', 
			'halfday' => 'Half Day',
			'fullday' => 'Full Day'
		];

	if (isset($timing[$key])) {
		$found = $timing[$key];
	}
	return $found;
}

function urlDefaultImageRoom(){
	return urlImage('images/default/room.png');
}

function urlDefaultImageHotel(){
	return urlImage('images/default/hotel.png');
}

function urlDefaultImageCruise(){
	return urlImage('images/default/hotel.png');
}

function urlDefaultImageActivity(){
	return urlImage('images/default/activity.png');
}

function urlDefaultImageProfile($value='')
{
	return urlImage('images/default/profile.jpg');
}


function  urlImageAirline($airlineCode='')
{
	$airlineCode = $airlineCode == '' ? '__' : $airlineCode;
	return urlImage('images/airlineImages/'.$airlineCode.'.gif');
}

/*=================================Itinerary Url=================================*/
function urlHotelsIti($id = 0, $packageDbId = 0 ){
	return url('/dashboard/package/itinerary/hotels/'.$id.'/'.$packageDbId);
}

function urlFlightsIti($id = 0, $packageDbId = 0 ){
	return url('/dashboard/package/itinerary/flights/'.$id.'/'.$packageDbId);
}

function urlCabsIti($id = 0, $packageDbId = 0 ){
	return url('/dashboard/package/itinerary/cabs/'.$id.'/'.$packageDbId);
}

function urlActivitiesIti($id = 0, $packageDbId = 0 ){
	return url('/dashboard/package/itinerary/activities/'.$id.'/'.$packageDbId);
}

function urlCopyHotelIti($id = 0, $packageDbId = 0 ){
	return url('/dashboard/package/itinerary/activities/copytohotel/'.$id.'/'.$packageDbId);
}

/*==================================Event Url==================================*/

function urlPackageEvent($routeDbId){
	return url('/dashboard/package/event/'.$routeDbId);
}

/*=================================Package Url=================================*/

function urlPackageAll($id = false, $packageDbId = false){
	return url('dashboard/package/all/'.$id.'/'.$packageDbId);
}

function urlSavePackageCost($id = 0, $packageDbId = 0){
	return url('dashboard/package/savecost/'.$id.'/'.$packageDbId);
}


/*=================================Hotel Url=================================*/
function urlAllHotelsBuilder($packageDbId = 0){
	return url('dashboard/package/builder/hotels/'.$packageDbId);
}

function urlHotelsBuilder($firstCartId = 0){
	return url('dashboard/package/builder/hotel/'.$firstCartId);
}

function urlHotelsRoomBuilder($firstCartId = 0){
	return url('dashboard/package/builder/hotel/room/'.$firstCartId);
}

function urlHotelsRoomBookBuilder($firstCartId = 0){
	return url('dashboard/package/builder/hotel/room/book/'.$firstCartId);
}


function urlTbtqResult($firstCartId = "")
{
	return url('/t/hotels/result')."/".$firstCartId;
}

function urlSsResult($firstCartId = "")
{
	return url('/ss/hotels/result/'.$firstCartId);
}

/*=================================Cruises Url=================================*/

function urlCruisesBuilder($id = 0, $packageDbId = 0, $firstCartId = 0){
	return url('dashboard/package/builder/cruise/'.$firstCartId);
}

function urlCruisesCabinBuilder($id = 0, $packageDbId = 0, $firstCartId = 0){
	return url('dashboard/package/builder/cruise/cabin/'.$id.'/'.$packageDbId.'/'.$firstCartId);
}

function urlCruisesCabinBookBuilder($id = 0, $packageDbId = 0, $firstCartId = 0){
	return url('dashboard/package/builder/cruise/cabin/book/'.$id.'/'.$packageDbId.'/'.$firstCartId);
}


/*=================================Flights Url=================================*/
function urlFlightsBuilder($packageDbId = 0){
	return url('dashboard/package/builder/flights/'.$packageDbId);
}

function urlFlightsSearch($flightDbId = 0){
	return url('dashboard/package/builder/flight/'.$flightDbId);
}

function urlFlightsResult($flightDbId = 0){
	return url('dashboard/package/builder/flight/result/'.$flightDbId);
}


function urlFlightBook($flightDbId='')
{
	return url('/dashboard/package/builder/flight/book')."/".$flightDbId;
}


/*=================================Activities Url=================================*/

function urlActivitiesBuilder($packageDbId = 0){
	return url('dashboard/package/builder/activities/'.$packageDbId);
}



/*=================================Car Url=================================*/

function urlCarsBuilder($packageDbId = 0){
	return url('dashboard/package/builder/car/'.$packageDbId);
}



/*=====================================Pdf Url=====================================*/

function urlPdfPacakge($packageDbId){
	return url('dashboard/package/pdf/'.$packageDbId);
}


/*================================= Responce Json =================================*/

function jsonError($error = null){
	return json_encode(error500($error));
}


function error500($error='')
{
	$error = is_null($error) 
			 ? "Something Went Wrong please try again later." 
			 : $error;

	return ["status" => 500, "error" => $error];
}

/*================================Activity Function================================*/
/*
| this function is return price if sic price is available the it return 
| sic price eles it return private price id not private then it return 0
*/
function is_sic($NoOfPax, $object){
	$object = rejson_decode($object);
	$adultCount = $NoOfPax->NoOfAdults; 
	$childCount = $NoOfPax->NoOfChild;
	$result = 0;
	
	if (isset($object->Sic->Price->Adult) && isset($object->Sic->Price->Child)) {
		$result = ($object->Sic->Price->Adult*$adultCount)
						+ ($object->Sic->Price->Child*$childCount);
	}
	elseif (isset($object->Private->Price->Adult) && isset($object->Private->Price->Child) && isset($object->Private->Cars[0])) {
		$result =  ($object->Private->Price->Adult*$adultCount)
							+($object->Private->Price->Child*$childCount)
							+(2*requireCar($NoOfPax)*(ifset($object->Private->Cars[0]->Price)));
	}

	return $result;
}
// this is function is for checking how many car need for travel on pax count
function requireCar($NoOfPax){
	return ceil(($NoOfPax->NoOfAdults+$NoOfPax->NoOfChild)/4);
}

function sortById($x, $y) {
	return $x['id'] - $y['id'];
}

function sortBySeatingCapacity($x, $y) {
	return $x['SeatingCapacity'] - $y['SeatingCapacity'];
}




// =================================common asset url=================================

function commonAsset($path){
	return asset('common/'.$path);
}