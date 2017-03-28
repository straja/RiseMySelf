@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">
      <div class="col-xs-10 col-xs-offset-1">
        @if (session('flash_message'))
          <div class="alert alert-success">{{ session('flash_message') }}</div>
        @endif
        @if (session('error_message'))
          <div class="alert alert-danger">{{ session('error_message') }}</div>
        @endif
      </div>
    </div>

    @if(count($errors))
    <div class="row">
      <div class="col-md-6 col-md-offset-2 text-center">
        <div class="alert alert-danger">
          @foreach($errors->all() as $error)
          <p>{{ ($error) }}</p>
          @endforeach
        </div>
      </div>
    </div>
    @endif

    <div class="row">
      <div class="col-xs-10 col-xs-offset-1">
            <div>
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#add-category">
                 <i class="fa fa-user"></i> Add Category
                </button>
               <div class="modal fade" id="add-category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
               <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add New Category</h4>
                  </div>
                <form action="{{url('admin/add-category')}}" method="post">
				  <div class="modal-body">

				
					<input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <div class="row">
					<div class="col-md-12">
                    	<input type="text" name="category" class="form-control" placeholder="Enter new category">
                  	</div>
				  </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-default fa fa-plus" data-submit="modal">Add</button>
                  </div>
			  </form>
                </div>
              </div>
            </div>
              </div>
			
      </div>
    </div>

    <hr>

    <div class="row">
    	<form action="{{url('admin/search-user')}}" method="post">
			<input name="_token" type="hidden" value="{{ csrf_token() }}">
     	  <div class="col-xs-3 col-xs-offset-1">
      	   		<input placeholder="Looking for someone?" type="text" name="user" class="form-control" value="{{ Request::get('user') }}">
     	  </div>

     	  <div class="col-xs-3 col-xs-offset-1">
    		<input type="submit" class="btn btn-primary" value="Search">
     	  </div>
    	</form>
  </div>

<hr>
<div class="row">
	<div class="col-md-offset-1 col-md-2 col-xs-4">
		<a href="{{ url('admin/customers') }}">Customers</a>
	</div>
	<div class="col-md-2 col-xs-4">
		<a href="{{ url('admin/experts') }}">Experts</a>
	</div>
</div>
<hr>
@if(isset($categories))
<div class="row">
@foreach($categories as $category)
	<form action="{{url('admin/save-category')}}" method="post">
		<input name="_token" type="hidden" value="{{ csrf_token() }}">
		<input name="id" type="hidden" value="{{$category->id}}">
		<input name="title" type="hidden" value="{{$category->title}}">
		<div class="col-md-3 col-xs-4">
			<i class="edit btn btn-default fa fa-edit"></i> <a href="{{ url('admin/delete-category/' . $category->id) }}" onclick="confirm('Are you sure that you want to delete this category?')"><i class="trash btn btn-default fa fa-trash"></i></a> <i class="save btn btn-default fa fa-save"></i> <i class="close btn btn-default fa fa-close"></i> <a class="name" href="{{ url('admin/experts/' . $category->id )  }}">{{$category->title}}</a>
		</div>
	</form>
