@extends('templates/default')

@section('assets')

@stop

@section('scripts')

@stop

@section('content')


<table class="table table-bordered">
	<thead>
		<tr>
			<th>{{ Lang::get('platform/users::table.users.id') }}</th>
			<th>{{ Lang::get('platform/users::table.users.first_name') }}</th>
			<th>{{ Lang::get('platform/users::table.users.last_name') }}</th>
			<th>{{ Lang::get('platform/users::table.users.email') }}</th>
			<th>{{ Lang::get('platform/users::table.users.groups') }}</th>
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
			</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5">
				<div class="pull-right">
					{{ $users->links() }}
				</div>
			</td>
		</tr>
	</tfoot>
</table>


@stop