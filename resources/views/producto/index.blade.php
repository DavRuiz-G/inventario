@extends('tablar::page')

@section('title')
    Producto
@endsection

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        List
                    </div>
                    <h2 class="page-title">
                        {{ __('Producto ') }}
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('productos.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Create Producto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            @if(config('tablar','display_alert'))
                @include('tablar::common.alert')
            @endif
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Producto</h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-muted">
                                    Show
                                    <div class="mx-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm" value="10" size="3"
                                               aria-label="Invoices count">
                                    </div>
                                    entries
                                </div>
                                <div class="ms-auto text-muted">
                                    <form method="GET" action="{{ route('productos.index') }}" class="d-inline-block">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control form-control-sm"
                                            placeholder="Search..." value="{{ request('search') }}" aria-label="Search">
                                        <button type="submit" class="btn btn-sm btn-primary">Buscar</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                        <div class="table-responsive min-vh-100">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all"></th>
                                    <th class="w-1">
                                        <a href="{{ route('productos.index', ['sortBy' => 'id', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            Id.
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('productos.index', ['sortBy' => 'nombre', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            Nombre
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('productos.index', ['sortBy' => 'codigo', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            Codigo
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('productos.index', ['sortBy' => 'descripcion', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            Descripcion
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('productos.index', ['sortBy' => 'precio', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            Precio
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('productos.index', ['sortBy' => 'cantidad_inicial', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            Cantidad Inicial
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('productos.index', ['sortBy' => 'created_at', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            Fecha de Creación
                                        </a>
                                    </th>
                                </tr>
                            </thead>

                                <tbody>
                                @forelse ($productos as $producto)
                                    <tr>
                                        <td><input class="form-check-input m-0 align-middle" type="checkbox"
                                                   aria-label="Select producto"></td>
                                        <td>{{ $producto->id }}</td>
                                        
											<td>{{ $producto->nombre }}</td>
											<td>{{ $producto->codigo }}</td>
											<td>{{ $producto->descripcion }}</td>
											<td>{{ $producto->precio }}</td>
											<td>{{ $producto->cantidad_inicial }}</td>
                                            <td>{{ $producto->created_at }}</td>

                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top"
                                                            data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                           href="{{ route('productos.show',$producto->id) }}">
                                                            View
                                                        </a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('productos.edit',$producto->id) }}">
                                                            Edit
                                                        </a>
                                                        <form
                                                            action="{{ route('productos.destroy',$producto->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    onclick="if(!confirm('Do you Want to Proceed?')){return false;}"
                                                                    class="dropdown-item text-red"><i
                                                                    class="fa fa-fw fa-trash"></i>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <td>No Data Found</td>
                                @endforelse
                                </tbody>

                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                         {!! $productos->appends(['search' => request('search'), 'sortBy' => request('sortBy'), 'sortDirection' => request('sortDirection')])->links('tablar::pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
