<div class="x_panel">
	<div class="x_title noborder nomargin">
		<div class="col-md-1 col-sm-1 col-xs-12 nopadding">
			<h2><div class="text-center"><i class="fa fa-filter"></i> Filter</div></h2>
		</div>
		<div class="col-md-10 col-sm-10 col-xs-12">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="filter_hotelname" class="search btn-block height-30 border-gray padding-5" placeholder="Hotel Name">
			</div>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div hidden>
					<button id="filterButton" class="sort" data-sort="">Sort</button>
				</div>
				<select class="btn-block height-30 border-gray padding-5 filterSelect">
					<option selected>Short By</option>
					<option value="hotelName" >Hotel Name</option>
					<option value="hotelPrice" >Price L-H</option>
					<option value="hotelPrice" >Price H-L</option>
					<option value="starRating" >Star Rating L-H</option>
					<option value="starRating" >Star Rating H-L</option>
				</select>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<select class="btn-block height-30 border-gray padding-5 filterSelect">
					<option value="all" selected>All Star</option>
					<option value="0">No Star</option>
					<option value="1">1 Star</option>
					<option value="2">2 Star</option>
					<option value="3">3 Star</option>
					<option value="4">4 Star</option>
					<option value="5">5 Star</option>
				</select>
			</div>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-12 nopadding" style="display: none;">
			<ul class="nav navbar-right panel_toolbox panel_toolbox1">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
			</ul>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="x_content nopadding" style="display: none;">
		<div class="form-group"></div>
	</div>
</div>