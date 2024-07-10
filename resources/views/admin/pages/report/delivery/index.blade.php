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
                  <h4>Доставщик продажа
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
                <form action="{{route('report-delivery')}}" method="GET">
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
                                Имя	
                            </th>
                            <th>
                                Количество
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
                              <a href="{{route('history-admin',$user->id)}}">{{$user->username}}</a>
                            </td>
                            <td class="align-middle">
                              {{number_format($user->sale->sum('quantity'))}}
                            </td>
                            <td class="align-middle">
                              {{-- {{$admin->KPI}} сум --}}
                            </td>
                            <td class="align-middle">
                              {{number_format($user->sale->sum(function($t){return $t->delivery_kpi * $t->quantity;}))}} сум
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
@endsection

