<h2>Data Filtered</h2>
@foreach ($data as $row)
    <tr>
        @foreach ($row as $cell)
            <td>{{ $cell }}</td>
        @endforeach
    </tr>
@endforeach
