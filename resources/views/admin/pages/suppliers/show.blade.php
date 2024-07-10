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
          <div class="card" style="overflow: auto">
              <div class="card-header">
                <div class="container">
                  <div class="row justify-content-between align-items-center" >
                    <p class="col-12 p-0" style="font-size: 20px">Поставщик 
                    </p>
                    <table class="col-lg-8 col-sm-12 table-bordered " >
                      <tr>
                        <th class="font-weight-bolder p-2">ФИО</th>
                        <th class="p-2">{{$supplier->name}}</th>
                        <td class="font-weight-bolder p-2">Телефон	</td>
                        <td class="p-2">{{$supplier->phone}}</td>
                      </tr>
                      <tr>
                        <td class="font-weight-bolder p-2">Баланс</td>
                        <td class="p-2 w-100">{{number_format($supplier->transfers_to_supplier->sum('paid')-$supplier->coming_product->sum(function($t){return $t->price * $t->quantity;}))}} сум  &nbsp;
                          <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#paidSupplier"><i class="fa fa-money-check"></i>
                            Оплатить</button></td>
                        <td class="font-weight-bolder p-2">Информация	</td>
                        <td class="p-2">{{$supplier->comment}}</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div> 
  <!-- The Modal -->
  <div class="modal fade" id="paidSupplier">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Оплата
          </h4>
          <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
        </div>
        <div class="container mt-3 mb-3">
          <form action="{{route('suppliers.paid',$supplier->id)}}" method="POST">
            @csrf
            <div class="row">
              <div class="form-group col-6">
                <span>Сумма</span>
                <input type="number" name="summa" required class="form-control" value={{old('summa')}}>
              </div>
              <div class="form-group col-6">
                <label for="exampleFormControlSelect1">Метод оплаты</label>
                <select class="form-control" id="exampleFormControlSelect1" name="type">
                  <option selected hidden>Выберите тип оплаты</option>
                  <option value="nal">Наличные</option>
                  <option value="per">Перечисление</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <span>Комментария</span>
              <textarea name="comment" class="form-control" value={{old('comment')}}></textarea>
            </div> 
            <input type="date" name="created_at" id="datetime" name="datetime" value="{{date('Y-m-d')}}"><br><br>
            <button type="submit" class="btn btn-primary" id="save">Добавить</button>
          </form>
        </div>
  
      </div>
    </div>
  </div>
           
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <form action="{{route('suppliers.show',$supplier->id)}}" method="GET">
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
      <div class="card">
        <div class="card-body">
          <nav class="mb-3">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Поставки</button>
              <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Платежи</button>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <table class="table table-sm table-bordered table-striped table-hover bg-light bg-gradient" >
                  <thead>
                      <tr>
                          <th>
                            Название
                          </th>
                          <th>
                            Количество
                          </th>
                          <th>
                            Цена
                          </th>
                          <th>
                            Сумма
                          </th>
                          <th>
                            Дата
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($delivery as $deli)
                      <tr>
                        <td class="align-middle">
                            {{$deli->product->name}}
                        </td>
                        <td class="align-middle">
                            {{$deli->quantity}}
                        </td>
                        <td class="align-middle">
                            {{number_format($deli->price)}} сум
                        </td>
                        <td class="align-middle">
                            {{number_format($deli->price * $deli->quantity)}} сум
                        </td>
                        <td class="align-middle">
                            {{\Carbon\Carbon::parse($deli->created_at)->format('d M Y H:i:s')}}
                        </td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="10" class="text-center">
                              <h2>Нет поставок</h2>
                          </td>
                      @endforelse
                  </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <table class="table table-sm table-bordered table-striped table-hover bg-light bg-gradient" >
                  <thead>
                      <tr>
                          <th>
                              Сумма
                          </th>
                          <th>
                              Тип
                          </th>
                          <th>
                              Описание
                          </th>
                          <th>
                              Дата создания
                          </th>
                          <th>
                            Действия
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($payments as $payment)
                      <tr>
                        <td class="align-middle">
                            {{number_format($payment->paid)}} сум
                        </td>
                        <td class="align-middle">
                            <?=($payment->type == 'nal') ? 'Наличные' : 'Перечисление';?>
                        </td>
                        <td class="align-middle">
                            {{$payment->comment}}
                        </td>
                        <td class="align-middle">
                            {{\Carbon\Carbon::parse($payment->created_at)->format('d M Y H:i:s')}}
                        </td>
                        <td class="align-middle">
                          <form action="{{route('suppliers.payment.destroy',[$supplier->id,$payment->id])}}" method="post">
                            @csrf
                            <button class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></button>
                          </form>
                        </td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="10" class="text-center">
                              <h2>Нет оплаты</h2>
                          </td>
                      @endforelse
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  {{-- @livewire('show-supplier',['payments'=>$payments,'delivery'=>$delivery]) --}}
@endsection

