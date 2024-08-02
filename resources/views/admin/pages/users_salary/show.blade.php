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
                  <h4>История заработной платы {{$user->username}}
                  </h4>
                </div>
              </div>
            </div>
            <div class="card-block">
              <form action="{{route('users_salary.show',$user->id)}}" method="GET">
                <div class="row">
                  <div class="col-md-6 form-group">
                      <input type="date" name="start_date" value="{{$start_date}}"  required class="form-control" >
                    </div>
                    <div class="col-md-6 form-group">
                      <input type="date" name="end_date" value="{{$end_date}}" required class="form-control" >
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
            <h5>Приход</h5>
              <table class="table table-sm table-bordered table-striped table-hover mt-4">
                  <thead>
                      <tr>
                          <th>
                            №
                          </th>
                          <th>
                            проданные товары
                          </th>
                          <th>
                            Цена
                          </th>
                          <th>
                            Время
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($user_salary as $user)
                      <tr>
                          <td class="align-middle">
                              {{ ($user_salary ->currentpage()-1) * $user_salary ->perpage() + $loop->index + 1 }}
                          </td>
                          <td class="align-middle">
                            @foreach ($user->sale->sale_item as $s_item)
                                {{$s_item->bread->name}}({{$s_item->quantity-$s_item->return_bread->sum('quantity')}} штук),
                                {{$s_item->refund_bread}}
                            @endforeach
                          </td>
                          <td class="align-middle">
                            {{number_format($user->summa,2)}} сум
                          </td>
                          <td class="align-middle">
                            {{\Carbon\Carbon::parse($user->created_at)->format('d M Y H:i:s')}}
                          </td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="10" class="text-center">
                              <h2>Приход нет</h2>
                          </td>
                      @endforelse
                  </tbody>
              </table>
              <div class="row m-1">
                  <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Общая итог: {{number_format($user_salary->sum('summa'))}} сум</span>
              </div>
              <span class="d-flex justify-content-end">{{$user_salary->links('pagination::bootstrap-4')}}</span>
          </div>
      
      </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
      <div class="card">
          <div class="card-block" style="overflow: auto">
            <h5>Расход</h5>
              <table class="table table-sm table-bordered table-striped table-hover mt-4">
                  <thead>
                      <tr>
                          <th>
                            №
                          </th>
                          <th>
                            название расход
                          </th>
                          <th>
                              Комментария
                          </th>
                          <th>
                            Цена
                          </th>
                          <th>
                            Время
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($expenditure as $expen)
                      <tr>
                          <td class="align-middle">
                              {{ ($expenditure ->currentpage()-1) * $expenditure ->perpage() + $loop->index + 1 }}
                          </td>
                          <td class="align-middle">
                            {{$expen->expenditure_type->name}}
                          </td>
                          <td class="align-middle">
                            {{$expen->comment}}
                          </td>
                          <td class="align-middle">
                            {{number_format($expen->price)}} сум
                          </td>
                          <td class="align-middle">
                            {{\Carbon\Carbon::parse($expen->created_at)->format('d M Y H:i:s')}}
                          </td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="10" class="text-center">
                              <h2>Расход нет</h2>
                          </td>
                      @endforelse
                  </tbody>
              </table>
              <div class="row m-1">
                  <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Общая итог: {{number_format($expenditure->sum('price'))}} сум</span>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection


@push('js')
@endpush

