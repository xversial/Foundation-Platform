@foreach ($rows as $row)
    <tr>
        <td><a href="{{ URL::to_admin('localisation/currency/edit/' . $row['slug']) }}">{{ $row['name'] }}</a></td>
        <td>{{ $row['code'] }}</td>
        <td>
            <div class="btn-group">
                <a class="btn btn-mini" href="{{ URL::to_admin('localisation/currency/edit/' . $row['slug']) }}">{{ Lang::line('button.edit') }}</a>
                @if ($default_currency != $row['code'])
                <a class="btn btn-mini btn-danger" href="{{ URL::to_admin('localisation/currency/delete/' . $row['slug']) }}">{{ Lang::line('button.delete') }}</a>
                @endif
            </div>
        </td>
    </tr>
@endforeach
