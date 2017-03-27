@include('common.protected.dashboard.partials._popupModel')
{{-- warning modal --}}
<div class="modal fade bs-example-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h3 class="modal-title" id="myModalLabel3"><i class="fa fa-warning" ></i> Warning</h3>
      </div>
      <div class="modal-body" id="myModalBody3">
        <h4>Are you sure you want to remove?</h4>
      </div>
      <div class="modal-footer" id="myModalButton3">
      	<div class="row">
      		<div class="col-md-6 col-sm-6 col-xs-12">
        		<button type="button" class="btn btn-default btn-block" data-dismiss="modal">No</button>
      		</div>
      		<div class="col-md-6 col-sm-6 col-xs-12">
        		<button id="btn_confirmed_activity" type="button" class="btn btn-danger btn-block" data-dismiss="modal" data-uid="">Yes</button>
	      	</div>
      	</div>
      </div>
    </div>
  </div>
</div>
{{-- /warning model --}}