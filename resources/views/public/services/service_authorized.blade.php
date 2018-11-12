@extends('public.layouts.sec')

@section('htmlheader_title')
{{ trans('message.authorized_service_centers') }}
@endsection

@section('main-content')
<div class="about-block content" id="support">
	<div class="container-fluid">
		<div class="row search-parent">
			<img src="/img/page/yezztalk/banner_master.jpg" class="img-responsive">
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<h2 class="title-support">{{ trans('message.authorized_service_centers') }}</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<table id="datagrid" class="table table-striped table-bordered" role="grid">
					<thead>
						<tr>
							<th class="text-center" data-priority="1">{{ trans('message.product') }}</th>
							<th class="text-center" data-priority="1"></th>
							<th class="text-center" data-priority="1">{{ trans('message.part_number') }}</th>
							<th class="text-center" data-priority="1">{{ trans('message.hardware_version') }}</th>
							<th class="text-center" data-priority="2">{{ trans('message.system_operative') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($softwares as $item)
						<tr>
							<td class="text-center"><a href="/products/{{$item->product->model_id}}/{{$lang_country}}">{{ $item->product->model }}</a></td>
							<td class="text-center"><a href="{{ route('download.software', [$item->id]) }}"><i class="fa fa-cloud-download fa-2x" aria-hidden="true"></i></a></td>
							<td class="text-center">{{ $item->part_number }}</td>
							<td class="text-center">{{ $item->hardware_version }}</td>
							<td class="text-center">{{ $item->system_operative->name }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Countries Modal -->
@include('public.layouts.partials.countries') 
<!-- END Countries Modal -->

<script>
	var lang = {
	    search : "{{ trans('message.search') }}",
	    zeroRecords: "{{ trans('message.zeroRecords') }}",
	    paginate: {
	    	first:      "{{ trans('message.first') }}",
	    	previous:   "{{ trans('message.previous') }}",
	    	next:       "{{ trans('message.next') }}",
	    	last:       "{{ trans('message.last') }}"
	    }
	};

	$(document).ready(function() {

		var datagrid = $('#datagrid').dataTable({
			responsive: true,
			dom: 'Bfrtip',
			language : lang,
			columnDefs: [
		        { responsivePriority: 1, targets: 0 },
		        { responsivePriority: 2, targets: -1 }
		    ]
		});
	});
</script>
@endsection