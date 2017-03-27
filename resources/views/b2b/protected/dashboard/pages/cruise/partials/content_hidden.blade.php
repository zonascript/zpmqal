{{-- Hidden template Html  --}}
<div hidden>
	{{-- age html --}}
		<div id="age_temp">
			<div class="col-md-6 col-sm-6 col-xs-12 nopadding form-group has-feedback">
				<select class="form-control nopadding age-elem">
					<option selected>Age</option>
					@for ($i = 1; $i <= 12; $i++)
						<option>{{ $i }}</option>
					@endfor
				</select>
			</div>
		</div>
	{{-- /age html --}}
</div>
{{-- /Hidden template Html  --}}
@include('common.protected.dashboard.partials._popupModel')
