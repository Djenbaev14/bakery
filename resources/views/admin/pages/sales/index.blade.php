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
                  <h4>Страница продаж</h4>
                </div>
              </div>
            </div>
            <div class="card-block">
              <div class="row">
                <div class="col-12">
                  <form action="{{route('sales.create')}}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="card-block col-12">
                        <label for="">Покупатель:</label>
                        <select class="form-control client_id selectpicker"  data-show-subtext="true" data-live-search="true" name="client_id" required onchange="myFunction(this,{{$breads}},{{auth()->user()->role_id}})" placeholder="Выберите Покупателя" > 
                          <option hidden selected>Выберите клиента</option>
                          @foreach ($clients as $index=> $client)
                              <option value="{{$client}}" class="pt-2">{{$client->name}} |  {{number_format(client_balance($client->id))}}  сум</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="card-block col-lg-12">
                        <div style="overflow: auto">
                          <table class="table-bordered">
                              <thead>
                                  <tr class="border-bottom-0">
                                      <th>
                                        Товар
                                      </th>
                                      <th>
                                        Количество
                                      </th>
                                      <th>
                                        Цена (сум)
                                      </th>
                                      <th>
                                        Сумма (сум)
                                      </th>
                                  </tr>
                              </thead>
                              <tbody >
                                @forelse ($breads as $index=> $bread)
                                  <tr>
                                    <td><input type="text" class="border-0"  readonly value="{{$bread->name}}:({{$bread->quantity}})"></td>
                                    <input type="hidden" name="bread_id[]" class="bread_id" value="{{$bread->id}}">
                                    <td><input type="number"  class="w-100 border-0 quantity" name="quantity[]" <?=$bread->price ? "" : "readonly";?> min="1" max="{{$bread->quantity}}" ></td>
                                    <td><input type="text"  <?=(auth()->user()->role_id==3) ? "readonly" : "";?>  name="price[]"  
                                      class="border-0 price" value={{$bread->price}}></td>
                                    <td><input type="number" name="summa[]" id="summa" disabled class="w-100 border-0 summa" ></td>
                                    {{$bread->summa}}
                                  </tr>
                                  @empty
                                  <tr>
                                      <td colspan="10" class="text-center">
                                          <h3>Нет продуктов</h3>
                                      </td>
                                  </tr>
                                  @endforelse
                                  
                                  <tr>
                                    <td>
                                      <span>Итого:</span>
                                    </td>
                                    <td style="padding:1px 2px" colspan="2">
                                      <span id="total_count"></span>
                                    </td>
                                    <td>
                                      <input type="number" name="total_price" id="total_price"  readonly class="border-0" value="">
                                    </td>
                                  </tr>
                              </tbody>
                          </table>
                        </div>
                        <div class="mt-3">
                          <input type="date" name="created_at" id="datetime" name="datetime" value="{{date('Y-m-d')}}">
                          <br><br>
                          <button type="submit" class="btn btn-primary  rounded" id="save">Продать товар</button></div>
                        </div>
                      </div>
                      
                    </div>
                  </form>
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
            <div class="row">
              <div class="col-lg-12 col-sm-6">
                  {{-- <input type="text" class="form-control mt-2" wire:model='search' placeholder="Поиск клиентов"> --}}
                  <input type="text" class="form-control mt-2" id="searchInput" onkeyup="searchTable()" placeholder="Поиск" style="width: 100%">
              </div>
            </div>
          </div>
          <div class="card-block " style="overflow: auto">
            <table id="myTables" class="table table-sm table-bordered table-striped table-hover bg-light bg-gradient" >
                <thead>
                    <tr>
                        <th>
                          Добавил
                        </th>
                        <th>
                          Клент
                        </th>
                        <th>
                          Общая сумма
                        </th>
                        <th>
                          Оплаченная
                        </th>
                        {{-- <th>
                          Долг
                        </th> --}}
                        <th>
                          Время
                        </th>
                        <th>
                          Действия
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $sale)
                    <tr>
                      {{-- <td class="align-middle">
                           ($sales ->currentpage()-1) * $sales ->perpage() + $loop->index + 1 
                      </td> --}}
                        <td class="align-middle">
                          {{$sale->user->username}}
                        </td>
                        <td class="align-middle">
                          {{$sale->client->name}}
                        </td>
                        <td class="align-middle">
                          {{-- {{number_format($sale->total)}} сум --}}
                          {{number_format($sale->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $sale->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;}))}} сум
                          
                        </td>
                        <td class="align-middle">
                          {{number_format($sale->sale_history->sum('paid'))}} сум
                        </td>
                        {{-- <td class="align-middle">
                          @if ($sale->total-$sale->sale_history->sum('paid') != 0)
                            <span class="rounded text-danger border border-danger p-1">{{number_format($sale->total-$sale->sale_history->sum('paid'))}}  сум</span>
                          @else
                            <span class="rounded text-success border border-success p-1">Оплачено</span>
                          @endif
                        </td> --}}
                        <td class="align-middle">
                          {{\Carbon\Carbon::parse($sale->created_at)->format('d M Y H:i:s')}}
                        </td>
                        <td class="d-flex justify-content-around">
                          <form action="{{route('sales.destroy',$sale->id)}}" method="post" class="mr-2">
                            @csrf
                            <button class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></button>
                          </form>
                          <button type="button" class="btn btn-sm btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#UpdateBread<?php echo $sale->id ?>">
                            <i class="fa fa-eye"></i>
                          </button>
                          
                              <!-- The Modal -->
                              <div class="modal fade" id="UpdateBread<?php echo  $sale->id ?>">
                                <div class="modal-dialog">
                                  <div class="modal-content">
        
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">Продукты
                                      </h4>
                                    </div>
                                      
                                        <div class="card-block" style="overflow: auto">
                                          <table class="table table-bordered table-striped table-hover bg-light bg-gradient" >
                                              <thead>
                                                  <tr>
                                                      <th>
                                                        Продукта
                                                      </th>
                                                      <th>
                                                        Количество 
                                                      </th>
                                                      <th>
                                                        Цена товара
                                                      </th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  @forelse ($sale->sale_item as $s_item)
                                                  <tr>
                                                      <td class="align-middle">
                                                          {{ $s_item->bread->name}}
                                                      </td>
                                                      <td class="align-middle">
                                                        {{$s_item->quantity-$s_item->return_bread->sum('quantity') }}
                                                      </td>
                                                      <td class="align-middle">
                                                        {{number_format($s_item->price)}} сум
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
                                          <span><span class="font-weight-bold">Итого:</span> {{number_format($sale->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $sale->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;}))}} сум</span>
                                        </div>
                                    <div class="container mt-3 mb-3">
        
                                    </div>
        
                                  </div>
                                </div>
                              </div>
        
        
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
          </div>
        </div>
    </div>
