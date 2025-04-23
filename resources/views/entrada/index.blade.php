@extends('tablar::page')

@section('title')
    Entrada
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
                        {{ __('Entrada ') }}
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('entradas.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Create Entrada
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Entradas</h3>
                    </div>
                    <div class="card-body border-bottom py-3">
                        <div class="d-flex">
                            <div class="text-muted">
                                Show
                                <div class="mx-2 d-inline-block">
                                    <input type="text" class="form-control form-control-sm" value="10" size="3" aria-label="Invoices count">
                                </div>
                                entries
                            </div>
                            <div class="ms-auto text-muted">
                                <form method="GET" action="{{ route('entradas.index') }}" class="d-inline-block">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ request('search') }}" aria-label="Search">
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
                                    <th>
                                        <a href="{{ route('entradas.index', ['sortBy' => 'id', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            Id
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('entradas.index', ['sortBy' => 'producto_id', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            Producto
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('entradas.index', ['sortBy' => 'tipo', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            Tipo
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('entradas.index', ['sortBy' => 'cantidad', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            Cantidad
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($entradas as $entrada)
                                    <tr>
                                        <td>{{ $entrada->id }}</td>
                                        <td>{{ $entrada->producto->nombre ?? 'Producto no encontrado' }}</td>
                                        <td>{{ $entrada->tipo }}</td>
                                        <td>{{ $entrada->cantidad }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No Data Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center">
                        {!! $entradas->appends(['search' => request('search'), 'sortBy' => request('sortBy'), 'sortDirection' => request('sortDirection')])->links('tablar::pagination') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
