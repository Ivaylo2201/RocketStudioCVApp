@foreach ($cvs as $cv)
<tr>
    <td>{{ $cv->id }}</td>
    <td>{{ $cv->created_at }}</td>
    <td>{{ $cv->person->id }}</td>
    <td>{{ $cv->person->first_name }}</td>
    <td>{{ $cv->person->middle_name }}</td>
    <td>{{ $cv->person->last_name }}</td>
    <td>{{ $cv->person->date_of_birth }}</td>
    <td>{{ $cv->university->id }}</td>
    <td>{{ $cv->university->name }}</td>
    <td>{{ $cv->university->grade }}</td>
    <td>
        @if ($cv->technologies->isNotEmpty())
        {{ $cv->technologies->pluck('name')->implode(', ') }}
        @else
        Няма записани технологии
        @endif
    </td>
</tr>
@endforeach