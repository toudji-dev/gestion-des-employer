@extends('layouts.template')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="lead">

        </div>

        <div class="container mt-4">

            <h3 style="text-align: center">Autorisations attribuées a {{ ucfirst($role->name) }} role </h3>

            <table class="table table-striped">
                <thead>
                    <th scope="col" width="20%">Name</th>
                    <th scope="col" width="1%">Guard</th>
                </thead>

                @foreach ($rolePermissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <a href="{{ route('administrateurs') }}" class="btn btn-primary">Retourner à la page précédente</a>

    </div>
@endsection
