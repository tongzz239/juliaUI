@extends('sidebars.dashboardSidebar')

@section('body')
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Repository</th>
                <th scope="col">Regular expression</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($arr as $row)
                <tr>
                    <th>{{ $row["id"] }}</th>
                    <td>{{ $row["repository"] }}</td>
                    <td>{{ $row["filter"] }}</td>
                    <td>{{ $row["created_at"] }}</td>
                    @if ($row["state_id"] == 1)
                        <td class="text-success">Ready</td>
                    @else
                        <td class="text-muted">Not ready</td>
                    @endif
                    <td><a href="/dashboard/similarities/{{ $row['julias_check_id'] }}" class="btn btn-light btn-sm" role="button" aria-pressed="true">Veiw</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
