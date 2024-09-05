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
                  <h4>Долг</h4>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            {{-- @livewire('debt-filter') --}}
          <div class="card-block">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Основной</button>
                <button class="nav-link " id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Перечисления</button>
              </div>
            </nav>
          </div>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <div class="card-block">
                <form action="{{route('debts.index')}}" method="get">
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <input type="date" name="start_date" required class="form-control pl-2 pr-2" value="{{ $start_date }}">
                    </div>
                    <div class="col-md-6 form-group">
                      <input type="date" name="end_date" required class="form-control pl-2 pr-2" value="{{ $end_date }}">
                    </div>
                      <div class="col-sm-4 col-lg-4">
                          <input type="text" class="form-control" name="search" value="{{old('search')}}" placeholder="Поиск клиентов">
                      </div>
                      <div class="col-sm-4 col-lg-4">
                        <input type="submit" class="btn btn-primary" value="Search">
                      </div>
                  </div>
                </form>
              </div>
              <div class="card-block">
                <form action="{{route('payment')}}" method="POST">
                  @csrf
                  <div class="row d-none" id="block">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                              <div class="container">
                                <div class="row justify-content-between align-items-center">
                                  <p class="col-12" style="font-size: 20px">Оплата 
                                  </p>
                                  <div class="form-group col-12">
                                    <span>Общая сумма:</span>
                                    <input type="number" readonly name="total" id="total_price">
                                  </div> 
                                    <div class="form-group col-12">
                                      <span>Сумма платежа:</span>
                                      <input type="number" style="width: 180px" min="0" name="paid" id="paid">
                                    </div>
                                    <div class="form-group col-12">
                                      <span>Тип оплата:</span> 
                                      <select class="form-select" name="type" required>
                                        <option class="bg-secondary bg-gradient text-light">Выберите</option>
                                        <option class="bg-secondary bg-gradient text-light" value="per">Перечисления</option>
                                        <option class="bg-secondary bg-gradient text-light" value="nal">Наличка</option>
                                      </select>
                                    </div>
                                    <button type="submit" class="col-12 btn btn-sm btn-primary" id="save">Сохранить</button> 
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>
              <div class="card-block" style="overflow: auto">
                <table id="myTable" class="table-sm table-bordered table-striped table-hover bg-light bg-gradient" style="width: 100%;min-width:100%;table-layout:auto;">
                  <thead>
                      <tr>
                          <th>
                            <input type="checkbox" class='form-control-sm <?=($main_total_debt==0 && count($main_sales)>=0) ? 'd-none' : 'd-block';?>' id="cc" onclick="javascript:checkAll(this,{{$main_total_debt}})"/>
                          </th>
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
                      @forelse ($main_sales as $sale)
                      <tr>
                          <td class="align-middle">
                            @if ($sale->sale_history->sum('paid') >= $sale->quantity*$sale->price)
                              <i class='fa fa-check text-primary'></i>
                              @else
                              <input name='check[]' class='check' for='flexCheckDefault'  type='checkbox' value={{$sale->id}} class='form-control-sm' onclick='javascript:check(this,{{one_paid($sale)}})'>
                            @endif
                          </td>
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
                            <span class="text-danger border border-danger p-1 rounded">{{($sale->price * $sale->quantity-$sale->sale_history->sum('paid') > 0)? number_format($sale->price * $sale->quantity-$sale->sale_history->sum('paid')) :  0;}} сум</span>
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
                              <h4>Продажи нет</h4>
                          </td>
                      @endforelse
                  </tbody>
                </table>
              </form>
              </div>
                <div class="row m-1 ml-3">
                  <span class="border border-primary rounded font-weight-bold text-primary pr-1 pl-1 ml-2 mb-2">Итого : {{number_format($main_total_debt)}} </span>
                  <span class="border border-info rounded font-weight-bold text-info pr-1 pl-1 ml-2 mb-2">Итого количество: {{number_format($main_sales->sum('quantity')-$total_paid)}}</span>
                </div>
                {{-- <span class="d-flex justify-content-end">{{$main_sales->links('pagination::bootstrap-4')}}</span> --}}
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <div class="card-block">
                <form action="{{route('debts.index')}}" method="get">
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <input type="date" name="start_date" required class="form-control pl-2 pr-2" value="{{ $start_date }}">
                    </div>
                    <div class="col-md-6 form-group">
                      <input type="date" name="end_date" required class="form-control pl-2 pr-2" value="{{ $end_date }}">
                    </div>
                      <div class="col-sm-4 col-lg-4">
                          <input type="text" class="form-control" name="search_kinder" value="{{old('search_kinder')}}" placeholder="Поиск клиентов">
                      </div>
                      <div class="col-sm-4 col-lg-4">
                        <input type="submit" class="btn btn-primary" value="Search">
                      </div>
                  </div>
                </form>
              </div>
              <div class="card-block">
                <form action="{{route('payment')}}" method="post">
                  @csrf
                  <div class="row d-none" id="kinderBlock">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                              <div class="container">
                                <div class="row justify-content-between align-items-center">
                                  <p class="col-12" style="font-size: 20px">Оплата 
                                  </p>
                                  <div class="form-group col-12">
                                    <span>Общая сумма:</span>
                                    <input type="number" readonly name="total" id="kinder_total_price">
                                  </div> 
                                    <div class="form-group col-12">
                                      <span>Сумма платежа:</span>
                                      <input type="number" style="width: 180px" min="0" name="paid" id="kinder_paid">
                                    </div>
                                    <div class="form-group col-12">
                                      <span>Тип оплата:</span> 
                                      <select class="form-select" name="type" required>
                                        <option class="bg-secondary bg-gradient text-light">Выберите</option>
                                        <option class="bg-secondary bg-gradient text-light" value="per">Перечисления</option>
                                        <option class="bg-secondary bg-gradient text-light" value="nal">Наличка</option>
                                      </select>
                                    </div>
                                    <button type="submit" class="col-12 btn btn-sm btn-primary" id="save">Сохранить</button> 
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>
              <div class="card-block" style="overflow: auto">
                <table id="myTable" class="table-sm table-bordered table-striped table-hover bg-light bg-gradient" style="width: 100%;min-width:100%; table-layout:auto;">
                  <thead>
                      <tr>
                          <th>
                            <input type="checkbox" class='form-control-sm <?=($kindergarten_total_debt==0 && count($kindergarten_sales)>=0) ? 'd-none' : 'd-block';?>' id="kindergartenCheckAll" onclick="javascript:kinderCheckAll(this,{{$kindergarten_total_debt}})"/>
                          </th>
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
                      @forelse ($kindergarten_sales as $sale)
                      <tr>
                        <td class="align-middle">
                          @if ($sale->sale_history->sum('paid') >= $sale->quantity*$sale->price)
                            <i class='fa fa-check text-primary'></i>
                            @else
                            <input name='check[]' class='kinder_check' for='flexCheckDefault'  type='checkbox' value={{$sale->id}} class='form-control-sm' onclick='kinderCheck(this,{{one_paid($sale)}})'>
                          @endif
                        </td>
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
                            <span class="text-danger border border-danger p-1 rounded">{{($sale->price * $sale->quantity-$sale->sale_history->sum('paid') > 0)? number_format($sale->price * $sale->quantity-$sale->sale_history->sum('paid')) :  0;}} сум</span>
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
                              <h4>Продажи нет</h4>
                          </td>
                      @endforelse
                  </tbody>
                </table>
              </form>
            </div>
            <div class="row m-1 ml-3">
              <span class="border border-primary rounded font-weight-bold text-primary pr-1 pl-1 ml-2  mb-2">Итого : {{number_format($kindergarten_total_debt)}} </span>
              <span class="border border-info rounded font-weight-bold text-info pr-1 pl-1 ml-2 mb-2">Итого количество: {{number_format($kindergarten_sales->sum('quantity')-$total_paid)}}</span>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
      .act {
        background: #111;
      }
    </style>
