@extends('admin.layouts.main')

@section('title', 'Trio System')

@section('breadcrumb')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
  <div class="row">
      <div class="col-sm-12">
          <div class="card">
              <div class="card-header">
                <div class="container">
                  <div class="row justify-content-between align-items-center">
                    <h4>Долг
                    </h4>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
  <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Клиенты</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered " id="myTable">
                        <thead>
                            <tr>
                                <th>
                                    Клиент	
                                </th>
                                <th>
                                    Количество
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clients as $client)
                                <tr>
                                    <td>{{$client->name}}</td>
                                    <td>{{client_balance($client->id)}}</td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h2>Клиента нет</h2>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css" />
@endpush

@push('js')
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        // let table = new DataTable('#myTable');
        new DataTable('#myTable', {
            columnDefs: [
                {
                    target: 1,
                    render: DataTable.render.number(null, null, 0, '',' сум')
                }
            ],
            "paging":   false,
            "order": [[ 1, "asc" ]]
        });
    </script>
@endpush