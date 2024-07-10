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
                    <h4> Продажи {{$user->username}}
                    </h4>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
  <form action="{{route('ha',$user->id)}}" method="GET">
    <div class="row">
      <div class="col-md-6 form-group">
          <input type="date" name="start_date" value="{{$start_date}}"  required class="form-control pr-2 pl-2" >
        </div>
        <div class="col-md-6 form-group">
          <input type="date" name="end_date" value="{{$end_date}}" required class="form-control pr-2 pl-2" >
        </div>
        <div class="col-md-2 form-group" >
          <input type="submit" class="btn btn-sm btn-primary" value="Фильтр">
        </div>
    </div>
  </form>
  <form action="{{route('history-admin-money')}}" method="POST" >
    @csrf
    <input type="hidden" name="user_id" value="{{$user->id}}">
    <div class="row d-none" id="block">
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
    <div class="row">
      <div class="col-sm-12">
          <div class="card">
              <div class="card-block" style="overflow: auto">
                <div class="row m-2">
                  <span class="border border-danger rounded font-weight-bold text-danger pr-2 pl-2 ml-2 mb-2">Не подтвержденные: {{number_format($sale_histories->sum('paid')-$user->expenditure->sum('price'))}} сум</span>
                </div>
                <div class="row m-2">
                  {{-- <span class="border border-info rounded font-weight-bold text-info pr-1 pl-1 ml-2 mb-2">Всего продано : {{number_format($user->sale->sum('total'))}} сум</span>
                  <span class="border border-primary rounded font-weight-bold text-primary pr-1 pl-1 ml-2 mb-2">Одобрено: {{number_format($payment_history->where('status',1)->sum('paid'))}} сум</span>
                  <span class="border border-success rounded font-weight-bold text-success pr-1 pl-1 ml-2 mb-2">Наличные: {{number_format($payment_history->where('status',1)->where('type',"nal")->sum('paid'))}} сум</span> --}}
                  <span class="border border-danger rounded font-weight-bold pr-1 pl-1 ml-2 mb-2"><a href="/expenditure/{{$user->id}}?start_date={{$start_date}}&end_date={{$end_date}}" class="text-danger">Расход: {{number_format($user->expenditure->sum('price'))}} сум</a></span>
                </div>
                <div class="row m-2">
                  <h5 class="col-12">Итого остаток:</h5>
                  <span class="border border-primary rounded font-weight-bold text-primary pr-1 pl-1 ml-2 mb-2">Наличные: <?=($payment_history->where('status',1)->where('type',"nal")->sum('paid')-$user->expenditure->sum('price') > 0) ? number_format($payment_history->where('status',1)->where('type',"nal")->sum('paid')-$user->expenditure->sum('price')) : 0;?> сум</span>
                </div>
                  <table class="table table-sm table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                              <input type="checkbox" class='form-check <?=($payment_history->sum('status')==count($payment_history))?'d-none':'';?>'  id="cc" onclick="javascript:checkAll(this,{{$payment_history->where('status','=',0)->sum('paid')}})"/>
                            </th>
                            <th class="align-middle">
                                Клиенты
                            </th>
                            <th class="align-middle">
                              Оплачено наличными
                            </th>
                            </th>
                            <th class="align-middle">
                              время
                            </th>
                            <th class="align-middle">
                              действ
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse ($sale_histories as $history)
                          <tr>
                            <td class="align-middle">
                              <?php
                                if($history->type=="nal"){
                                  echo "<input name='check[]' for='flexCheckDefault'  type='checkbox' value='$history->id' class='check form-check' onclick='javascript:check(this,$history->paid)'>";
                                }else{
                                  echo "<i class='fa fa-check'></i>";
                                }
                              ?>
                            </td>
                            {{-- <td>{{$history->sale->client->name}}</td> --}}
                            <td>{{number_format($history->paid)}} сум</td>
                            <td class="align-middle">
                              {{\Carbon\Carbon::parse($history->created_at)}}
                            </td>
                            <td class="align-middle">
                                <button type="button" class="btn btn-sm btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#UpdateBread<?php echo $history->id ?>">
                                  <i class="fa fa-eye"></i>
                                </button>
                  
                                <!-- The Modal -->
                                <div class="modal fade" id="UpdateBread<?php echo  $history->id ?>">
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
                                                          Возврад 
                                                        </th>
                                                        <th>
                                                          Цена товара
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($history->sale->sale_item as $s_item)
                                                    <tr>
                                                        <td class="align-middle">
                                                            {{ $s_item->bread->name}}
                                                        </td>
                                                        <td class="align-middle">
                                                          {{$s_item->quantity }}
                                                        </td>
                                                        <td class="align-middle">
                                                          {{$s_item->return_bread->sum('quantity') }}
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
                                            {{-- <span><span class="font-weight-bold">Итого:</span> {{number_format($history->sale->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $history->sale->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;}))}} сум</span> --}}
                                            
                                            <span>Итого : <b>{{number_format($history->sale->sale_item->sum(function($t){return $t->price * $t->quantity;}) )}} сум </b></span><br>
                                            <span>Сумма проданных товаров : <b>{{number_format($history->paid)}} сум</b></span><br>
                                            <span>Сумма возвращенного товара : <b>{{number_format($history->sale->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;}) )}} сум</b></span><br><br><br>
                                            <span class="float-right font-weight-bold">{{$history->sale->created_at->format('Y-m-d')}}</span>
                                          </div>
                                    </div>
                                  </div>
                                </div>
                            </td>
                          </tr>
                      @empty
                          
                      @endforelse
                        {{-- @forelse ($payment_history as $p_his)
                          <tr class="<?php echo ($p_his->status==1) ? "bg-primary bg-gradient text-light" : "";?>">
                            <td class="align-middle">
                              <?php
                                if($p_his->status==0){
                                  echo "<input name='check[]' for='flexCheckDefault'  type='checkbox' value='$p_his->id' class='check form-check' onclick='javascript:check(this,$p_his->paid)'>";
                                }else{
                                  echo "<i class='fa fa-check'></i>";
                                }
                              ?>
                            </td>
                            <td class="align-middle">
                              {{$p_his->client->name}}
                            </td>
                            <td class="align-middle">
                              {{number_format($p_his->paid)}} сум
                            </td>
                            <td class="align-middle">
                              {{\Carbon\Carbon::parse($p_his->created_at)->format('d M Y H:i:s')}}
                            </td>
                          </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">
                                <h2>Клиента нет</h2>
                            </td>
                        </tr>
                        @endforelse --}}
                    </tbody>
                  </table>
              </div>
              <span class="d-flex justify-content-end">{{$payment_history->links('pagination::bootstrap-4')}}</span>
          </div>
      </div>
    </div>
  </form>
@endsection

@push('js')

<script>
  
  var block =document.getElementById("block");
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