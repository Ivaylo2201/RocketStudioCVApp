@foreach ($age_range_data as $range => $data)
<tr>
    <td>{{ $range }}</td>
    <td>{{ $data['number_of_people'] }}</td>
    <td>
        {{ $data['technologies'] }}
    </td>
</tr>
@endforeach