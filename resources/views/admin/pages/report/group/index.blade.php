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
                  <h4>Группа
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
            <div class="card-block">
                <form action="{{route('report-group')}}" method="GET">
                  <div class="row">
                    <div class="col-md-6 form-group">
                        <input type="date" name="start_date" required class="form-control" value="{{$start_date}}">
                      </div>
                      <div class="col-md-6 form-group">
                        <input type="date" name="end_date" required class="form-control" value="{{$end_date}}">
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
  <div class="row">
      <div class="col-sm-12">
          <div class="card">
              <div class="card-block" style="overflow: auto">

                <table class="table table-sm table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                              ФИО	
                            </th>
                            <th>
                                Кол продаж
                            </th>
                            <th>
                                КПИ
                            </th>
                            <th>
                                Итого
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td class="align-middle">
                              {{$user->username}}
                            </td>
                            <td class="align-middle">
                              {{number_format($user->production->sum('quantity'))}}
                            </td>
                            <td class="align-middle">
                              {{$user->KPI}} сум
                            </td>
                            <td class="align-middle">
                              {{number_format($user->production->sum(function($t){return $t->worker_kpi * $t->quantity;}))}} сум
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
              </div>
          </div>
      </div>
  </div>
  <canvas id="myChart" style="width:100%;max-width:100%"></canvas>
@endsection

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script>
  var users={!! $users !!};
  var xValues=[];
  var yValues=[];
  var barColors=[];
  users.forEach(e => {
    xValues.push(e.username)
    barColors.push("blue");
    let sum = 0;

    for( i = 0; i < e.production.length; i++)
      sum += e.production[i].worker_kpi * e.production[i].quantity
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
      title: {
        display: true,
        text: "World Wine Production 2018"
      }
    }
  });
  </script>
@endpush