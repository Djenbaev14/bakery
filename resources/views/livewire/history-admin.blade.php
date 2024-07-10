<div>
    <div class="row">
          <div class="col-sm-12">
              <div class="card">
                  <div class="card-block">
                    <form action="{{route('history-admin-filter',$user_id)}}" method="POST">
                      @csrf
                      <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="date" name="date_from" required class="form-control" >
                          </div>
                          <div class="col-md-6 form-group">
                            <input type="date" name="date_to" required class="form-control" >
                          </div>
                          <div class="col-md-2 form-group" >
                            <input type="submit" class="btn btn-primary" value="Фильтр">
                          </div>
                      </div>
                    </form>
                    {{-- <div class="row mb-4">
                        <div class="col-6">
                            <input type="text" class="form-control mt-2" wire:model='search' placeholder="Поиск клиентов">
                        </div>
                    </div> --}}
                      <form action="{{route('history-admin-money')}}" method="POST">
                        @csrf
                        <input type="submit" class="btn btn-primary" value='goo'><br><br>
                        <table class="table table-sm table-bordered table-striped table-hover">
                          <thead>
                              <tr>
                                  <th>
                                    <input type="checkbox" class='form-control' id="cc" onclick="javascript:checkAll(this)"/>
                                  </th>
                                  <th class="align-middle">
                                    Название продукта
                                  </th>
                                  <th class="align-middle">
                                    ответственный
                                  </th>
                                  <th class="align-middle">
                                      Клиенты
                                  </th>
                                  <th class="align-middle">
                                    стоимость
                                  </th>
                                  <th class="align-middle">
                                    итого
                                  </th>
                                  <th class="align-middle">
                                    оплачено
                                  </th>
                                  <th class="align-middle">
                                    долг
                                  </th>
                                  <th class="align-middle">
                                    время
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                              @forelse ($users as $user)
                              <tr>
                                <td class="align-middle">
                                  <input name='check[]' for="flexCheckDefault" type='checkbox' value="<?=$user->id;?>" class='form-control'>
                                </td>
                                <td class="align-middle">
                                  {{$user->bread_name}}
                                </td>
                                <td class="align-middle">
                                  {{$user->responsible}}
                                </td>
                                <td class="align-middle">
                                  {{$user->client_name}}
                                </td>
                                <td class="align-middle">
                                  {{number_format($user->bread_price)}} сум
                                </td>
                                <td class="align-middle">
                                  {{number_format($user->total_amount)}} сум
                                </td>
                                <td class="align-middle">
                                  {{number_format($user->paid)}} сум
                                </td>
                                <td class="align-middle">
                                  {{number_format($user->debt)}} сум
                                </td>
                                <td class="align-middle">
                                    {{\Carbon\Carbon::parse($user->updated_at)->format('d M Y H:i')}}
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
                      <div class="row m-1">
                        <span class="bg-info bg-gradient rounded text-light p-1 pr-2 pl-2  mr-4">Общая итог: {{number_format($total_amount)}} сум</span>
                        <span class="bg-success bg-gradient rounded text-light p-1 pr-2 pl-2 mr-4">Оплачено: {{number_format($total_paid)}} сум</span>
                        <span class="bg-primary bg-gradient rounded text-light p-1 pr-2 pl-2 mr-4">Торговля за наличные: {{number_format($total_cash)}} сум</span>
                        <span class="bg-warning bg-gradient rounded text-light p-1 pr-2 pl-2 mr-4">Торговля за Терминал: {{number_format($total_transfers)}} сум</span>
                        <span class="bg-danger bg-gradient rounded text-light p-1 pr-2 pl-2 mr-4">Долг: {{number_format($total_debt)}} сум</span>
                      </div>
                  </div>
              
                  <span class="d-flex justify-content-end">{{$users->links('pagination::bootstrap-4')}}</span>
              </div>
          </div>
    </div>
</div>

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