</div>


@endsection

@push('css')
  
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
    <style>
      input::-webkit-calendar-picker-indicator{
          display: none;
      }

      input[type="date"]::-webkit-input-placeholder{ 
          visibility: hidden !important;
      }
    </style>
@endpush

@push('js')
  
<script>
  var price = document.getElementsByClassName("price");
  var quantity = document.getElementsByClassName("quantity");
  var bread_id = document.getElementsByClassName("bread_id");
  var summa = document.getElementsByClassName('summa');
  function myFunction(o,breads,role_id){
    var obj = JSON.parse(o.value);
    if(obj.kindergarden == 1){
        for (var i=0;i<bread_id.length;i++){
          for (let j = 0; j < breads.length; j++) {
            if(breads[j].id == bread_id[i].value){
              if(role_id == 3){
                price[i].value = breads[j].bread_delivery_price[0].kindergarden_price;
              }else{
                price[i].value = breads[j].kindergarden_price;
              }
          }
        }
      } 
    }else{
      for (var i=0;i<bread_id.length;i++){
        for (let j = 0; j < breads.length; j++) {
          if(breads[j].id == bread_id[i].value){
            price[i].value = breads[j].price;
          }
        }
      }
    }


    

    for (let i = 0; i < quantity.length; i++) {
    summa[i].value = quantity[i].value * price[i].value;
    
    var obsun = 0;
      for (let id = 0; id < summa.length; id++) {
        if(summa[id].value){
          obsun += parseInt(summa[id].value);
        }
      }
      document.getElementById("total_price").value=obsun;
    }
  }

  
  for (let i = 0; i < quantity.length; i++) {
    quantity[i].oninput = function() {
      summa[i].value = quantity[i].value * price[i].value;
      var obsun = 0;
      for (let id = 0; id < summa.length; id++) {
        if(summa[id].value){
          obsun += parseInt(summa[id].value);
        }
      }
      document.getElementById("total_price").value=obsun;

      var q = 0;
      for (let j = 0; j < quantity.length; j++) {
        if(quantity[j].value){
          q += parseInt(quantity[j].value);
        }
      }
      document.getElementById("total_count").innerHTML=q;

    };
    price[i].oninput = function() {
      summa[i].value = quantity[i].value * price[i].value;
      
      var obsun = 0;
      for (let id = 0; id < summa.length; id++) {
        if(summa[id].value){
          obsun += parseInt(summa[id].value);
        }
      }
      document.getElementById("total_price").value=obsun;
    };

  }

</script>

<script>
  $(document).ready(function () {
  $('.selectpicker').selectize({
      sortField: 'text'
  });
  });
</script>
<script>
  function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    // Har bir qatorni aylanib chiqish
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td");
      for (var j = 0; j < td.length; j++) {
        if (td[j]) {
          txtValue = td[j].textContent || td[j].innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
            break; // Agar mos keladigan ma'lumot topilsa, qolgan ustunlarni tekshirishni to'xtatadi
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
  }
</script>
@endpush
