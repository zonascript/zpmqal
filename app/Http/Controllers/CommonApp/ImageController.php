<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\CommonApp\ImageModel;
ini_set('max_execution_time', 3600);



class ImageController extends Controller
{
  public function all(){
  	$result = ImageModel::all(['id','relationId', 'imagePath']);
  	$result = makeObject($result);

  	/*uncomment below code when ther is sub dir*/
  	/*$delete = [];
  	$Query = '';
  	foreach ($result as $key => $value) {
  		$image = $this->Images(public_path().'\images\activity\\'.str_replace('/', '\\', $value->imagePath));
  		if (is_array($image)) {
	  		foreach ($image as $key1 => &$value1) {
	  			$ImageName = 'images/activity/'.$value->imagePath.'/'.$value1;

	  			if (strpos($ImageName, '(') !== false) {
					    $delete[] = $ImageName;
					}
					
					$Query .= "('".$value->relationId."', 'path', '".$ImageName."', 'Active', 'ajay', now(), now()); <br/>";

	  			$value1 = $ImageName;

	  		}
  		}

  		$value->image = $image;
  	}*/

  	// pre_echo($Query);
  	// dd_pre_echo($delete);
  	dd_pre_echo($result);
  	
  	// foreach ($delete as $dkey => $dvalue) {
  	// 	unlink($dvalue);
  	// }

  }

	public function Images($dir){
		// dd($dir);
		// dd(file_exists($dir));
		if (file_exists($dir) == true) {
			$ImagesArray = [];
			$file_display = [ 'jpg', 'jpeg', 'png', 'gif' ];
			
			$dir_contents = scandir($dir);

			if (is_array($dir_contents) && !empty($dir_contents)) {
				foreach ($dir_contents as $file) {
					$file_type = pathinfo($file, PATHINFO_EXTENSION);

					if ($file_type == '' && $file != '.' && $file != '..') {
						// dd($dir.'\\'.$file.'\\');
						$ImagesArray_Temp = $this->Images($dir.'\\'.$file);
						if (is_array($ImagesArray_Temp) && !empty($ImagesArray_Temp)) {
							foreach ($ImagesArray_Temp as $ImagesArray_Temp_key => $ImagesArray_Temp_value) {
								$ImagesArray[] = $file.'\\'.$ImagesArray_Temp_value;
							}
						};
					}
					elseif(in_array($file_type, $file_display) == true) {
						$ImagesArray[] = $file;
					}
				}
			};

			return $ImagesArray;
		} 
		else {
			return false;
		}
	}


