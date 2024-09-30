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
                    <h4>Платежи
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
                <div class="card-block" style="overflow: auto">
                    <form action="{{route('report-sale')}}" method="GET">
                        <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="date" name="start_date" required class="form-control" value="{{ $start_date }}">
                            </div>
                            <div class="col-md-6 form-group">
                            <input type="date" name="end_date" required class="form-control" value="{{ $end_date }}">
                            </div>
                            <div class="col-md-12 form-group" >
                            <input type="submit" class="btn btn-sm btn-primary" value="Фильтр">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Туловлар</h5>
                </div>
                <div class="card-body">
                    
                    <table class="table table-sm table-bordered ">
                        <thead>
                            <tr>
                                <th>
                                    Количество	
                                </th>
                                <th>
                                    Тип	
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{number_format($sale_histories->where('type','per')->where('status',1)->sum('paid'))}} сум</td>
                                <td>Перечисления</td>
                            </tr>
                            <tr>
                                <td>{{number_format($sale_histories->where('type','nal')->where('status',1)->sum('paid'))}} сум</td>
                                <td>Наличка</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <span class="btn-info pl-2 pr-2 pt-1 pb-1 rounded">Жами пул тушди: {{number_format($sale_histories->where('status',1)->sum('paid'))}} сум</span>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Финанс</h5>
                </div>
                <div class="card-body" style="overflow: auto">
                    
                    <table class="table table-sm table-bordered ">
                        <thead>
                            <tr>
                                <th>
                                    Жами килинган савдо	
                                </th>
                                <th>
                                    Тушган пул	
                                </th>
                                <th>
                                    Кабул килинмаган пул	
                                </th>
                                <th>
                                    Карзлар
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{number_format($sales->sum(function($t){return $t->price * $t->quantity;}))}} сум</td>
                                <td>{{number_format($sale_histories->where('status',1)->sum('paid'))}} сум</td>
                                <td>{{number_format($sale_histories->where('status',0)->sum('paid'))}} сум</td>
                                <td>{{number_format($sales->sum(function($t){return $t->price * $t->quantity;}) - $sale_histories->sum('paid'))}} сум</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @foreach ($deliveries as $delivery)
            
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{$delivery->username}}</h5>
                </div>
                <div class="card-body">
                    
                    <table class="table table-sm table-bordered ">
                        <thead>
                            <tr>
                                <th>
                                    Жами килинган савдо	
                                </th>
                                <th>
                                    Тушган пул	
                                </th>
                                <th>
                                    Кабул килинмаган пул	
                                </th>
                                <th>
                                    Карзлар
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{number_format($delivery->sale->sum(function($t){return $t->price * $t->quantity;}))}} сум</td>
                                <td>{{number_format($delivery->sale_history->where('status',1)->sum('paid'))}} сум</td>
                                <td>{{number_format($delivery->sale_history->where('status',0)->sum('paid'))}} сум</td>
                                <td>{{number_format($delivery->sale->sum(function($t){return $t->price * $t->quantity;}) - $delivery->sale_history->sum('paid'))}} сум</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
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
                                    <td>{{number_format($client->sale_history->sum('paid'))}} сум</td>
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
                    target: 0,
                    render: DataTable.render.number(null, null, 0, '',' сум')
                }
            ],
            "paging":   false,
            "order": [[ 1, "desc" ]]
        });
    </script>
@endpush