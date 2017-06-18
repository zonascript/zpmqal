<?php
	$transfers = [
			"airport" => "Airport",
			"bus" => "Bus/Coach",
			"hotel" => "Hotel",
			"cruise" => "Cruise/Ferry",
		];

	$transfersHtml = '';
	foreach ($transfers as $transferKey => $transfer) {
		$transfersHtml .= '<option value="'.$transferKey.'">'.$transfer.'</option>';
	}
?>
<div class="col-md-12 col-sm-12 col-xs-12 x_panel glowing-border">
	<div class="col-md-5 col-sm-5 col-xs-5">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6 pick-drop-container">
				<div class="row">
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label class="nopadding width-100-p">
								<input type="checkbox" class="flat" data-type="pick_up" {{showIsChecked($accomoRoute->is_pick_up) }}>
							</label>
						</div>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10 pick-drop" {!! displayNone($accomoRoute->is_pick_up) !!}>Add Pick-Up</div>
					<div class="col-md-10 col-sm-10 col-xs-10 m-top-10 select-pick-drop" {!! displayNone(!$accomoRoute->is_pick_up) !!}>
						<select class="btn-block border-gray p-2-5 h-pick-up transfer"
							data-selected="0">
							<option value="">Pick-Up</option>
							{!! showTransferOption($accomoRoute->pick_up) !!}
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6 pick-drop-container">
				<div class="row">
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label class="nopadding width-100-p">
								<input type="checkbox" class="flat" data-type="drop_off" {{showIsChecked($accomoRoute->is_drop_off) }}>
							</label>
						</div>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10 pick-drop" {!! displayNone($accomoRoute->is_drop_off) !!} >Add Drop-Off</div>
					<div class="col-md-10 col-sm-10 col-xs-10 m-top-10 select-pick-drop"  {!! displayNone(!$accomoRoute->is_drop_off) !!} >
						<select class="btn-block border-gray p-2-5 h-drop-off transfer" 
							data-selected="0">
							<option value="">Drop Off</option>
							{!! showTransferOption($accomoRoute->drop_off) !!}
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-7 col-sm-7 col-xs-7">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-6">
				<div class="row">
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label class="nopadding width-100-p">
								<input type="checkbox" class="flat meal breakfast" data-type="meal" data-meal="breakfast" {{showIsChecked($accomoRoute->is_breakfast) }}>
							</label>
						</div>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10">Add Breakfast</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-6">
				<div class="row">
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label class="nopadding width-100-p">
								<input type="checkbox" class="flat meal lunch" data-type="meal" data-meal="lunch" {{showIsChecked($accomoRoute->is_lunch) }}>
							</label>
						</div>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10">Add Lunch</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-6">
				<div class="row">
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label class="nopadding width-100-p">
								<input type="checkbox" class="flat meal dinner" data-type="meal" data-meal="dinner" {{showIsChecked($accomoRoute->is_dinner) }}>
							</label>
						</div>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10">Add Dinner</div>
				</div>
			</div>
		</div>
	</div>
</div>
