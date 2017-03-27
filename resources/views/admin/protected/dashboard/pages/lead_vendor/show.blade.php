@extends('admin.protected.dashboard.main')

@section('content')
  <div class="">

    <div class="page-title">
      <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12">
          <a href="{{ url('dashboard/settings/lead/vendor') }}" class="btn btn-success btn-block"><i class="fa fa-arrow-left"></i> Back to All Contacts</a>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_content">
            <div class="row">
              @if (!is_null($vendor))
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 profile_details">
                  <div class="well col-md-12 col-sm-12 col-xs-12 profile_view">
                    <div class="col-md-12 col-sm-12">
                      
                      <div class="left col-md-9 col-sm-9 col-xs-9 nopadding">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <h4 class="brief"><i>{{ $vendor->company_name }}</i></h4>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <h1>{{ $vendor->contact_person }}</h1>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <hr>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <p class="padding-tb-10">
                            <strong>Note: </strong> 
                            {{ $vendor->note }}
                          </p>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <p class="padding-tb-10">
                            <strong>Address: </strong> 
                            {{ $vendor->address }}
                          </p>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <p><i class="fa fa-phone"></i> {{ $vendor->contact_number }}</p>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <p class="padding-tb-10"><i class="fa fa-envelope"></i> {{ $vendor->email_id }}</p>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <p class="padding-tb-10"><i class="fa fa-globe"></i>
                            <a class="btn btn-link cursor-pointer" href="{{ $vendor->website }}" target="_blank">
                                {{ sub_string($vendor->website, 80) }}
                            </a>
                          </p>
                        </div>
                      </div>
                      <div class="left col-md-1 col-sm-1 col-xs-1"></div>
      
                      <div class="right col-md-2 col-sm-2 col-xs-2 text-center nopadding">
                        <img src="{{ urlImage($vendor->image_path) }}" alt="" class="img-circle img-responsive">
                      </div>
                      
                    </div>
                    <div class="col-xs-12 bottom text-center">
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <a href="{{ url('dashboard/settings/lead/vendor/'.$vendor->id.'/edit') }}" class="btn btn-primary btn-block"><i class="fa fa-edit"></i> Update Info</a>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <a data-toggle="modal" data-target=".bs-example-modal-warning" class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Delete</a>
                        <!-- Small modal -->
                          <div class="modal fade bs-example-modal-warning" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                  </button>
                                  <h3 class="modal-title" id="myModalLabel2"><i class="fa fa-warning" ></i> Warning</h3>
                                </div>
                                <div class="modal-body">
                                  <h4>Are you sure you want to delete this contact ?</h4>
                                </div>
                                <div class="modal-footer">
                                  <form method="POST" action="{{url('dashboard/settings/lead/vendor/'.$vendor->id)}}">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-warning" name="inactive" value="Inactive">
                                    <input type="submit" class="btn btn-danger" name="delete" value="delete">
                                  </form>
                                </div>

                              </div>
                            </div>
                          </div>
                        <!-- /modals -->
                      </div>
                      <div class="col-md-2 col-sm-2 col-xs-12"></div>
                    </div>
                  </div>
                </div>
              @else
                <p>Sorry... there is no vendor</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
@endsection