@extends('layouts.template')

@section('content')
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">Roles</h1>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">



                    <div class="app-search-box col">
                        <form class="app-search-form" action="{{ route('role.search') }}" method="GET">
                            <input type="text" placeholder="Rechercher un role..." name="search"
                                class="form-control search-input">
                            <button type="submit" class="btn search-btn btn-primary" value=""><i
                                    class="fas fa-search"></i></button>
                        </form>
                    </div>



                    {{-- @can('role-create') --}}
                    <div class="col-auto">
                        <a class="btn app-btn-secondary" href="{{ route('roles.create') }}">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-1"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path fill-rule="evenodd"
                                    d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                            </svg>
                            Ajouter role
                        </a>
                    </div>
                    {{-- @endcan --}}


                </div>
                <!--//row-->
            </div>
            <!--//table-utilities-->
        </div>
        <!--//col-auto-->
    </div>
    <!--//row-->


    @if (Session::get('success_message'))
        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
    @endif

    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="cell">#</th>
                            <th class="cell">Nom</th>
                            <th class="cell"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($roles as $key => $role)
                            <tr>
                                <td class="cell">{{ $role->id }}</td>
                                <td class="cell"><span class="truncate">{{ $role->name }}</td>
                                <td class="cell">




                                    <a class="btn-sm app-btn-secondary" href="{{ route('roles.show', $role->id) }}">Show</a>

                                    {{-- @can('role-edit') --}}
                                    <a class="btn-sm app-btn-secondary" href="{{ route('roles.edit', $role) }}">Editer</a>
                                    {{--  @endcan --}}


                                    {{-- @can('role-delete')  --}}
                                    <a class="btn btn-danger btn-sm" href="{{ route('roles.delete', $role) }}">retirer</a>
                                    {{-- @endcan  --}}

                                </td>

                            </tr>
                        @empty

                            <tr>
                                <td class="cell" colspan="2">Aucun role ajoutés</td>

                            </tr>
                        @endforelse



                    </tbody>
                </table>
            </div>
            <!--//table-responsive-->

        </div>
        <!--//app-card-body-->
    </div>
    <!--//app-card-->
    <nav class="app-pagination">
        {{ $roles->links() }}
    </nav>
    <!--//app-pagination-->
    <!--//tab-content-->
@endsection