@endpush


@push('js')
    <script>
      
      $('#cusTransfers').click(function() {
          if($(this).is(':checked'))
            $("#tran").prop("readonly", false);
          else if(!$(this).is(':checked'))
            $("#tran").prop("readonly", true);
        });
    
        $('#cusCash').click(function() {
          if($(this).is(':checked'))
            $("#ca").prop("readonly", false);
          else if(!$(this).is(':checked'))
            $("#ca").prop("readonly", true);
        });
        
        
        $('#sadik_cusTransfers').click(function() {
          if($(this).is(':checked'))
            $("#sadik_tran").prop("readonly", false);
          else if(!$(this).is(':checked'))
            $("#sadik_tran").prop("readonly", true);
        });
    
        $('#sadik_cusCash').click(function() {
          if($(this).is(':checked'))
            $("#sadik_ca").prop("readonly", false);
          else if(!$(this).is(':checked'))
            $("#sadik_ca").prop("readonly", true);
        });

        
        function getClient(id,debt) {
          $('#sale_id').val(id);
          $('#de').val(debt);
        }
        
        function sadik_getClient(id,debt) {
          $('#sadik_sale_id').val(id);
          $('#sadik_de').val(debt);
        }
    </script>
    
    <script>
      
        var block =document.getElementById("block");
        var total_price=document.getElementById("total_price");
        var paid=document.getElementById("paid");

        function checkAll(o,total) {
          var boxes = document.getElementsByClassName("check");
          var k=0;

          for (var x = 0; x < boxes.length; x++) {
          var obj = boxes[x];
          if (obj.type == "checkbox") {
            if (obj.name != "check")
              obj.checked = o.checked;
          }
          }

          for (let i = 0; i < boxes.length; i++) {
            if(boxes[i].checked){
              k+=1;
            }
          }
          if(o.checked){
            block.classList.remove('d-none');
            total_price.value=total;
            if(k<=1){
              paid.min=0;
              paid.max=total_price.value;
              paid.value=0;
            }else{
              paid.value=total_price.value;
              paid.readOnly=true;
            }
          }else{
            block.classList.add('d-none');
            total_price.value=0;
            paid.value=0;
            paid.readOnly=false;
          }

        }


        function check(e,total) {
          var check =document.getElementsByClassName("check");
          var cc=document.getElementById("cc");
          var j=0;
          var k=0;

          for (let i = 0; i < check.length; i++) {
            if(check[i].checked){
              k+=1;
            }
          }

          if(e.checked){
            if(total_price.value){
              total_price.value=parseInt(total_price.value)+total;
            }else{
              total_price.value=total;
            }
          }else{
              cc.checked=false;
              total_price.value=parseInt(total_price.value)-total;
          }
          console.log(k);
        
          if(k<=1){
            paid.min=0;
            paid.max=total_price.value;
            paid.value=0;
            paid.readOnly=false;
          }else{
            paid.value=total_price.value;
            paid.readOnly=true;
          }
        
          for (let i = 0; i < check.length; i++) {
              j+=check[i].checked == true ? 1 : 0;
          }
          if(j>0){
            block.classList.remove('d-none');
          }else{
            cc.checked=false;
            block.classList.add('d-none');
          }
        }
        
        var kinderBlock =document.getElementById("kinderBlock");
        var kinder_total_price=document.getElementById("kinder_total_price");
        var kinder_paid=document.getElementById("kinder_paid");

        function kinderCheckAll(o,total) {
          var boxes = document.getElementsByClassName("kinder_check");
          var k=0;

          for (var x = 0; x < boxes.length; x++) {
          var obj = boxes[x];
          if (obj.type == "checkbox") {
            if (obj.name != "check")
              obj.checked = o.checked;
          }
          }

          for (let i = 0; i < boxes.length; i++) {
            if(boxes[i].checked){
              k+=1;
            }
          }
          if(o.checked){
            kinderBlock.classList.remove('d-none');
            kinder_total_price.value=total;
            if(k<=1){
              kinder_paid.min=0;
              kinder_paid.max=kinder_total_price.value;
              kinder_paid.value=0;
            }else{
              kinder_paid.value=kinder_total_price.value;
              kinder_paid.readOnly=true;
            }
          }else{
            kinderBlock.classList.add('d-none');
            kinder_total_price.value=0;
            kinder_paid.value=0;
            kinder_paid.readOnly=false;
          }

        }


        function kinderCheck(e,total) {
          var check =document.getElementsByClassName("kinder_check");
          var cc=document.getElementById("kindergartenCheckAll");
          var j=0;
          var k=0;

          for (let i = 0; i < check.length; i++) {
            if(check[i].checked){
              k+=1;
            }
          }

          if(e.checked){
            if(kinder_total_price.value){
              kinder_total_price.value=parseInt(kinder_total_price.value)+total;
            }else{
              kinder_total_price.value=total;
            }
          }else{
              cc.checked=false;
              kinder_total_price.value=parseInt(kinder_total_price.value)-total;
          }
          console.log(k);
        
          if(k<=1){
            kinder_paid.min=0;
            kinder_paid.max=kinder_total_price.value;
            kinder_paid.value=0;
            kinder_paid.readOnly=false;
          }else{
            kinder_paid.value=kinder_total_price.value;
            kinder_paid.readOnly=true;
          }
        
          for (let i = 0; i < check.length; i++) {
              j+=check[i].checked == true ? 1 : 0;
          }
          if(j>0){
            kinderBlock.classList.remove('d-none');
          }else{
            cc.checked=false;
            kinderBlock.classList.add('d-none');
          }
        }
    </script>
@endpush
