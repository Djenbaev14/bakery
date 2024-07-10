<div>
        <div class="card-block">
            <div class="row mb-4">
                <div class="col-12 buttons">
                    <button type="button" class="{{ $active1 }} main btn1 btn btn-light text-dark" wire:click="delivery()"><i class="fa fa-shopping-card"></i>  Поставки
                        </button>
        
                    <button type="button" class="{{ $active2 }} kindergarden btn1 btn btn-light text-dark"  wire:click="payment()"><i class="fa fas-money"></i> Платежи</button>
                </div>
            </div>
        </div> 
          
          
        <div class="row {{$ac1}}">
            <div class="col-sm-12">
                <div class="card">
                  <div class="card-block" style="overflow: auto">
                  <table class="table table-sm table-bordered table-striped table-hover bg-light bg-gradient" >
                      <thead>
                          <tr>
                              <th>
                                ID
                              </th>
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
                                {{$deli->id}}
                            </td>
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
                </div>
            </div>
        </div>
        <div class="row {{$ac2}}">
          <div class="col-sm-12">
              <div class="card">
                <div class="card-block" style="overflow: auto">
                <table class="table table-sm table-bordered table-striped table-hover bg-light bg-gradient" >
                    <thead>
                        <tr>
                            <th>
                              ID
                            </th>
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
                              {{$payment->id}}
                          </td>
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
                          <td>

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
