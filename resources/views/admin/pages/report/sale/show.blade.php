@extends('admin.layouts.main')

@section('title', 'Trio System')

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
                <div class="card-block" style="overflow: auto">
                  <a href="/report-sale/?start_date={{session('start_date')}}&end_date={{session('end_date')}}&user_id={{session('user_id')}}" class="btn btn-sm btn-primary">Назад</a><br><br>
                  <table class="col-lg-12 col-sm-12 table-bordered " >
                    <tr>
                      <td class="font-weight-bolder pl-2 pr-2 ">Продавец</td>
                      <td class="pl-2 pr-2">{{$sale->user->username}}</td>
                      <td class="font-weight-bolder pl-2 pr-2 ">Клиент	</td>
                      <td class="pl-2 pr-2">{{$sale->client->name}} | {{number_format(client_balance($sale->client_id))}} сум</td>
                    </tr>
                    <tr>
                      <td class="font-weight-bolder pl-2 pr-2">Общая сумма</td>
                      <td class="pl-2 pr-2 ">{{number_format($sale->sale_item->sum(function($t){return $t->price * $t->quantity;}))}} сум</td>
                      <td class="font-weight-bolder pl-2 pr-2 ">Дата продажи	</td>
                      <td class="pl-2 pr-2">{{$sale->created_at->format('j.n.Y')}}</td>
                    </tr>
                  </table><br>
                  <div class="d-flex justify-content-between">
                    <div class="col-lg-6 col-12">
                      <table class="table-bordered w-100">
                        <thead>
                            <tr>
                                <th>
                                    Товар	
                                </th>
                                <th>
                                    Цена
                                </th>
                                <th>
                                    Количество
                                </th>
                                <th>
                                    Возврат
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sale->sale_item as $item)
                            <tr>
                                <td class="align-middle">
                                    {{$item->bread->name}}
                                </td>
                                <td class="align-middle">
                                  {{$item->price}} сум
                                </td>
                                <td class="align-middle">
                                  {{$item->quantity}}
                                </td>
                                <td class="align-middle">
                                  {{$item->return_bread->sum('quantity')}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h5>Товар нет</h5>
                                </td>
                            @endforelse
                            
                                      
                            <tr>
                              <td colspan="4">
                                <span class="font-weight-bold">Итого: </span> {{number_format($sale->sale_item->sum(function($t){return $t->price * $t->quantity;}))}} сум
                              </td>
                            </tr>      
                            <tr>
                              <td colspan="4">
                                <span class="font-weight-bold">Возвращенная сумма: </span> {{number_format($sale->return_bread->sum(function($t){return $t->price * $t->quantity;}))}} сум
                              </td>
                            </tr>
                              
                            <tr>
                              <td colspan="4">
                                <span class="font-weight-bold">Проданная сумма: </span> {{number_format($sale->sale_item->sum(function($t){return $t->price * $t->quantity;})-$sale->return_bread->sum(function($t){return $t->price * $t->quantity;}))}} сум
                              </td>
                            </tr>  
                            
                            <tr>
                              <td colspan="4">
                                <span class="font-weight-bold">Долга сумма: </span> {{number_format($sale->sale_item->sum(function($t){return $t->price * $t->quantity;})-$sale->return_bread->sum(function($t){return $t->price * $t->quantity;})
                                -$sale->sale_history->where('type','!=','nal')->sum('paid'))}} сум
                              </td>
                            </tr>  
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-12">
                    <table class="table-bordered w-100">
                      <thead>
                          <tr>
                              <th>
                                  Расход	
                              </th>
                              <th>
                                  Цена
                              </th>
                          </tr>
                      </thead>
                      <tbody>
                          @forelse ($expenditure as $exp)
                          <tr>
                              <td class="align-middle">
                                  {{$exp->expenditure_type->name}}
                              </td>
                              <td class="align-middle">
                                {{number_format($exp->price)}} сум
                              </td>
                          </tr>
                          @empty
                          <tr>
                              <td colspan="10" class="text-center">
                                  <h5>Расход нет</h5>
                              </td>
                          @endforelse
                          <tr>
                            <td>
                              <span class="font-weight-bold">Итого:</span>
                            </td>
                            <td>{{number_format($expenditure->sum('price'))}} сум</td>
                          </tr>
                      </tbody>
                  </table>
                    </div>
                  </div>
                </div>
                <form action="{{route('report-sale-money')}}" method="POST">
                  @csrf
                  <input type="hidden" name="sale_id" value="{{$sale->id}}">
                    <div class="card-block d-none" id="show_summa">
                      <div class="col-sm-6">
                          <div class="card">
                              <div class="card-header">
                                <div class="container">
                                  <div class="row justify-content-between align-items-center">
                                    <p class="col-12" style="font-size: 20px">Получение 
                                    </p>
                                    <div class="form-group col-12">
                                      <span>Общая сумма:</span>
                                      <input type="number" readonly name="total" id="total_price">
                                    </div> 
                                      <button type="submit" class="col-12 btn btn-sm btn-primary" <?=(auth()->user()->role_id==1) ? "" : "disabled";?> id="save">Сохранить</button> 
                                  </div>
                                </div>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="card-block">
                      <table class="table-sm col-6 table-bordered " style="overflow: auto">
                        <thead>
                            <tr>
                                <th>
                                  <input type="checkbox" class='form-check <?=($sale->sale_history->where('type','=','nal')->count() > 0)?'':'d-none';?>'  id="cc" onclick="javascript:checkAll(this,{{$sale->sale_history->where('type','=','nal')->sum('paid')}})"/>
                                </th>
                                <th>
                                    Оплачено
                                </th>
                                <th>
                                    Времия
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sale->sale_history as $history)
                            <tr class="<?php echo ($history->type=='nal1' || $history->type=='per') ? "bg-primary bg-gradient text-light" : "";?>">
                                <td class="align-middle">
                                  @if ($history->type=='nal')
                                    <input name='check[]' for='flexCheckDefault'  type='checkbox' value={{$history->id}} class='check form-check' onclick="javascript:check(this,{{$history->paid}})"/>
                                  @elseif($history->type=='nal1' || $history->type=='per')
                                    <i class='fa fa-check'></i>
                                  @endif
                                </td>
                                <td class="align-middle">
                                  {{number_format($history->paid)}} сум
                                </td>
                                <td class="align-middle">
                                  {{\Carbon\Carbon::parse($sale->created_at)->format('j.n.Y h:i:s')}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h5>Нет оплаты</h5>
                                </td>
                            @endforelse
                        </tbody>
                      </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
          var block =document.getElementById("show_summa");
          function checkAll(o,total) {
            let t=0;
            var boxes = document.getElementsByClassName("check");

            if(o.checked){
              console.log(block);
              block.classList.remove('d-none');
              t=total;
            }else{
              block.classList.add('d-none');
            }
            document.getElementById("total_price").value=t;
            for (var x = 0; x < boxes.length; x++) {
              var obj = boxes[x];
              if (obj.type == "checkbox") {
                if (obj.name != "check")
                  obj.checked = o.checked;
              }
            }
        }
        
          function check(e,total) {
            console.log(total);
            var j=0;
            var check =document.getElementsByClassName("check");
            var total_price=document.getElementById("total_price");
            var cc=document.getElementById("cc");

            if(e.checked){
              if(total_price.value){
                total_price.value=parseInt(total_price.value)+total;
              }else{
                total_price.value=total;
              }
            }else{
                total_price.value=parseInt(total_price.value)-total;
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
    </script>
@endpush