<div>
    <div class="card-block">
      <div class="row">
        <div class="col-lg-12 col-sm-6">
            <input type="text" class="form-control mt-2" wire:model='search' placeholder="Поиск клиентов">
        </div>
      </div>
    </div>
    <div class="card-block" style="overflow: auto">
        <table class="table table-sm table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>
                      Имя
                    </th>
                    <th>
                      Добавил
                    </th>
                    <th>
                      Номер телефона
                    </th>
                    <th>
                      Баланс
                    </th>
                    <th>
                      Действия
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                <tr>
                    <td class="align-middle">
                        <a href="{{route('client_histories',$client->id)}}">{{ $client->name}}</a>
                    </td>
                    <td class="align-middle">
                        {{ $client->user->username}}
                    </td>
                    <td class="align-middle">
                      {{$client->phone}}
                    </td>
                    <td class="align-middle">
                      {{number_format(client_balance($client->id))}} сум
                      {{-- {{number_format($client->payment_history->sum('paid')-$client->sale->sum('total'))}} сум  --}}
                    </td>
                    <td class="d-flex justify-content-around"> 
                      <button type="button" class="btn btn-sm btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#clientUpdate" onclick="getClientUpdate('{{$client->id}}','{{$client->name}}','{{$client->phone}}','{{$client->comment}}','{{$client->kindergarden}}')">
                        <i class="fa fa-edit"></i>
                      </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">
                        <h2>Клиенты нет</h2>
                    </td>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
