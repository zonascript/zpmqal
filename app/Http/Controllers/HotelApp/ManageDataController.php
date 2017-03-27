<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\ManageDataModel;
use DB;
ini_set('max_execution_time', 3600);


class ManageDataController extends Controller
{
	public function update()	
	{
		for ($i=3; $i < 14; $i++) { 
			for ($j=1; $j <= 51; $j++) { 
		  	$table = 'booking_hotels_europe_'.$i;
		  	$row = 1000*$j;
		  	echo 'echo '.$table.' row '.$row.' going to update';
				echo "\n\n";
				echo "mysql -u root -p'Goldfinch^1' -e '";
				echo 'UPDATE `'.$table.'` SET `city_id`= (SELECT id FROM booking_destinations WHERE booking_destinations.city_unique = '.$table.'.city_unique Limit 1) WHERE '.$table.'.`city_id` IS NULL Limit 1000';
				echo "' trawish_hotels\n\n";
			}
			echo "\n\n\n";
		}

		return '<br>';

		for ($i=1; $i > 0; $i++) { 
			$row = 1;
			$updateRow = 1000*$i;

			// $result  = ManageDataModel::select('bid','city_id')
			// 					->where(['city_id' => null, ])
			// 						->offset(0)
		 //                ->limit(50)
		 //                	->get();
		  $count = 3;
		  $tablePre = 'booking_hotels_europe_';
		  $table = $tablePre.$count;

			if ($updateRow < 51001) {
				echo "\n";
				echo $updateRow;
				echo "\n";
				echo 'UPDATE `'.$table.'` SET `city_id`= (SELECT id FROM booking_destinations WHERE booking_destinations.city_unique = '.$table.'.city_unique Limit 1) WHERE '.$table.'.`city_id` IS NULL Limit 1000';
				echo "\n";
				echo "\n";

				echo $table.'(count : '.$updateRow.')';

				// DB::connection('mysql4')->update('UPDATE `'.$table.'` SET `city_id`= (SELECT id FROM booking_destinations WHERE booking_destinations.city_unique = '.$table.'.city_unique Limit 1) WHERE '.$table.'.`city_id` IS NULL Limit 1000');
			}
			else{

				$count++;
		  	if ($count > 13) {
					return 'done';
		  	}else{
		  		$row = 1;
		  		$table = $tablePre.$count;
		  	}
			}
		}
	}
}

// 190714