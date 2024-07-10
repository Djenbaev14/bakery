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
          <h4>История клиента</h4>
        </div>
        <div class="card-body">
          <form action="{{route('clients.show',$client->id)}}" method="GET">
            <div class="row">
              <div class="col-md-6 form-group">
                  <input type="date" name="start_date" value="{{$start_date}}"   required class="form-control pl-2 pr-2" >
                </div>
                <div class="col-md-6 form-group">
                  <input type="date" name="end_date" value="{{$end_date}}"  required class="form-control pl-2 pr-2" >
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
            <table id="myTable" class="table table-sm table-striped table-hover">
                <thead class="table-bordered">
                    <tr>
                        <th>
                          Имя
                        </th>
                        <th>
                          Тан нарх
                        </th>
                        <th>
                          Толанган нарх
                        </th>
                        <th>
                          Миқдор (дона)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($breads as $bread)
                    @if (count($bread->sale) > 0)
                      <tr>
                        <td class="align-middle">
                          {{$bread->name}}
                        </td>
                        <td class="align-middle">
                          {{number_format($bread->sale->sum(function($t){ return $t->quantity * $t->price; })) }} сум
                        </td>
                        <td class="align-middle">
                          {{number_format($bread->sale_history->sum('paid')) }} сум
                        </td>
                        <td class="align-middle">
                          {{number_format($bread->sale->sum('quantity')) }}
                        </td>
                      </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <h2>Продажа нет</h2>
                        </td>
                    @endforelse
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
@endsection

