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
                      <div class="form-group col-12">
                        <span>Покупатель</span> 
                        <select class="form-control client_id"  name="client_id" required onchange="myFunction(this,{{$breads}})">
                          <option hidden selected class="bg-secondary bg-gradient text-light">Выберите Покупателя</option>
                          @foreach ($clients as $index=> $client)
                              <option value="{{$client}}" class="pt-2">{{$client->name}} | {{number_format($client->payment_history->sum('paid')-$client->sale->sum('total'))}} сум</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group col-lg-12 col-sm-12">
                        <div class="card-block" style="overflow: auto">
                          <table class="table-bordered" width="100%">
                              <thead>
                                  <tr class="border-bottom-0 ">
                                      <th >
                                        Товар
                                      </th>
                                      <th>
                                        Цена (сум)
                                      </th>
                                      <th>
                                        Количество
                                      </th>
                                      <th>
                                        Сумма (сум)
                                      </th>
                                  </tr>
                              </thead>
                              <tbody >
                                @forelse ($breads as $index=> $bread)
                                      <tr>
                                        <td ><input type="text"  class="border-0 " readonly value="{{$bread->name}}:({{$bread->quantity}})"></td>
                                        <input type="hidden" name="bread_id[]" class="bread_id" value="{{$bread->id}}">
                                        <td><input type="text"  <?=(auth()->user()->role_id==3) ? "readonly" : "";?>  name="price[]"  
                                          class="border-0 price" value={{$bread->price}}></td>
                                        <td><input type="number"  class="w-100 border-0 quantity" name="quantity[]" min="1" max="{{$bread->quantity}}" ></td>
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
                                    <th colspan="2">
                                      <span>Итого:</span>
                                    </th>
                                    <th>
                                      <span id="total_count"></span>
                                    </th>
                                    <th>
                                      <input type="number" name="total_price" id="total_price"  readonly class="border-0" value="">
                                      
                                    </th>
                                </tr>
                              </tbody>
                          </table>
                        </div>
                      </div>
                      
                      <button type="submit" class="btn btn-primary mt-5 rounded" id="save">Продать товар</button></div>
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
        </div>
    </div>
</div>


@endsection


@push('js')
  <script>
    var price = document.getElementsByClassName("price");
    var quantity = document.getElementsByClassName("quantity");
    var bread_id = document.getElementsByClassName("bread_id");
    var summa = document.getElementsByClassName('summa');
    function myFunction(o,breads){

      var obj = JSON.parse(o.value);


      if(obj.kindergarden == 1){
        for (var i=0;i<bread_id.length;i++){
          for (let j = 0; j < breads.length; j++) {
            if(breads[j].id == bread_id[i].value){
              price[i].value = breads[j].kindergarden_price;
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
@endpush
