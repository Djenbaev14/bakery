@extends('admin.layouts.main')

@section('title', 'Все новости')

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
                    <h4>Продажа
                    </h4>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
  <form action="{{route('report-sale2')}}" method="get">
    <div class="row">
      <div class="col-md-6 form-group">
        <input type="date" name="date" required class="form-control" value="{{$date}}">
        </div>
        <div class="col-md-6 form-group" >
          <input type="submit" class="btn btn-sm btn-primary" value="Фильтр">
        </div>
    </div>
  </form>
  <div class="row">
        <div class="col-sm-12">
            <div class="card">
              <div class="card-block" style="overflow: auto">
                <table class="col-8 table-sm table-bordered ">
                    <thead>
                        <tr>
                            <th>
                              Приход
                            </th>
                            <th>
                                Наименовние	
                            </th>
                            @foreach ($users as $user)
                                <th>{{$user->username}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($breads as $bread)
                          <tr>
                            <td>{{$productions->where('bread_id',$bread->id)->sum('quantity')}}</td>
                            <td>{{$bread->name}}</td>
                            @foreach ($users as $user)
                              <td>{{$sale_items->where('user_id',$user->id)->where('bread_id',$bread->id)->sum('quantity')}}</td>
                            @endforeach
                          </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">
                                <h5>Продажа нет</h5>
                            </td>
                        @endforelse
                        <tr>
                          <td>{{$productions->sum('quantity')}}</td>
                          <td></td>
                          @foreach ($users as $user)
                            <?php
                                $summa=0;
                                foreach ($sales->where('user_id',$user->id) as $sale) {
                                  $summa+=$sale->sale_history->sum('paid');
                                }
                            ?>
                            <td style='font-size:13px'>
                              <span class='text-primary font-weight-bold'>Общая сумма:{{number_format($sale_items->where('user_id',$user->id)->sum(function($t){return $t->price * $t->quantity;}))}} </span><br>
                              <span class='text-success font-weight-bold'>Выплаченная сумма:{{number_format($summa)}} </span>
                              <span class='text-danger font-weight-bold'>Общий расход:{{number_format($expendituries->where('user_id',$user->id)->sum('price'))}} </span><br>
                              <span class='text-danger font-weight-bold'>Сумма долга:
                                <?=($summa!=0) ? number_format($sale_items->where('user_id',$user->id)->sum(function($t){return $t->price * $t->quantity;})-$summa-$expendituries->where('user_id',$user->id)->sum('price')) : number_format($sale_items->where('user_id',$user->id)->sum(function($t){return $t->price * $t->quantity;})-$summa)?>
                              </span>
                            </td>
                          @endforeach
                        </tr>
                    </tbody>
                </table>
              </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
        $('select').selectize({
            sortField: 'text'
        });
        });
    </script>
@endpush