	public function copy(){

		$airlineCode = ['4', '20', '0A', '0B', '0D', '0J', '0J', '1A', '1B', '1C', '1D', '1E', '1F', '1G', '1H', '1I', '1I', '1I', '1I', '1I', '1I', '1I', '1K', '1K', '1L', '1M', '1N', '1P', '1Q', '1R', '1S', '1T', '1U', '1U', '1W', '1Z', '2A', '2B', '2C', '2D', '2F', '2G', '2G*', '2H', '2J', '2K', '2L', '2M', '2N', '2O', '2P', '2Q', '2R', '2S', '2S', '2T', '2U', '2V', '2W', '2Z', '3C', '3G', '3J', '3K', '3N', '3P', '3Q', '3R', '3S', '3T', '3U', '3V', '3W', '4A', '4C', '4D', '4F', '4G', '4G*', '4K', '4M', '4N', '4R', '4S', '4T', '4U', '4Y', '5A', '5C', '5D', '5D', '5F', '5G', '5J', '5K', '5L', '5M', '5N', '5T', '5V', '5W', '5X', '5Y', '5Z', '6A', '6B', '6E', '6G', '6H', '6I', '6J', '6K', '6N', '6P', '6Q', '6R', '6U', '6V', '6V', '6V', '6W', '6Z', '7A', '7B', '7C', '7C', '7E', '7F', '7G', '7K', '7L', '7N', '7O', '7P', '7R', '7T', '7T', '7W', '8A', '8B', '8C', '8C', '8C', '8D', '8D', '8D', '8E', '8F', '8H', '8I', '8J', '8L', '8L', '8M', '8M', '8N', '8O', '8P', '8Q', '8Q', '8Q*', '8R', '8S', '8T', '8U', '8V', '8V', '8W', '8W?', '8Y', '8Y', '8z', '9E', '9I', '9K', '9L', '9O', '9Q', '9R', '9S', '9T', '9U', '9W', '9X', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AL', 'AM', 'AN', 'AO', 'AP', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AW', 'AX', 'AY', 'AZ', 'B2', 'B3', 'B4', 'B4', 'B4', 'B5', 'B6', 'B8', 'B9', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BM', 'BN', 'BN', 'BN', 'BO', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BV', 'BW', 'BX', 'BY', 'BZ', 'BZ', 'C0', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8', 'C9', 'CA', 'CC', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CO', 'CP', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CV', 'CW', 'CX', 'CY', 'CZ', 'D3', 'D4', 'D5', 'D6', 'D7', 'D7', 'D8', 'D9', 'DA', 'DB', 'DC', 'DD', 'DE', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DO', 'DP', 'DQ', 'DR', 'DT', 'DU', 'DV', 'DV', 'DW', 'DX', 'DY', 'E0', 'E2', 'E2', 'E3', 'E4', 'E5', 'E6', 'E7', 'E7', 'E8', 'E9', 'EA', 'EC', 'ED', 'EE', 'EF', 'EG', 'EH', 'EH', 'EI', 'EJ', 'EK', 'EL', 'EM', 'EM', 'EN', 'EO', 'EO', 'EP', 'EQ', 'ER', 'ES', 'ET', 'EU', 'EV', 'EW', 'EX', 'EY', 'EZ', 'EZ', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F9', 'FA', 'FB', 'FC', 'FD', 'FE', 'FF', 'FG', 'FH', 'FI', 'FJ', 'FK', 'FL', 'FM', 'FN', 'FO', 'FP', 'FQ', 'FR', 'FS', 'FT', 'FV', 'FW', 'FX', 'FY', 'G0', 'G1', 'G2', 'G3', 'G3', 'G4', 'G6', 'G7', 'G7', 'G8', 'G8', 'G8', 'G8', 'G9', 'GA', 'GB', 'GB', 'GC', 'GD', 'GE', 'GF', 'GG', 'GG', 'GG', 'GH', 'GI', 'GJ', 'GJ', 'GK', 'GL', 'GL', 'GM', 'GN', 'GO', 'GP', 'GP', 'GQ', 'GR', 'GR', 'GS', 'GS', 'GT', 'GV', 'GW', 'GX', 'GX', 'GY', 'GY', 'GZ', 'H2', 'H4', 'H4', 'H5', 'H5', 'H6', 'H7', 'H8', 'H9', 'H9', 'H9', 'HA', 'HB', 'HC', 'HD', 'HE', 'HF', 'HG', 'HH', 'HJ', 'HK', 'HM', 'HN', 'HO', 'HP', 'HP', 'HP', 'HP', 'HQ', 'HR', 'HR', 'HT', 'HU', 'HV', 'HW', 'HW', 'HY', 'HZ', 'I4', 'I6', 'I7', 'I9', 'I9', 'IA', 'IB', 'IC', 'ID', 'IE', 'IF', 'IG', 'IH', 'II', 'IJ', 'IJ', 'IK', 'IK', 'IM', 'IN', 'IO', 'IP', 'IQ', 'IR', 'IS', 'IT', 'IT', 'IV', 'IW', 'IX', 'IY', 'IZ', 'J2', 'J3', 'J4', 'J6', 'J7', 'J8', 'J9', 'J9', 'JA', 'JA', 'JB', 'JC', 'JE', 'JF', 'JF', 'JH', 'JI', 'JJ', 'JJ', 'JK', 'JL', 'JL', 'JM', 'JN', 'JO', 'JP', 'JQ', 'JR', 'JS', 'JT', 'JU', 'JV', 'JW', 'JX', 'JY', 'JZ', 'K2', 'K4', 'K5', 'K5', 'K6', 'K8', 'K9', 'KA', 'KB', 'KC', 'KD', 'KE', 'KF', 'KG', 'KI', 'KI', 'KJ', 'KK', 'KL', 'KM', 'KO', 'KP', 'KQ', 'KR', 'KS', 'KU', 'KV', 'KX', 'KY', 'KZ', 'L1', 'L2', 'L3', 'L3', 'L5', 'L6', 'L7', 'L7', 'L8', 'L9', 'LA', 'LB', 'LC', 'LD', 'LD', 'LF', 'LG', 'LH', 'LH', 'LI', 'LJ', 'LL', 'LM', 'LM', 'LN', 'LO', 'LP', 'LQ', 'LR', 'LS', 'LT', 'LU', 'LV', 'LW', 'LX', 'LY', 'LZ', 'M2', 'M3', 'M3', 'M3', 'M4', 'M5', 'M6', 'M7', 'M7', 'M7', 'M9', 'MA', 'MB', 'MB', 'MC', 'MD', 'ME', 'MF', 'MG', 'MH', 'MI', 'MJ', 'MK', 'ML', 'MM', 'MM', 'MN', 'MO', 'MO', 'MP', 'MQ', 'MR', 'MS', 'MT', 'MU', 'MV', 'MW', 'MX', 'MY', 'MY', 'MZ', 'N2', 'N2', 'N3', 'N4', 'N4', 'N5', 'N5', 'N6', 'N6', 'N7', 'N8', 'N8', 'N9', 'NA', 'NB', 'NC', 'NC', 'NE', 'NF', 'NG', 'NH', 'NI', 'NK', 'NL', 'NM', 'NM', 'NN', 'NO', 'NO', 'NQ', 'NR', 'NT', 'NU', 'NV', 'NW', 'NX', 'NY', 'NZ', 'O2', 'O6', 'O7', 'O8', 'OA', 'OB', 'OE', 'OF', 'OF', 'OH', 'OJ', 'OK', 'OL', 'OM', 'ON', 'OO', 'OP', 'OR', 'OS', 'OT', 'OU', 'OV', 'OW', 'OX', 'OY', 'OZ', 'OZ', 'P0', 'P5', 'P7', 'P8', 'P9', 'P9', 'PA', 'PA', 'PA', 'PC', 'PC', 'PD', 'PE', 'PF', 'PG', 'PH', 'PI', 'PI', 'PJ', 'PK', 'PL', 'PL', 'PM', 'PN', 'PO', 'PQ', 'PR', 'PS', 'PS', 'PT', 'PT', 'PU', 'PV', 'PW', 'PX', 'PY', 'PZ', 'Q3', 'Q4', 'Q5', 'Q6', 'Q8', 'Q9', 'QB', 'QC', 'QD', 'QE', 'QF', 'QH', 'QH', 'QI', 'QJ', 'QK', 'QL', 'QM', 'QN', 'QO', 'QO', 'QQ', 'QQ', 'QR', 'QS', 'QS', 'QT', 'QU', 'QV', 'QW', 'QX', 'QY', 'QZ', 'R0', 'R1', 'R2', 'R3', 'R4', 'R5', 'R5', 'R6', 'R7', 'R8', 'R9', 'RA', 'RA', 'RB', 'RB', 'RC', 'RD', 'RE', 'RF', 'RG', 'RH', 'RI', 'RJ', 'RK', 'RL', 'RO', 'RP*', 'RQ', 'RR', 'RS', 'RU', 'RU', 'RV', 'RW', 'RX', 'RZ', 'S0', 'S2', 'S3', 'S4', 'S5', 'S5', 'S6', 'S7', 'S8', 'S8', 'S9', 'SA', 'SB', 'SC', 'SD', 'SE', 'SF', 'SG', 'SG', 'SH', 'SI', 'SJ', 'SK', 'SK', 'SL', 'SM', 'SN', 'SO', 'SO', 'SP', 'SQ', 'SQ', 'SR', 'SS', 'ST', 'SU', 'SV', 'SW', 'SX', 'SY', 'T2', 'T3', 'T4', 'T6', 'T7', 'T9', 'T9', 'TC', 'TD', 'TD', 'TE', 'TF', 'TG', 'TH', 'TH', 'TI', 'TK', 'TL', 'TL', 'TN', 'TO', 'TP', 'TQ', 'TR', 'TR', 'TS', 'TT', 'TT', 'TU', 'TV', 'TW', 'TX', 'TY', 'TY', 'TZ', 'U2', 'U2', 'U3', 'U4', 'U5', 'U6', 'U7', 'U8', 'U9', 'UA', 'UB', 'UD', 'UE', 'UE', 'UF', 'UG', 'UH', 'UI', 'UL', 'UM', 'UN', 'UO', 'UP', 'UQ', 'US', 'US', 'US', 'US*', 'UT', 'UU', 'UX', 'UY', 'UZ', 'V0', 'V2', 'V3', 'V4', 'V5', 'V5', 'V7', 'V8', 'V9', 'VA', 'VA', 'VC', 'VC', 'VD', 'VD', 'VE', 'VE', 'VF', 'VG', 'VI', 'VJ', 'VK', 'VL', 'VM', 'VN', 'VO', 'VP', 'VR', 'VS', 'VT', 'VU', 'VV', 'VW', 'VX', 'VX', 'VY', 'VY', 'VZ', 'W2', 'W3', 'W4', 'W5', 'W6', 'W8', 'W9', 'W9', 'W9', 'WA', 'wa', 'WB', 'WC', 'WD', 'WE', 'WF', 'WG', 'WH', 'WK', 'WK', 'WN', 'WO', 'WR', 'WS', 'WV', 'WW', 'WX', 'WY', 'X3', 'X7', 'XE', 'XF', 'XG', 'XJ', 'XK', 'XL', 'XM', 'XO', 'XO', 'XP', 'XQ', 'XS', 'XT', 'Y5', 'Y8', 'YK', 'YK', 'YL', 'YM', 'YS', 'YT', 'YV', 'YW', 'Z3', 'Z4', 'Z7', 'Z8', 'ZA', 'ZA', 'ZB', 'ZB', 'ZE', 'ZE', 'ZG', 'ZH', 'ZI', 'ZK', 'ZL', 'ZP', 'ZS', 'ZT', 'ZU', 'ZV', 'ZW', 'ZX', 'ZY'];
		
		

		foreach ($airlineCode as $key => $value) {
			$url = 'https://www.goibibo.com/images/v2/carrierImages/'.$value.'.gif'; 
			if (@getimagesize($url)) {
				copy($url, 'images/airlineImages/'.$value.'.gif');
			}
		}

		// $headers = get_headers($url);
		// echo isset($headers[0]) && $headers[0] == 'HTTP/1.0 404 Not Found' ? 'HTTP/1.0 404 Not Found' : 'true';
		// dd($headers);
		// $img_file=file_get_contents($img_file);

		// $file_loc='images/airlineImages/AI.gif';

		// $file_handler=fopen($file_loc,'w');

		// if(fwrite($file_handler,$img_file)==false){
		//     echo 'error';
		// }

		// fclose($file_handler);


		// dd();

		// try{
		// 	$content = file_get_contents($url);
		// 	file_put_contents('images/airlineImages/AI.gif', $content);
		// }catch (Exception $e){
		// 	dd($e);
		// }


		// $ch = curl_init($url);
		// $fp = fopen('images/airlineImages/AI.gif', 'wb');
		// curl_setopt($ch, CURLOPT_FILE, $fp);
		// curl_setopt($ch, CURLOPT_HEADER, 0);
		// curl_exec($ch);
		// curl_close($ch);
		// fclose($fp);
		// dd();

		// $handle = curl_init($url);
		// curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

		// /* Get the HTML or whatever is linked in $url. */
		// $response = curl_exec($handle);
		// // dd($response);
		// /* Check for 404 (file not found). */
		// $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		
		// dd($httpCode);

		// if($httpCode == 404 || $httpCode == 0) {
		//     /* Handle 404 here. */
		// }else{
		// 	copy($url, 'images/airlineImages/AIo.gif');
		// }

		// curl_close($handle);

		/* Handle $response here. */
	}

	

}
