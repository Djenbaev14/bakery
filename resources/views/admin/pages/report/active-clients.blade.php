@extends('admin.layouts.main')

@section('title', 'Все новости')

@section('breadcrumb')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    {{-- <h5 class="m-b-10">Новости</h5> --}}
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
                    <div class="col-12"><h4>Актив клиенты
                    </h4></div>
                  </div>
                  
                  <form action="{{route('report-active')}}" method="GET">
                    <div class="row">
                      <div class="col-md-6 form-group">
                          <input type="date" name="start_date" required class="form-control" value="{{ $start_date }}">
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="date" name="end_date" required class="form-control" value="{{ $end_date }}">
                        </div>
                        <div class="col-md-2 form-group" >
                          <input type="submit" class="btn btn-sm btn-primary" value="Фильтр">
                        </div>
                    </div>
                  </form>
                </div>
              </div>
          </div>
      </div>
  </div>
  <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block" style="overflow: auto">
                  <h5>Основной</h5>
                    <table class="table table-sm table-bordered table-striped table-hover mt-4">
                        <thead>
                            <tr>
                                <th>
                                    Имя клиента	
                                </th>
                                <th>
                                    Телефон номер	
                                </th>
                                <th>
                                    Общий объем продаж
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clients as $client)
                            <tr>
                                <td class="align-middle">
                                  {{$client->name}}
                                </td>
                                <td class="align-middle">
                                  {{$client->phone}}
                                </td>
                                <td class="align-middle">
                                  {{number_format($client->sale->sum(function($t){return $t->price * $t->quantity;}))}} сум
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h2>Клента нет</h2>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row m-1">
                        {{-- <span class="bg-info bg-gradient rounded text-light po --}}
                    </div>
                </div>
            
            </div>
        </div>
  </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block" style="overflow: auto">
                  <h5>Перечисления</h5>
                    <table class="table table-bordered table-striped table-hover mt-4">
                        <thead>
                            <tr>
                                <th>
                                    Имя клиента	
                                </th>
                                <th>
                                    Телефон номер	
                                </th>
                                <th>
                                    Общий объем продаж
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kindergardens as $client)
                            <tr>
                                <td class="align-middle">
                                  {{$client->name}}
                                </td>
                                <td class="align-middle">
                                  {{$client->phone}}
                                </td>
                                <td class="align-middle">
                                  {{number_format($client->sale->sum(function($t){return $t->price * $t->quantity;}))}} сум
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h2>Клента нет</h2>
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row m-1">
                        {{-- <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Общая итог: {{number_format($coming_total)}} сум</span> --}}
                    </div>
                </div>
            </div>
        </div>
  </div>
  <canvas id="myChart" style="width:100%;max-width:100%"></canvas>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">

@endpush
@push('js')
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script>
    var users={!! $clients !!};
    var xValues=[];
    var yValues=[];
    var barColors=[];
    users.forEach(e => {
        xValues.push(e.name)
        barColors.push("blue");
        let sum = 0;

        for( i = 0; i < e.sale.length; i++)
        sum += e.sale[i].quantity * e.sale[i].price
        yValues.push(sum)
    });
    
    new Chart("myChart", {
        type: "bar",
        data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
        },
        options: {
        legend: {display: false},
        }
    });
    </script>
@endpush