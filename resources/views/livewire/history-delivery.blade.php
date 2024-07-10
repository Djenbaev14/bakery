<div>
  <div class="card">
    <div class="card-header">
      <div class="container">
        <div class="row justify-content-between align-items-center">
          <h4 class="col-lg-3 col-sm-12">История доставок
          </h4>
          <select wire:model="truck_id" class="select2bs4 col-lg-2 col-sm-12"  aria-label="Default select example">
              @if (auth()->user()->role_id != 3)
                <option value="null" >Искать доставщика</option>
              @endif
              @foreach ($truck as $t)
              <option value="{{$t->id}}" >{{$t->username}}</option>
              @endforeach
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-block" style="overflow: auto; ">
      <nav class="mb-3">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Загружен</button>
          <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Остаток</button>
          <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Перемищения</button>
          <button class="nav-link" id="nav-expected-tab" data-bs-toggle="tab" data-bs-target="#nav-expected" type="button" role="tab" aria-controls="nav-expected" aria-selected="false">Ожидаемые перемещение</button>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" style="overflow: auto" role="tabpanel" aria-labelledby="nav-home-tab">
          <table class="table table-sm table-bordered table-striped table-hover">
              <thead>
                  <tr>
                      <th>
                        Названия
                      </th>
                      <th>
                        Добавил
                      </th>
                      <th>
                        Количество
                      </th>
                      <th>
                        Время
                      </th>
                  </tr>
              </thead>
              <tbody>
                  @forelse ($deliveries as $delivery)
                  <tr>
                      <td class="align-middle">
                          {{ $delivery->bread->name}}
                      </td>
                      <td class="align-middle">
                        {{ $delivery->responsible->username }}
                      </td>
                      <td class="align-middle">
                        {{$delivery->quantity}}
                      </td>
                      <td class="align-middle">
                        {{\Carbon\Carbon::parse($delivery->created_at)->format('d M Y H:i:s')}}
                      </td>
                      {{-- <td class="d-flex justify-content-center">
                        <form action="" method="post">
                          <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                      </td> --}}
                  </tr>
                  @empty
                  <tr>
                      <td colspan="8" class="text-center">
                          <h2>Доставка нет</h2>
                      </td>
                  @endforelse
              </tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="nav-profile" style="overflow: auto" role="tabpanel" aria-labelledby="nav-profile-tab">
          <table class="table table-sm table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>
                      Названия
                    </th>
                    <th>
                      Количество
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($breads as $bread)
                <tr>
                    <td class="align-middle">
                        {{ $bread->name}}
                    </td>
                    <td class="align-middle">
                      {{$bread->quantity}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">
                        <h2>Остаток нет</h2>
                    </td>
                @endforelse
            </tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="nav-contact" style="overflow: auto" role="tabpanel" aria-labelledby="nav-contact-tab">
          <table class="table table-sm table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>
                      Названия
                    </th>
                    <th>
                      Добавил
                    </th>
                    <th>
                      Количество
                    </th>
                    <th>
                      Время
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($refund_breads as $r_bread)
                <tr>
                    <td class="align-middle">
                        {{ $r_bread->bread->name}}
                    </td>
                    <td class="align-middle">
                      {{ $r_bread->user->username }}
                    </td>
                    <td class="align-middle">
                      {{$r_bread->quantity}}
                    </td>
                    <td class="align-middle">
                      {{\Carbon\Carbon::parse($r_bread->updated_at)->format('d M Y H:i:s')}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">
                        <h2>Перемищения нет</h2>
                    </td>
                @endforelse
            </tbody>
          </table>
        </div>
        
        <div class="tab-pane fade" id="nav-expected" style="overflow: auto" role="tabpanel" aria-labelledby="nav-expected-tab">
          <table class="table table-sm table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>
                      Названия
                    </th>
                    <th>
                      Добавил
                    </th>
                    <th>
                      Количество
                    </th>
                    <th>
                      Время
                    </th>
                    <th>
                      Действия
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($expected_movements as $r_bread)
                <tr>
                    <td class="align-middle">
                        {{ $r_bread->bread->name}}
                    </td>
                    <td class="align-middle">
                      {{ $r_bread->user->username }}
                    </td>
                    <td class="align-middle">
                      {{$r_bread->quantity}}
                    </td>
                    <td class="align-middle">
                      {{\Carbon\Carbon::parse($r_bread->updated_at)->format('d M Y H:i:s')}}
                    </td>
                    <td class="d-flex">
                      {{-- <form action="{{route('deliveries.refund-destroy',$r_bread->id)}}" method="post">
                        @csrf
                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                      </form> --}}
                      @if (auth()->user()->role_id!=3)
                        <a href="{{route('expected-refund.confirm',$r_bread->id)}}" class='btn btn-success btn-sm mr-3'><i class='fa fa-check'></i></a>
                      @endif
                      <a href="{{route('expected-refund.destroy',$r_bread->id)}}" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">
                        <h2>Перемищения нет</h2>
                    </td>
                @endforelse
            </tbody>
          </table>
        </div>
      </div>
      
    </div>
  </div>
    
</div>
