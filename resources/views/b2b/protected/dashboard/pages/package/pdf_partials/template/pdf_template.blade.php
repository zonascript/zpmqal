<!DOCTYPE html>
<html>
<head>
	<title>PackageId</title>
	<style type="text/css">
		.width-100p{
			width: 100%;
		}

		.display_flex{
			display: flex;
		}
		.tile_only {
			height: 1080px;
			width: 100%;
			position: relative;
			background-size: 100% 100%;
			background-repeat: no-repeat;
		}
		.tile_title_div {
			position: fixed;
			/*bottom: 30px;*/
			/*z-index: 1;*/
			margin: 150px 0 0 0;
			height: 100px;
			width: 100%;
			font-size: 60px;
			line-height: 100px;
			background-color: rgba(0,0,0,0.6);
			text-align: center;
			color: #ffffff;
			display: table;
		}

		.p-5{padding: 5px;}
		.p-10{padding: 10px;}
		.p-15{padding: 15px;}
		.p-rl-10{ padding-right: 10px; padding-left: 10px; }
		.p-top-5px{padding-top: 5px;}
		.p-top-15px{padding-top: 15px;}
		.p-top-20px{padding-top: 20px;}

		.m-10x-auto{margin: 10px auto;}
		.m-top-10px{margin-top: 10px;}
		.m-top-70px{margin-top: 70px;}
		.m-tb-10px{margin: 10px 0 10px 0}

		.width-95p{width: 95%;}

		.height-50px{height: 50px;}
		.height-70px{height: 70px;}
		.l-height-100px{height: 100px; line-height: 100px;}

		.height-100px{height: 100px;}
		.height-300px{height: 300px;}
		.height-410px{height: 410px;}
		.height-980px{height: 980px;}
		.height-1000px{height: 1000px;}
		.color-white{color: #ffffff;}
		.bg-color-theme{background-color: #206a91; color: #ffffff;}
		
		.font-weight-30px{font-weight: 30px;}
		.font-size-20px{font-size: 20px; }
		.font-size-30px{font-size: 30px; }
		.font-size-40px{font-size: 40px; }
		.font-size-50px{font-size: 50px; }
		
		.border-gray{border: 1px solid #ccc;}
		.border-gray-2px{border: 2px solid #ccc;}
		.border-theme-5px{border: 5px solid #206a91;}
		
		.text-center{text-align: center;}
		
		.text-justify{text-align: justify;}; 

		.info-box{
			background-color: #206a91; 
			text-align: center;
			color: white; 
			font-weight: 30px; 
			font-size: 50px; 
			height: 70px; 
			padding-top: 20px; 
			margin: 15px 0px 15px 0px;
		}

		.agent-box{
			font-size: 25px; 
			text-align:center; 
			padding:10px; 
		}
		.fgf-footer-box{
			background-color: #206a91; 
			color: white; 
			font-size: 17px; 
			text-align:center; 
			margin:10px 0px 10px 0px; 
			padding:5px;
		}

		.box-stack{
			overflow: hidden; 
			text-align: justify; 
			text-justify: inter-word;
		}

		.h-num{
			-webkit-margin-before: .6em; 
			-webkit-margin-after: 0px;
		}
		.img-thmb{
			width: 35%; 
			height: 200px; 
			float:left; 
			margin:5px 5px 2px 0px;
		}
	</style>
</head>
<body>
	<div class="tile_only" style="background-image: url({{ url('images/pdf/country/mix3.jpg') }});">
		<div class="height-300px"></div>
		<div class="tile_title_div">
			<div class="tile_title">Hi Ajay Kumar</div>
		</div>
	</div>
	<div class="width-100p">
		<div class="bg-color-theme font-size-40px text-center l-height-100px">Singapore</div>
		<img src="{{ asset('images/pdf/6.jpg') }}" class="width-100p">
		
		{{-- your package div --}}
		<div>
			<div class="p-top-15px bg-color-theme font-size-40px text-center p-10"><i>Your Package Detail</i></div>
			<div class="bg-color-theme p-10">
				<table class="color-white font-size-20px" width="100%">
					<tr>
						<td width="50%">
							<table><tr>
								<td><img src=" {{ asset('images/pdf/Location-icon-white.png') }}" width="35px"></td>
								<td>
									<table>
										<tr><td>Package Id: </td></tr>
										<tr><td>
											FGF409
										</td></tr>
									</table>
								</td>
							</tr></table>
						</td>
						<td width="50%">
							<table><tr>
								<td><img src=" {{ asset('images/pdf/duration.png') }}" width="35px"></td>
								<td>
									<table>
										<tr><td>Duration: </td></tr>
										<tr><td>
											3 Nights 4 Days
										</td></tr>
									</table>
								</td>
							</tr></table>
						</td>
					</tr>
					<tr>
						<td width="50%">
							<table><tr>
								<td><img src=" {{ asset('images/pdf/dateoftravel.png') }}" width="35px"></td>
								<td>
									<table>
										<tr><td>Date of Travel: </td></tr>
										<tr><td>
											10.Oct.2016 - 13.Oct.2016
										</td></tr>
									</table>
								</td>
							</tr></table>
						</td>
						<td width="50%">
							<table><tr>
								<td><img src=" {{ asset('images/pdf/passanger.png') }}" width="35px"></td>
								<td>
									<table>
										<tr><td>Package Cost: </td></tr>
										<tr><td>
											₹ 6952/-
										</td></tr>
									</table>
								</td>
							</tr></table>
						</td>
					</tr>
				</table>
			</div>
		</div>
		{{-- /your package div --}}

		<img src="{{ asset('images/pdf/country/new-zealand-wallpaper-1.jpg') }}" class="width-100p height-410px">

		<div>
			{{-- Hotels And Detail --}}
			<div class="bg-color-theme font-size-40px text-center">Hotels & Details</div>
			<div class="m-top-10px width-95p m-10x-auto">
				<div class="height-980px p-5">
					<div>
						<div class="box-stack">
							<img src="http://www.travelboutiqueonline.com/imageresource.aspx?img=hpRBSdtPJNrQuwRo5I/exPbdtjJGoRI2R1Qo2/mGLJkPNH32i6hs+dKtKiilkvjtGYLAItSe53OSFNqckK65Fw==" class="img-thmb">
							<b  class="font-size-20px">Robertson Quay</b>
							<span>
								<img src="{{ asset('images/pdf/starblue.png') }}" width="15" height="15">
								<img src="{{ asset('images/pdf/starblue.png') }}" width="15" height="15">
								<img src="{{ asset('images/pdf/starblue.png') }}" width="15" height="15">
							</span>
							<hr/>
							<i>Singapore - Singapore | 10.Oct.2016 - 13.Oct.2016</i>
							<br/>
							<br/>
							<b>About Hotel : </b>
							<span>
								<br /><b style="text-transform: capitalize;" >location:</b> Located along the Singapore River, in the heart of Robertson Quay. The hotel is within walking distance to the busy Clark Quays where restaurants and evening entertainment abound. The popular Mohammed Sultan Street with its' pubs and clubs is also a few minutes walk away.&nbsp; <br /><br /><b style="text-transform: capitalize;" >rooms:</b> The rooms is small, simple, a bit old, however, functional. All rooms do have a small TV with a good selection of channels, broadband Internet connection that is reasonably priced, as well as hair dryer and in room safes; there is a small open wardrobe beside the toilet. Single rooms are only 15 square meters with a single bed for only one person. The double rooms offer 18 square meters of space with a Queen size bed or 2 single beds. The small toilet is lay with white tile and it has a tiny standing shower.&nbsp; <br /><br /><b style="text-transform: capitalize;" >restaurant:</b> The Home Beach Bar has a casual open-air setting which serves western dinner daily.&nbsp; <br /><br /><b style="text-transform: capitalize;" >exterior:</b> A round circular building with a red rooftop. In the night the top of the building will be lighted and it look like the building is wearing a crown.&nbsp; <br /><br /><b style="text-transform: capitalize;" >lobby:</b> The entrance opens to a small lobby, with reception on one side and the luggage storage on the other. There are 3 computers next to the lobby for guests to surf the internet at a nominal charge. A short flight of steps at the end of the lobby will lead you to hotel lobby lounge where daily breakfast is served.&nbsp; <br /><br /><b style="text-transform: capitalize;" >general:</b> A no frills hotel, ideal for budget travelers simply looking for a clean bed. sg 12/07&nbsp; <br />
							</span>
							<hr/>
						</div>
						<div>
							<h4 class="h-num">Hotel Facilities</h4>
							<span>
								&bull; Very small sized lobby, &bull; Earliest check-in at 14:00, &bull; 2 lifts, &bull; 1 indoor pool, &bull; 10 floors, &bull; Car parking (Payable to hotel, if applicable), &bull; Gymnasium, &bull; Baby sitting, &bull; Business centre, &bull; Disabled facilities.
							</span>
						</div>
						<hr/>
						<div>
							<h4 class="h-num">Hotel Attractions</h4>
							<span>
								&bull; 3 kms to city centre, &bull;25 kms to the nearest airport (singapore changi airport), &bull;7 km to the nearest station (tanjong pagar), &bull;5 km to the nearest fair site (suntec)
							</span>
						</div>
					</div>       
				</div>
			</div>
			{{-- /Hotels And Detail --}}
			<div class="bg-color-theme font-size-40px text-center">Add-On <small>(Inclusion)</small></div>
				<div class="width-95p m-10x-auto">
					{{-- Foreach - Activity and Addon --}}
					<div class="box-stack">
							<img src="{{ asset('images/pdf/Activity/SG/Universal_Studios_with_5_SGD_meal_and_5_SGD_shopping/1.jpg') }}" class="img-thmb">
							<b class="font-size-20px">Universal Studios with 5 SGD meal and 5 SGD shopping </b>
							<hr>
							<i>
								&nbsp;<b>Date: </b>12/10/2016 | <b>OpeningTime : </b>10:00 AM | <b>ClosingTime : </b>9:00 PM<br/>
							</i>
							<br/>
							<b>About Activity : </b>
							<span>
								The first and only Universal Studio theme park in Southeast Asia, Universal Studios™ Singapore will feature 24 movies- themed rides and attractions, 8 of which are designed exclusively for Singapore (when fully operational).

								Universal Studios™ Singapore promises to be a truly unique, world-class movie theme park - designed with careful attention to creating weather-protected experiences that enhance the natural setting of Sentosa Island.

								Seven Unique themed zones will encircle a picturesque central lagoon. Each zone will feature distinctive architecture, landscaping, and entertainment offerings. There will be one-of-a-kind rides fro guests to enjoy, shows that make one laugh, and peaceful gardens to enjoy with family and friends, as well as retail and dining establishments.

								Everything about these intricately designed zones promises to be an immersive  entertainment experience unlike anything in this part of the world.
								Children can also look forward to splashes of exhilarating activities at the Rainforest Kidzworld.

								Come visit the award winning Singapore Zoo for an exciting rainforest experience.
							</span>
							<br/>
							<hr/>
					</div>
					{{-- /Foreach - Activity and Addon--}}
				</div>
			</div>
		</div>

		<div>
			<div class="bg-color-theme font-size-30px text-center">Exclusion</div>
			<div class="width-95p m-10x-auto text-justify">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias nulla doloribus soluta dolore dolor, tempora. Natus in totam, magni consectetur aspernatur! Debitis culpa eum explicabo maiores, placeat possimus sit inventore.
			</div>
		</div>


		<div>
			<div class="bg-color-theme font-size-30px text-center">Booking Procedure</div>
			<div class="width-95p m-10x-auto text-justify">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias nulla doloribus soluta dolore dolor, tempora. Natus in totam, magni consectetur aspernatur! Debitis culpa eum explicabo maiores, placeat possimus sit inventore.
			</div>
		</div>

		<div>
			<div class="bg-color-theme font-size-30px text-center">Cancellation Policy</div>
			<div class="width-95p m-10x-auto text-justify">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias nulla doloribus soluta dolore dolor, tempora. Natus in totam, magni consectetur aspernatur! Debitis culpa eum explicabo maiores, placeat possimus sit inventore.
			</div>
		</div>

		<div>
			<div class="bg-color-theme font-size-30px text-center">Visa Policy</div>
			<div class="width-95p m-10x-auto text-justify">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias nulla doloribus soluta dolore dolor, tempora. Natus in totam, magni consectetur aspernatur! Debitis culpa eum explicabo maiores, placeat possimus sit inventore.
			</div>
		</div>
		{{-- agent and fgf box --}}
		<div class="height-1000px">
			<br/>
			<div class="m-top-70px border-theme-5px">
				<div class="agent-box">
					<div>Thanks & Best Regards</div>
					<div><b>Ajay Kumar</b></div>
					<div>
						<img src="{{ asset('images/pdf/phone.png') }}" width="18px"> : +91 9768447666
					</div>
					<div>
						<img src="{{ asset('images/pdf/email.png') }}" width="24px"> : ajay@flygoldfinch.com
					</div>
				</div>
			</div>
			<div class="m-top-10px">
				<div class="fgf-footer-box">
					<div>D-45, Shubham Enclave, Paschim Vihar, New Delhi-110063</div>
					<div>Email: info@flygoldfinch.com | Website: www.flygoldfinch.com</div> 
				</div>
			</div>
		</div>
		{{-- /agent and fgf box --}}

	</div>

</body>
</html>


