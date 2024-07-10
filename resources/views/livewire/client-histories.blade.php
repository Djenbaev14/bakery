<div>

    <div class="card-block">
        <div class="row mb-4">
            <div class="col-12 buttons">
                <button type="button" class="{{ $active1 }} main btn1 btn btn-light text-dark" wire:click="main()"><i class="fa fa-shopping-card"></i> Заказы</button>
    
                <button type="button" class="{{ $active2 }} kindergarden btn1 btn btn-light text-dark"  wire:click="kindergarden()"><i class="fa fas-money"></i> Оплата
                    история</button>
            </div>
        </div>
      </div> 
      <div class="{{$ac1}}">
          <form action="{{route('pay_client')}}" method="post">
            @csrf
            <input type="hidden" name="client_id" value="{{$client->id}}">
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
                                <span>Сумма долга:</span>
                                <input type="number" style="width: 180px" min="0" name="debt" id="debt">
                              </div>
                              <div class="form-group col-12">
                                <span>Тип оплата:</span> 
                                <select class="form-select" name="type" required>
                                  <option class="bg-secondary bg-gradient text-light">Выберите</option>
                                  <option class="bg-secondary bg-gradient text-light" value="per">Перечисления</option>
                                  <option class="bg-secondary bg-gradient text-light" value="nal">Наличка</option>
                                </select>
                              </div>
                              <div class="form-group col-12">
                                <input type="date" name="created_at" id="datetime" name="datetime" value="{{date('Y-m-d')}}">
                              </div>
                              <button type="submit" class="col-12 btn btn-sm btn-primary" id="save" <?=(auth()->user()->id == $client->user->id) || $client->kindergarden==1 ? "" : "disabled";?>>Сохранить</button> 
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
                      <table class="table table-sm table-bordered table-striped table-hover bg-light bg-gradient" >
                          <thead>
                              <tr>
                                <th>
                                  <input type="checkbox" class='form-control-sm <?=($debt==0 && count($sale)>=0) ? 'd-none' : 'd-block';?>' id="cc" onclick="javascript:checkAll(this,{{$debt}})"/>
                                </th>
                                  <th>
                                    Общая сумма
                                  </th>
                                  <th>
                                    Долг сумма
                                  </th>
                                  <th>
                                    Добавил
                                  </th>
                                  <th>
                                    Время
                                  </th>
                                  <th>
                                    Действия
                                  </th>
                                  <th>
                                    Возврат
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                              @forelse ($sale as $s)
                              <?php
                                $total_p=$s->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $s->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;})-$s->sale_history->sum('paid');
                              ?>
                              <tr class="<?=($s->sale_history->sum('paid')) >= $s->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $s->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;}) ? "bg-primary bg-gradient text-light" : "";?>">
                                <td class="align-middle">
                                  <?=($s->sale_history->sum('paid')) >= $s->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $s->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;}) ? "<i class='fa fa-check'></i>" : "<input name='check[]' class='check' for='flexCheckDefault'  type='checkbox' value=$s->id class='form-control-sm' onclick='javascript:check(this,$total_p)'>";?>
                                </td>
                                <td class="align-middle">
                                  {{number_format($s->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $s->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;}))}} сум
                                </td>
                                <td class="align-middle">
                                  {{number_format($s->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $s->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;}) -$s->sale_history->sum('paid'))}} сум
                                </td>
                                <td class="align-middle">
                                  {{ $s->user->username}}
                                </td>
                                <td class="align-middle">
                                    {{\Carbon\Carbon::parse($s->created_at)->format('d M Y H:i:s')}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-light border " style="width: 100%" data-bs-toggle="modal" data-bs-target="#UpdateBread<?php echo $s->id ?>">
                                      <i class="fa fa-eye text-primary"></i>
                                    </button>
                                    
                                        <!-- The Modal -->
                                        <div class="modal fade" id="UpdateBread<?php echo  $s->id ?>">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                  
                                              <!-- Modal Header -->
                                              <div class="modal-header">
                                                <h4 class="modal-title">Продукты
                                                </h4>
                                              </div>
                                                
                                                  <div class="card-block" style="overflow: auto">
                                                    <table class="table table-sm table-bordered table-striped table-hover bg-light bg-gradient" >
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                  Продукта
                                                                </th>
                                                                <th>
                                                                  Цена товара
                                                                </th>
                                                                <th>
                                                                  Количество
                                                                </th>
                                                                <th>
                                                                  Возврад
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($s->sale_item as $s_item)
                                                            <tr>
                                                                <td class="align-middle">
                                                                    {{ $s_item->bread->name}}
                                                                </td>
                                                                <td class="align-middle">
                                                                  {{number_format($s_item->price)}} сум
                                                                </td>
                                                                <td class="align-middle">
                                                                  {{$s_item->quantity}}
                                                                </td>
                                                                <td class="align-middle">
                                                                  {{$s_item->return_bread->sum('quantity') }}
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
                                                    <div class="container mt-3 mb-3 text-dark">
                                                      <span>Итого : <b>{{number_format($s->sale_item->sum(function($t){return $t->price * $t->quantity;}) )}} сум </b></span><br>
                                                      <span>Сумма проданных товаров : <b>{{number_format($s->sale_item->sum(function($t){return $t->price * $t->quantity;})-$s->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;}) )}} сум</b></span><br>
                                                      <span>Сумма возвращенного товара : <b>{{number_format($s->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;}) )}} сум</b></span><br>
                                                    </div>
                                                  </div>
                  
                                            </div>
                                          </div>
                                        </div>
                  
                                </td>
                              </form>
                                <td>
                                    <button type="button" class="btn btn-sm btn-light border" <?=($s->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $s->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;})==$s->sale_history->sum('paid') && count($sale)>=0) ? 'disabled' : '';?> style="width: 100%" data-bs-toggle="modal" data-bs-target="#returnBread<?php echo $s->id ?>">
                                      <i class="fa fa-arrow-left text-primary"></i>
                                    </button>

                                    
                                        <!-- The Modal -->
                                        <div class="modal fade" id="returnBread<?php echo  $s->id ?>">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                  
                                              <!-- Modal Header -->
                                              <div class="modal-header">
                                                <h5 class="modal-title">Возврат
                                                </h5>
                                              </div>
                                                <form action="{{route('return_bread')}}" method="post">
                                                  @csrf
                                                  <div class="card-block" style="overflow: auto">
                                                    <table class="table table-bordered table-striped table-hover bg-light bg-gradient" >
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                  Продукта
                                                                </th>
                                                                <th>
                                                                  Цена товара
                                                                </th>
                                                                <th>
                                                                  Количество
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($s->sale_item as $s_item)
                                                            <input type="hidden" name="client_id" value="{{$client->id}}">
                                                            <input type="hidden" name="sale_item_id[]" value="{{$s_item->id}}">
                                                            <tr>
                                                                <td class="align-middle">
                                                                  {{$s_item->bread->name}}
                                                                </td>
                                                                <td class="align-middle">
                                                                  {{number_format($s_item->price)}} ум
                                                                </td>
                                                                <td class="align-middle">
                                                                  <input type="number" class="w-100" name="quantity[]" max="{{$s_item->quantity-$s_item->return_bread->sum('quantity')}}" min="0" value="0">
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
                                                    <input type="hidden" name="sale_id" value="{{$s->id}}">
                                                    <button class="btn btn-sm btn-primary">Сохранить</button>
                                                  </div>
                                                </form>
                                            </div>
                                          </div>
                                        </div>
                  
                                </td>
                              </tr>
                              @empty
                              <tr>
                                  <td colspan="10" class="text-center">
                                      <h2>Нет заказов</h2>
                                  </td>
                              @endforelse
                          </tbody>
                      </table>
                    </div>
                    </div>
                </div>
            </div>
      </div>
      <form action="{{route('pay_client')}}" method="post" class="{{$ac2}}">
          @csrf
          <input type="hidden" name="client_id" value="{{$client->id}}">
        
          <div class="row">
              <div class="col-sm-12">
                  <div class="card"><div class="card-block" style="overflow: auto">
                    <table class="table table-sm table-bordered table-striped table-hover bg-light bg-gradient" >
                        <thead>
                            <tr>
                                <th>
                                  Оплата
                                </th>
                                <th>
                                  Тип
                                </th>
                                {{-- <th>
                                  Добавил
                                </th> --}}
                                <th>
                                  Дата
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $pay)
                            <tr>
                                <td class="align-middle">
                                {{number_format($pay->paid)}} сум
                                </td>
                                <td class="align-middle">
                                    <?=$pay->type=='nal' ? 'Наличка' : 'Перечление'?>
                                </td>
                                {{-- <td class="align-middle">
                                {{$pay->user->username}}
                                </td> --}}
                                <td class="align-middle">
                                {{\Carbon\Carbon::parse($pay->created_at)->format('d M Y H:i:s')}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h2>Нет истории платежей</h2>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                  </div>
                  </div>
              </div>
          </div>
      </form>
</div>
