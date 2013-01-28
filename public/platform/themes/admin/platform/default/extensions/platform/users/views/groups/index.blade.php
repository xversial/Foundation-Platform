@extends('templates/default')

@section('title')
{{ Lang::get('platform/users::groups/general.title') }}
@stop

@section('assets')

@stop

@section('scripts')

@stop

@section('content')
<div class="page-header">
	<h3>
		{{ Lang::get('platform/users::groups/general.title') }}

		<div class="pull-right">
			<a href="{{ URL::to(ADMIN_URI . '/users/groups/create') }}" class="btn btn-info btn-small">{{ Lang::get('button.create') }}</a>
		</div>
	</h3>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>{{ Lang::get('platform/users::groups/table.id') }}</th>
			<th>{{ Lang::get('platform/users::groups/table.name') }}</th>
			<th>{{ Lang::get('table.actions') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($groups as $group)
			<tr>
				<td>
					{{ $group->id }}
				</td>
				<td>
					{{ $group->name }}
				</td>
				<td class="span2">
					<div class="btn-group">
						<a href="{{ URL::to(ADMIN_URI . "/users/groups/edit/{$group->id}") }}" class="btn btn-small">
							{{ Lang::get('button.edit') }}
						</a>
						<a href="{{ URL::to(ADMIN_URI . "/users/groups/delete/{$group->id}") }}" class="btn btn-small btn-danger">
							{{ Lang::get('button.delete') }}
						</a>
					</div>
				</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">
				<div class="pull-right">
					{{ $groups->links() }}
				</div>
			</td>
		</tr>
	</tfoot>
</table>
@stop
