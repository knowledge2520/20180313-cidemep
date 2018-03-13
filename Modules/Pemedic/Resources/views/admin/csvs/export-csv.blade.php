<table class="table">
    <tr>
        <th>{{ trans('pemedic::patients.table.email') }}</th>
        <th>{{ trans('pemedic::patients.table.name') }}</th>
        <th>{{ trans('pemedic::patients.table.phone') }}</th>
        <th>{{ trans('pemedic::patients.table.address') }}</th>
        <th>{{ trans('pemedic::patients.table.gender') }}</th>
        <th>{{ trans('pemedic::patients.table.dob') }}</th>
        <th>{{ trans('pemedic::patients.table.type') }}</th>
    </tr>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->user->email }}</td>
        <td>{{ $user->full_name }}</td>
        <td>{{ $user->phone }}</td>
        <td>{{ $user->address }}</td>
        <td>{{ $user->gender }}</td>
        <td>{{ $user->dob }}</td>
        <td>{{ $user->type }}</td>
    </tr>
    @endforeach
</table>