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
                      <div class="col-12"><h4>Продажи {{$user->username}}
                      </h4>
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
        <div class="card-block">
          <form action="{{route('history-admin',$user->id)}}" method="GET">
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
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block" style="overflow: auto">
                  <table id="myTable" class="table-sm table-bordered table-striped table-hover bg-light bg-gradient" style="width: 100%;min-width:100%;table-layout:auto;">
                    <thead>
                        <tr>
                            <th>
                              Маҳсулот номи	
                            </th>
                            <th>
                              Маъсул
                            </th>
                            <th>
                              Xаридор
                            </th>
                            <th>
                              Товар нархи
                            </th>
                            <th>
                              Тан нарх
                            </th>
                            <th>
                              Толанган нарх
                            </th>
                            <th>
                              Карз нархи
                            </th>
                            <th>
                              Миқдор (дона)
                            </th>
                            <th>
                              Вақти
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $sale)
                        <tr>
                            <td class="align-middle">
                                {{$sale->bread->name}}
                            </td>
                            <td class="align-middle">
                                {{$sale->user->username}}
                            </td>
                            <td class="align-middle">
                                {{$sale->client->name}}
                            </td>
                            <td class="align-middle">
                              {{number_format($sale->price)}} сум
                            </td>
                            <td class="align-middle">
                              {{number_format($sale->price * $sale->quantity)}} сум
                            </td>
                            <td class="align-middle">
                              {{number_format($sale->sale_history->sum('paid'))}} сум
                            </td>
                            <td class="align-middle">
                              {{($sale->price * $sale->quantity-$sale->sale_history->sum('paid') > 0)? number_format($sale->price * $sale->quantity-$sale->sale_history->sum('paid')) :  0;}} сум
                            </td>
                            <td class="align-middle">
                              {{number_format($sale->quantity)}}
                            </td>
                            <td class="align-middle">
                              {{\Carbon\Carbon::parse($sale->created_at)->format('d M Y H:i:s')}}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">
                                <h2>Продажи нет</h2>
                            </td>
                        @endforelse
                    </tbody>
                </table>
                <div class="row m-1">
                  <span class="border border-primary text-primary font-weight-bold  rounded mt-2 pr-1 pl-1  mr-4 mb-2">Жами савдоси: {{number_format($sales_total_sum)}} сум</span>
                  <span class="border border-success text-success font-weight-bold  rounded mt-2 pr-2 pl-2  mr-4 mb-2">Туланди : {{number_format($sale_histories->sum('paid'))}} сум</span>
                  <span class="border border-warning text-warning font-weight-bold  rounded mt-2 pr-2 pl-2  mr-4 mb-2">Накд савдо: {{number_format($sale_histories->where('type','nal')->sum('paid'))}} сум</span>
                  <span class="border border-info text-info font-weight-bold  rounded mt-2 pr-2 pl-2  mr-4 mb-2">Терминал  : {{number_format($sale_histories->where('type','per')->sum('paid'))}} сум</span>
                  <span class="border border-danger text-danger font-weight-bold  rounded mt-2 pr-2 pl-2  mr-4 mb-2">Карз : {{number_format($sales_total_sum-$sale_histories->sum('paid'))}} сум</span>
                </div>
                <div class="row">
                  <p class="d-flex justify-content-end">{{$sales->links('pagination::bootstrap-4')}}</p>
                </div>
            </div>
        </div>
  </div>
@endsection

