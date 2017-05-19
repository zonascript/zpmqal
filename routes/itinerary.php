<?php

	Route::get(
						'your/package/detail/{token}/{page?}', 
						'B2bApp\PackageController@showPackageDetail'
					)
				->name('yourPackage');