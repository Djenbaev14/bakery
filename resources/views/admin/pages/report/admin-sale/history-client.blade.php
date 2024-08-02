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
                    <h4>История {{$sale_histories[0]->sale->client->name}}
                    </h4>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-block" >
                <form action="{{route('history-admin-money')}}" method="POST" style="overflow: auto">
                  @csrf
                  <input type="hidden" name="user_id" value="{{$sale_histories[0]->sale->user->id}}">
                  <input type="submit" class="btn btn-primary <?=$sale_histories->sum('status')==count($sale_histories)?' d-none':'';?>" value='Получение'><br><br>
                  <table class="table table-sm table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                          <th>
                            <input type="checkbox" class='form-control-sm <?=$sale_histories->sum('status')==count($sale_histories)?' d-none':'';?>' id="cc" onclick="javascript:checkAll(this)"/>
                          </th>
                            <th class="align-middle">
                              Оплачено наличными
                            </th>
                            <th class="align-middle">
                              Тип
                            </th>
                            <th class="align-middle">
                              время
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse ($sale_histories as $sale_history)
                      <tr class="<?php echo ($sale_history->status==1) ? "bg-primary bg-gradient text-light" : "";?>">
                        <td class="align-middle">
                          <?php
                            if($sale_history->status==0){
                              echo "<input name='check[]' for='flexCheckDefault'  type='checkbox' value='$sale_history->id' class='form-control-sm'>";
                            }else{
                              echo "<i class='fa fa-check'></i>";
                            }
                          ?>
                        </td>
                        <td class="align-middle">
                          {{number_format($sale_history->paid)}} сум
                        </td>
                        <td class="align-middle">
                          <?=($sale_history->type=='nal')?'Наличка':'Перечисления';?>
                        </td>
                        <td class="align-middle">
                            {{\Carbon\Carbon::parse($sale_history->created_at)->format('d M Y H:i')}}
                        </td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="10" class="text-center">
                              <h2>Клиента нет</h2>
                          </td>
                      @endforelse
                    </tbody>
                  </table>
                </form>
                <div class="row m-1">
                  <span class="border border-primary text-primary font-weight-bold  rounded p-1 pr-2 pl-2  mr-4 mb-2">Итого: {{number_format($sale_histories[0]->sale->total)}} сум</span>
                  <span class="border border-success text-success font-weight-bold  rounded p-1 pr-2 pl-2  mr-4 mb-2">Получено наличными: {{number_format($sale_histories->where('type','nal')->where('status',1)->sum('paid'))}} сум</span>
                  <span class="border border-info text-info font-weight-bold  rounded p-1 pr-2 pl-2  mr-4 mb-2">Получено с помощью терминала: {{number_format($sale_histories->where('type','per')->where('status',1)->sum('paid'))}} сум</span>
                </div>
                </div>
            </div>
        
        </div>
    </div>
</div>
@endsection


<script>
  function checkAll(o) {
  var boxes = document.getElementsByTagName("input");
  for (var x = 0; x < boxes.length; x++) {
    var obj = boxes[x];
    if (obj.type == "checkbox") {
      if (obj.name != "check")
        obj.checked = o.checked;
    }
  }
}
</script>