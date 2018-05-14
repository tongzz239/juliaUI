@extends('sidebars.dashboardSidebar')

@section('body')
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Similarity</th>
                <th scope="col">First resource</th>
                <th scope="col">Second resource</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($similarities as $similarity)
                <tr>
                    <th>{{ $similarity["similarity"] }}%</th>
                    <td>{{ $similarity["first_resource_uri"] }}</td>
                    <td>{{ $similarity["second_resource_uri"] }}</td>
                    <td><a href='/dashboard/similarities/{{ $similarity["julias_check_id"] }}/similarity/{{ $similarity["julia_similarity_id"] }}' class="btn btn-light btn-sm" role="button" aria-pressed="true">Veiw</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
