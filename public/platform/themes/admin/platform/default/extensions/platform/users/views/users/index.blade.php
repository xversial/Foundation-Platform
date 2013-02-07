@extends('templates/default')

@section('title')
{{ Lang::get('platform/users::users/general.title') }}
@stop

@section('assets')

@stop

@section('scripts')

@stop

@section('content')
<div class="page-header">
	<h3>
		{{ Lang::get('platform/users::users/general.title') }}

		<div class="pull-right">
			<a href="{{ URL::to(ADMIN_URI . '/users/create') }}" class="btn btn-info btn-small">{{ Lang::get('button.create') }}</a>
		</div>
	</h3>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>{{ Lang::get('platform/users::users/table.id') }}</th>
			<th>{{ Lang::get('platform/users::users/table.first_name') }}</th>
			<th>{{ Lang::get('platform/users::users/table.last_name') }}</th>
			<th>{{ Lang::get('platform/users::users/table.email') }}</th>
			<th>{{ Lang::get('platform/users::users/table.groups') }}</th>
			<th class="span2">{{ Lang::get('platform/users::users/table.activated') }}</th>
			<th class="span2">{{ Lang::get('table.actions') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($users as $user)
			<tr>
				<td>
					{{ $user->id }}
				</td>
				<td>
					{{ $user->first_name }}
				</td>
				<td>
					{{ $user->last_name }}
				</td>
				<td>
					<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
				</td>
				<td>
					{{ implode(', ', array_map(function($group) { return $group->name; }, $user->groups->all())) }}
				</td>
				<td>
					{{ Lang::get('general.' . ($user->isActivated() ? 'yes' : 'no')) }}
				</td>
				<td>
					<div class="btn-group">
						<a href="{{ URL::to(ADMIN_URI . "/users/edit/{$user->id}") }}" class="btn btn-small">
							{{ Lang::get('button.edit') }}
						</a>
						@if ($user->id !== Sentry::getId())
						<a href="{{ URL::to(ADMIN_URI . "/users/delete/{$user->id}") }}" class="btn btn-small btn-danger">
							{{ Lang::get('button.delete') }}
						</a>
						@endif
					</div>
				</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">
				<div class="pull-right">
					{{ $users->links() }}
				</div>
			</td>
		</tr>
	</tfoot>
</table>
@stop
