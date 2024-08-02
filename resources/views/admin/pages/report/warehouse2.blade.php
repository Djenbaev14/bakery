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
                    <div class="col-12"><h4>Склад 2
                    </h4></div>
                  </div>
                  
                <form action="{{route('report-warehouse-2')}}" method="GET">
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
                  <h5>Общий произведенный продукт</h5>
                    <table class="table table-sm table-bordered table-striped table-hover mt-4">
                        <thead>
                            <tr>
                                <th>
                                  название продукта
                                </th>
                                <th>
                                    Количество
                                </th>
                                <th>
                                  Итого
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($coming_breads as $bread)
                            <tr>
                                <td class="align-middle">
                                  {{$bread->name}}
                                </td>
                                <td class="align-middle">
                                  <a href="store-two/{{$bread->id}}?start_date={{$start_date}}&end_date={{$end_date}}">{{number_format($bread->production->sum('quantity'))}} </a>  
                                </td>
                                <td class="align-middle">
                                  {{number_format($bread->production->sum(function($t){return $t->cost_price * $t->quantity;}) )}} сум
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h2>Производство нет</h2>
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            
            </div>
        </div>
  </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block" style="overflow: auto">
                  <h5>Всего продано товаров</h5>
                    <table class="table table-bordered table-striped table-hover mt-4">
                        <thead>
                            <tr>
                                <th>
                                  название продукта
                                </th>
                                <th>
                                    Количество
                                </th>
                                <th>
                                  Итого
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenditure_breads as $bread)
                            <tr>
                                <td class="align-middle">
                                  {{$bread->name}}
                                </td>
                                <td class="align-middle">
                                  <a href="store-two/{{$bread->id}}?start_date={{$start_date}}&end_date={{$end_date}}">{{number_format($bread->sale->sum('quantity'))}} </a>  
                                </td>
                                <td class="align-middle">
                                  {{number_format($bread->sale->sum(function($t){return $t->price * $t->quantity;}))}} сум
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h2>Производство нет</h2>
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
  </div>
@endsection

