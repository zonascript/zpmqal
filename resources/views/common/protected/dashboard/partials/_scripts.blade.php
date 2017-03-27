<!-- jQuery -->

@yield('jquery', '<script src="'.asset('common/dashboard/vendors/jquery/dist/jquery.min.js').'"></script>')


<!-- Bootstrap -->
<script src="{{ asset('common/dashboard/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('common/dashboard/vendors/fastclick/lib/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ asset('common/dashboard/vendors/nprogress/nprogress.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('common/dashboard/vendors/iCheck/icheck.min.js') }}"></script>

<script src="{{ asset('common/dashboard/vendors/select2/dist/js/select2.full.min.js') }}"></script>
@yield('js')

<!-- Custom Theme Scripts -->
<script src="{{ asset('common/dashboard/build/js/custom.min.js') }}"></script>
<script src="{{ URL::asset('js/scripts.js') }}"></script>	
@include('common.protected.dashboard.partials._gscripts')

@yield('once_scripts')

@yield('scripts')

@yield('b2b_scripts')
