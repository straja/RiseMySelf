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
    <form method="post">

      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="col-xs-4 col-xs-offset-1">
        <select name="statistic" id="statistictype" class="form-control">
          <option value="">-- Select Statistic --</option>
          <option value="posibilities" {{ $type == 'posibilities' ? 'selected' : '' }}>Posibilities</option>
          <option value="popularity" {{ $type == 'popularity' ? 'selected' : '' }}>Expert popularity</option>
          <option value="prices" {{ $type == 'prices' ? 'selected' : '' }}>Rang list of Expert prices</option>
          <option value="experts" {{ $type == 'experts' ? 'selected' : '' }}>Expert statistics</option>
        </select>
      </div>
	  
      <div class="col-xs-2 col-xs-offset-1">
        <select name="category" id="categorytype" class="form-control">
          <option value="">All Categories</option>
          @foreach($categories as $category)
          	<option value="{{$category->id}}" {{ $categorytype == $category->id ? 'selected' : '' }}>{{$category->title}}</option>
          @endforeach
		  </select>
      </div>

      <div class="col-xs-2 col-xs-offset-1">
        <input type="submit" class="btn btn-primary" value="Analyze">
      </div>
    </form>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
		@if($type == 'posibilities')
			<div class="panel-heading">Posibility Statistics</div>
		@endif
		
		@if($type == 'popularity')
			<div class="panel-heading">Experts Popularity</div>
		@endif
		
		@if($type == 'prices')
			<div class="panel-heading">Rang list of Experts per prices</div>
		@endif
		
		@if($type == 'experts')
			<div class="panel-heading">Expert Statistics</div>
		@endif

        <div class="panel-body">

			@if($type == 'posibilities' )
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<p>Feedbacks</p>
					<table>
						<tr>
							<th>Title</th>
						</tr>
						@foreach($feedbacks as $feedback)
							<tr>
								<td><a class="feedbackTitle"data-toggle="modal" data-target="#feedback{{$feedback->id}}">{{$feedback->title}}</a></td>
					               <div class="modal fade" id="feedback{{$feedback->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					               <div class="modal-dialog modal-sm" role="document">
					                <div class="modal-content">
					                  <div class="modal-header">
					                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					                    <h4 class="modal-title" id="myModalLabel">{{$feedback->title}}</h4>
					                  </div>
					                	<div class="modal-body">
											<div class="row">
												<div class="col-md-12">
					                    			{{$feedback->feedback}}
					                  			</div>
									  		</div>
					                  	</div>
					                  <div class="modal-footer">
					                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
					                </div>
					              </div>
					            </div>
							</tr>
						@endforeach
					</table>
				</div>
				<div class="col-md-6 col-xs-12">
					<p>Searches</p>
					<table id="search-table">
						<tr>
							<th>Word</th>
							<th>Mention</th>
						</tr>
						<?php $num = 1;?>
						@foreach($searches as $word)
							<tr>
								<td>{{$num++}}. {{$word->text}}</td>
								<td>{{$word->count}} times</td>
							</tr>
						@endforeach
					</table>
					
					<div id="search-pie"></div>
					
				</div>
			</div>
			@endif
			
			@if($type == 'popularity')
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<p>Rang list of Experts by popularity</p>
					<table id="experts-price-table">
						<tr>
							<th class="col-xs-2">Row No.</th>
							<th class="col-md-4">Full Name</th>
							<th class="col-md-3">E-mail</th>
							<th class="col-md-3">Popularity Value</th>
						</tr>
						<?php $num = 1;?>
						@foreach($experts as $expert)
							<tr>
								<td class="col-xs-2">{{$num++}}</td>
								<td class="col-md-4">{{$expert->firstname}} {{$expert->middlename != '' ? $expert->middlename.' ' : ''}}{{$expert->lastname}}</td>
								<td class="col-md-3">{{$expert->email}}</td>
								<td class="col-md-3">{{$expert->value}} points</td>
							</tr>
						@endforeach
					</table>
					
					<div id="experts-popularity-stistics"></div>
				</div>
			</div>
			@endif
			
			@if($type == 'prices')
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<p>Rang list  of Experts by prices</p>
					<table id="experts-price-table">
						<tr>
							<th class="col-xs-2">Row No.</th>
							<th class="col-md-4">Full Name</th>
							<th class="col-md-3">E-mail</th>
							<th class="col-md-3">Price ( € per hour )</th>
						</tr>
						<?php $num = 1;?>
						@foreach($experts as $expert)
							<tr>
								<td class="col-xs-2">{{$num++}}</td>
								<td class="col-md-4">{{$expert->firstname}} {{$expert->middlename != '' ? $expert->middlename.' ' : ''}}{{$expert->lastname}}</td>
								<td class="col-md-3">{{$expert->email}}</td>
								<td class="col-md-3">{{$expert->price}} €/h</td>
							</tr>
						@endforeach
					</table>
					
					<div id="experts-price-stistics"></div>
					
				</div>
			</div>
			@endif
			
			@if($type == 'experts')
			@endif
			
			@if($type == '')
				<p>Statistic isn't selected</p>
			@endif

          </div>

        </div>
      </div>
    </div>
  </div>
@endsection


@section('scripts')
	<script src="{{ asset('js/app.js') }}"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
	@if($type == 'posibilities')
	<script type="text/javascript">
		google.charts.load("current", {packages:["corechart"]});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Word', 'Number of mations'],
				@foreach($searches as $word)
					['{{$word->text}}', {{ $word->count }}],
				@endforeach
			]);

			var options = {
      		  title: 'Analitycs of Search',
      		  pieHole: 0.3,
    		};

			var chart = new google.visualization.PieChart(document.getElementById('search-pie'));
			chart.draw(data, options);
		}
	</script>
	@endif
	
	@if($type == 'prices' )
	<script type="text/javascript">
		google.charts.load("current", {packages:["corechart"]});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Full Name', 'Price ( € per hour )'],
				@foreach($experts as $expert)
					['{{$expert->firstname}} {{$expert->middlename != '' ? $expert->middlename.' ' : ''}}{{$expert->lastname}}', {{ $expert->price }}],
				@endforeach
			]);

			var options = {
      		  title: 'Analitycs of Experts prices',
      		  pieHole: 0.3,
  	        };
			
	        var chart = new google.visualization.PieChart(document.getElementById('experts-price-stistics'));
			chart.draw(data, options);
		}
	</script>
	@endif
	
	@if($type == 'popularity' )
	<script type="text/javascript">
		google.charts.load("current", {packages:["corechart"]});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Full Name', 'Popularity Value'],
				@foreach($experts as $expert)
					['{{$expert->firstname}} {{$expert->middlename != '' ? $expert->middlename.' ' : ''}}{{$expert->lastname}}', {{ $expert->value }}],
				@endforeach
			]);

			var options = {
      		  title: 'Analitycs of Experts popularity',
      		  pieHole: 0.3,
  	        };
			
	        var chart = new google.visualization.PieChart(document.getElementById('experts-popularity-stistics'));
			chart.draw(data, options);
		}
	</script>
	@endif
	
@endsection