@endforeach
</div>
<hr>
@endif
			    <div class="row">
			        <div class="col-md-10 col-md-offset-1">
			            <div class="panel panel-default">
			                <div class="panel-heading">User list</div>

			                  <div class="panel-body">
			                    <table class="table table-striped">

			                      <thead>
			                        <th>Full name</th>
			                        <th>Email</th>
			                        <th>Created</th>
			                        <th>&nbsp;</th>
			                        <th>&nbsp;</th>
			                        <th>&nbsp;</th>
			                      </thead>

			                      <tbody>
			                        @foreach ($users as $user)
			                          <tr>
			                            <td>
			                              <div>{{ $user->firstname }}{{ ($user->middlename != '' ? ' '.$user->middlename.' '  : ' ') }}{{ $user->lastname }}</div>
			                            </td>
			                            <td>
			                              <div>{{ $user->email }}</div>
			                            </td>
			                            <td>
			                             <div>{{ date('d.m.Y. H:i', strtotime($user->created_at)) }}</div>
			                            </td>
			                            <td>
			                              <div>
			                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#user-{{ $user->id }}">
			                                  <i class="fa fa-eye"></i>
			                                </button>
			                               <div class="modal fade" id="user-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			                               <div class="modal-dialog modal-lg" role="document">
			                                <div class="modal-content">
			                                  <div class="modal-header">
			                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                                    <h4 class="modal-title" id="myModalLabel">{{ $user->firstname }}{{ ($user->middlename != '' ? ' '.$user->middlename.' '  : ' ') }}{{ $user->lastname }}</h4>
			                                  </div>
			                                  <div class="modal-body">

			                                  <div class="row">
			                                    <div class="col-md-6">
			                                    <table class="table table-striped table-condensed">
			                                      <tr>
			                                        <th>Profile ID</th>
			                                        <td>{{ $user->id }}</td>
			                                      </tr>
			                                      <tr>
			                                        <th>Created at</th>
			                                        <td>{{ date('d.m.Y. H:i:s', strtotime($user->created_at)) }}</td>
			                                      </tr>
			                                      <tr>
			                                        <th>Modified at</th>
			                                        <td>{{ date('d.m.Y. H:i:s', strtotime($user->updated_at)) }}</td>
			                                      </tr>			                                      
			                                      <tr>
			                                        <th>Email</th>
			                                        <td>{{ $user->email }}</td>
			                                      </tr>
			                                      <tr>
			                                        <th>Date of birth</th>
			                                        <td>{{ date('d.m.Y.', strtotime($user->birthday)) }}</td>
			                                      </tr>
			                                      </table>
			                                  </div>
			                                  </div>
			                                  <div class="modal-footer">
			                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			                                  </div>
			                                </div>
			                              </div>
			                            </div>
			                              </div>
			                            </td>

			                            <td>
			                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#email-{{ $user->id }}">
			                              <i class="glyphicon glyphicon-envelope"></i>
			                            </button>

			                            <div class="modal fade" id="email-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			                              <div class="modal-dialog" role="document">
			                                <div class="modal-content">
			                                  <div class="modal-header">
			                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                                    <h4 class="modal-title" id="exampleModalLabel">New message</h4>
			                                  </div>
											  {{-- url('admin/sendemail') --}}
			                                  <form method="post" action="">
			                                  <div class="modal-body">
			                                      <input name="_token" type="hidden" value="{{ csrf_token() }}">
			                                      <div class="form-group">
			                                        <label for="recipient-name" class="control-label">Recipient:</label>
			                                        <input type="email" class="form-control" id="recipient-name" name="email" value="{{ $user->email }}">
			                                      </div>
			                                      <div class="form-group">
			                                        <label for="message-text" class="control-label">Message:</label>
			                                        <textarea class="form-control" id="message-text" name="message"></textarea>
			                                      </div>

			                                  </div>
			                                  <div class="modal-footer">
			                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			                                    <button type="submit" class="btn btn-primary">Send email</button>
			                                  </form>
			                                  </div>
			                                </div>
			                              </div>
			                            </div>

			                            </td>

			                            <td>
										  @if( !$user->suspended )
  										  	<form action="{{ url('admin/suspend') }}" method="post">
												<input name="_token" type="hidden" value="{{ csrf_token() }}">
												<input name="id" type="hidden" value="{{$user->id}}">
												<input type="submit" class="btn btn-danger" value="Suspend">
  			                                </form>
										  @else
										  	<form action="{{ url('admin/active') }}" method="post">
												<input name="_token" type="hidden" value="{{ csrf_token() }}">
										   		<input name="id" type="hidden" value="{{$user->id}}">
												<input type="submit" class="btn btn-success" value="Active">
											</form>
										  @endif
			                            </td>

			                            <td>
										  	<form id="deleteForm" action="{{ url('admin/delete-user') }}" method="post">
												<input name="_token" type="hidden" value="{{ csrf_token() }}">
										   		<input name="id" type="hidden" value="{{$user->id}}">
												<i class="deleteUser btn btn-danger fa fa-trash"></i>
											</form>
			                            </td>
			                          </tr>
			                        @endforeach
			       				</tbody>
			       </table>
				</div>
			</div>
@endsection

@section('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endsection
