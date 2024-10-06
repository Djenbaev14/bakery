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
                  <h4>Страница продаж</h4>
                </div>
              </div>
            </div>
            <div class="card-block">
              <div class="row">
                <div class="col-12">
                  <div class="card-block">
                    <div class="row">
                      <div class="col-12">
                        <form action="{{route('sales.create')}}" method="POST">
                            @csrf
                            <div class="row">
                              <div class="form-group col-12">
                                <span>Покупатель</span>
                                <select class="form-control selectpicker" name="client_id" id="client_id"  required onchange="onchangeClient(this,{{$breads}},{{auth()->user()->role_id}})"> 
                                  <option hidden class="bg-secondary bg-gradient text-light">Выберите Покупателя</option>
                                  @foreach ($clients as $client)
                                      <option value="{{$client}}">{{$client->name}} | {{number_format(client_balance($client->id))}} сум</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group col-12">
                                <span>Товар</span>
                                <select class="form-control selectpicker" name="bread_id" id="bread_id" onchange="onchangeBread(this.value,{{$breads}},{{auth()->user()->role_id}})">
                                  <option hidden class="bg-secondary bg-gradient text-light" selected>Выберите товар</option>
                                  @forelse ($breads as $bread) 
                                    <option value="{{$bread->id}}" >{{$bread->name}} ({{$bread->quantity}}) штук</option>
                                  @empty
                                    <option class="bg-secondary bg-gradient text-light">Нет товаров</option>
                                  @endforelse
                                </select>
                              </div>
                              <div class="form-group  col-12">
                                <span>Количество</span>
                                <input type="number" class="form-control pl-2" name="quantity"  id="quantity">
                              </div>
                              <div class="form-group col-12">
                                <span>Цена</span>
                                <input type="text" class="form-control pl-2" id="price" <?=(auth()->user()->role_id==3) ? "readonly" : "";?> name="price" >
                              </div><br>
                              {{-- <div class="form-group col-12">
                                <input type="date" name="created_at" id="datetime" name="datetime" value="{{date('Y-m-d')}}">
                              </div> --}}
                              <div class="row justify-content-around  col-12">
                                  <div class="custom-control custom-switch mt-3">
                                      <label for="">Перечисления</label><br>
                                      <input type="checkbox" class="custom-control-input" id="customTransfers">
                                      <label class="custom-control-label" for="customTransfers"></label>
                                      <input type="number"  name="transfers" id="transfers" min="0" readonly value="0" data-type='cur'>
                                  </div>
                                  <div class="custom-control custom-switch mt-3">
                                      <label for="">Наличка</label><br>
                                      <input type="checkbox" class="custom-control-input" id="customCash">
                                      <label class="custom-control-label" for="customCash"></label>
                                      <input type="number" name="cash" readonly min="0" value="0" id="cash"  data-type="currency" >
                                  </div>
                              </div>
                              <div class="col-12 row justify-content-between mt-5 ">
                                  <div class="input-group input-group-sm  mb-3 col-lg-5">
                                      <div class="input-group-prepend">
                                      <span class="input-group-text" id="inputGroup-sizing-sm">Общая сумма:</span>
                                      </div>
                                      <input type="text" readonly class="form-control" name="total_price" id="total_price" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                      <div class="input-group-prepend">
                                      <span class="input-group-text" id="inputGroup-sizing-sm"> сум</span>
                                      </div>
                                  </div>
                                  <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary btn-sm rounded" id="save">Продать товар</button>
                                  </div>
                              </div>
                              <p id="demo"></p>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card p-3">
          @livewire('search-sales')
          {{-- <livewire:search-sales/> --}}
        </div>
    </div>
</div>


@endsection

@push('js')
  
<script>
  var price = document.getElementById("price");
  var quantity = document.getElementById("quantity");
  var bread_id = document.getElementById("bread_id");
  var client_id = document.getElementById("client_id");
  var summa = document.getElementsByClassName('summa');
  function onchangeClient(o,breads,role_id){
    var obj = JSON.parse(o.value);
    if(obj.kindergarden == 1){
          for (let j = 0; j < breads.length; j++) {
            if(breads[j].id == bread_id.value){
              price.value = breads[j].kindergarden_price;
          }
      } 
    }else{
        for (let j = 0; j < breads.length; j++) {
          if(breads[j].id == bread_id.value){
            price.value = breads[j].price;
          }
        }
    }

    document.getElementById("total_price").value=parseInt(quantity.value * price.value); 
  }

  function onchangeBread(bread_id,breads,role_id){
    var obj = JSON.parse(client_id.value);
    if(obj.kindergarden == 1){
          for (let j = 0; j < breads.length; j++) {
            if(breads[j].id == bread_id){
              price.value = breads[j].kindergarden_price;
              quantity.max = breads[j].quantity
          }
      }
      
    }else{
        for (let j = 0; j < breads.length; j++) {
          if(breads[j].id == bread_id){
            price.value = breads[j].price;
            quantity.max = breads[j].quantity
          }
        }
        
    }

    if(price.value==0){
      quantity.readOnly=true;
    } else{
      quantity.readOnly=false;
    }


    document.getElementById("total_price").value=parseInt(quantity.value * price.value); 
  }

  
    quantity.oninput = function() {
        document.getElementById("total_price").value=parseInt(quantity.value * price.value);
    };
    price.oninput = function() {
      document.getElementById("total_price").value=parseInt(quantity.value * price.value);
    };

  
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

<script>
  $('#customTransfers').click(function() {
    if($(this).is(':checked'))
      $("#transfers").prop("readonly", false);
    else if(!$(this).is(':checked'))
      $("#transfers").prop("readonly", true);
  });

  $('#customCash').click(function() {
    if($(this).is(':checked'))
      $("#cash").prop("readonly", false);
    else if(!$(this).is(':checked'))
      $("#cash").prop("readonly", true);
  });

  
</script>

@endpush
