<div>
        <div class="card-block">
          <form action="{{route('expected.debts.status')}}" method="post">
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
                            <button type="submit" class="col-12 btn btn-sm btn-primary" id="save">Сохранить</button> 
                        </div>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-sm-12">
                <input type="text" class="form-control " wire:model='search' placeholder="Поиск клиентов">
            </div>
          </div>
        </div>
        <div class="card-block" style="overflow: auto">
            <table class="table-sm table-bordered table-striped table-hover" style="width: 100%;min-width:100%;table-layout:auto;">
                <thead>
                    <tr>
                      <th>
                        <input type="checkbox" class='form-control-sm' id="cc" onclick="javascript:checkAll(this,{{$sale_histories->sum('paid')}})"/>
                      </th>
                        <th>
                            Имя клиента	
                        </th>
                        <th>
                            Тип
                        </th>
                        <th>
                            Сумма
                        </th>
                        <th>
                            Статус
                        </th>
                        <th>
                            Время
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sale_histories as $sale_history)
                    <tr>
                        <td class="alig-middle">
                          <input name='check[]' class='check' for='flexCheckDefault'  type='checkbox' value={{$sale_history->id}} class='form-control-sm' onclick='javascript:check(this,{{$sale_history->paid}})'>
                        </td>
                        <td class="align-middle">
                          {{$sale_history->client->name}}
                        </td>
                        <td class="align-middle">
                          @if ($sale_history->type == 'nal')
                              <span class="bg-info bg-gradient rounded text-light p-1 pl-2 pr-2">Наличка</span>
                          @elseif($sale_history->type == 'per')
                          <span class="bg-success bg-gradient rounded text-light p-1 pl-2 pr-2">Перечисления</span>
                          @endif
                        </td>
                        <td class="align-middle">
                          {{number_format($sale_history->paid)}} сум
                        </td>
                        <td class="align-middle">
                            @if ($sale_history->status == 0)
                                <span class="bg-warning bg-gradient rounded text-light p-1 pl-2 pr-2">Ожидается</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            {{\Carbon\Carbon::parse($sale_history->created_at)->format('d M Y H:i')}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            <h2>Клента нет</h2>
                        </td>
                    @endforelse
                </tbody>
            </table>
          </form>
        </div>
        <div class="row m-1">
          {{-- <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Итого: {{number_format($total_paid)}} сум</span> --}}
        </div>
        <span class="d-flex justify-content-end">{{$sale_histories->links('pagination::bootstrap-4')}}</span>

        <div class="modal fade" id="updateDate">
            <div class="modal-dialog">
              <div class="modal-content">
          
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Изменить
                  </h4>
                  <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                </div>
                <div class="container mt-3 mb-3">
                  <form action="{{route('expected.debts.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="user_id">
                    <label for="startDate">Дата</label>
                    <input id="startDate" class="form-control" name="updated_at" type="datetime-local" />
                    <button type="submit" class="btn btn-primary mt-3">Изменить</button>
                  </form>
                </div>
          
              </div>
            </div>
          </div>
</div>
