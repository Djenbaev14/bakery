@extends('admin.layouts.main')

@section('title', 'Trio System')

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
                    <div class="col-12"><h4>Отчет ДДС</h4></div>
                    <div class="col-12">
                      <form action="{{route('report-money')}}" method="GET">
                        <select name="year" class="form-select">
                            @for ($i = 2023; $i <= date('Y'); $i++)
                              <option value="{{$i}}" <?=($i==date('Y')) ? "selected" : "";?>>{{$i}}</option> 
                            @endfor
                        </select>
                        <input type="submit" value="Филтр" class="">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
  <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block row" style="overflow: auto">
                    <table class="col-12 table-bordered ">
                        <thead>
                            <tr>
                              <th>
                              </th>
                              <th>Январь </th>
                              <th>Февраль </th>
                              <th> Март  </th>
                              <th> Апрелб  </th>
                              <th>Май</th>
                              <th> Июнь </th>
                              <th> Июль </th>
                              <th> Август </th>
                              <th> Сентябрь </th>
                              <th> Октябрь </th>
                              <th> Ноябрь </th>
                              <th> Декабрь </th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr class="bg-warning text-light">
                            <td>Покупатели</td>
                            @for ($i = 1; $i <=12; $i++)
                                <td>{{ number_format(SaleHistories($year,$i)) }}</td>
                            @endfor
                          </tr>

                          <tr>
                            <td>Выплаты</td>
                            @for ($i = 1; $i <=12; $i++)
                                <td>{{ number_format(Paid($year,$i)) }}</td>
                            @endfor
                          </tr>

                          @foreach (expenditure_name() as $expen)
                              <tr>
                                  <td>{{$expen->name}}</td>
                                  @for ($i = 1; $i <=12; $i++)
                                      <td>{{ number_format(Expenditure($year,$i,$expen->id)) }}</td>
                                  @endfor
                              </tr>
                          @endforeach
                          
                          <tr class="bg-success text-light">
                            <td>Остаток</td>
                            @for ($i = 1; $i <=12; $i++)
                                {{-- <td>{{ number_format(SaleHistories($year,$i)-Paid($year,$i)) }}</td> --}}
                                <td>0</td>
                            @endfor
                          </tr>

                          <tr class="bg-success text-light">
                            <td>Не подтвержденные</td>
                            @for ($i = 1; $i <=12; $i++)
                                <td>{{ number_format(noConfir($year,$i)) }}</td>
                            @endfor
                          </tr>
                          
                          <tr class="bg-success text-light">
                            <td>Наличные</td>
                            @for ($i = 1; $i <=12; $i++)
                                <td>{{ number_format(cashPaid($year,$i)) }}</td>
                            @endfor
                          </tr>
                          
                          <tr class="bg-success text-light">
                            <td>Перечисления</td>
                            @for ($i = 1; $i <=12; $i++)
                                <td>{{ number_format(transfersPaid($year,$i)) }}</td>
                            @endfor
                          </tr>
                        </tbody>
                    </table>
                </div>
            
            </div>
        </div>
  </div>
@endsection

