<!DOCTYPE html>
<html>
    <head>
    	@include('errors/partials/_head')
    </head>
    <body>
        <div class="container">
    		<div class="content">
				@yield('content')
			</div>
        </div>
    	
    	@include('errors/partials/_scripts')
    </body>
    
</html>