<article id="item-607" class="item" data-permalink="https://demo.yootheme.com/themes/wordpress/2012/subway/?p=607">
	<header>
		<h1 class="title"><a href="index30e4.html?p=607" title="holiday impressions">trip summary</a></h1>
	</header>
	<div class="content clearfix">
		<table class="zebra">
			<thead>
				<tr>
					<th>Mode</th>
					<th>Origin</th>
					<th>Destination</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($package->routes as $routeKey => $route)
					<tr {{ $routeKey%2 == 0 ? '' : 'class="odd"'}}>
						<td>{{ proper($route->mode) }}</td>
						<td>{{ $route->origin == '' ? '-' : $route->origin }}</td>
						<td>{{ $route->destination }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</article>