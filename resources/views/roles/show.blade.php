@extends('layouts.template')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1 style="text-align: center">{{ ucfirst($role->name) }} Role</h1>
        <div class="lead">

        </div>

        <div class="container mt-4">

            <h3 style="text-align: center">Autorisations attribuées</h3>

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
        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">Modifier</a>

    </div>
@endsection
