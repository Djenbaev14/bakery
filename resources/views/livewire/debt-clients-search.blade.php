<div>
    <div class="card-block">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Основной</button>
          <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Перечисления</button>
        </div>
      </nav>
    </div>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <livewire:d-ebt-clients/>
        {{-- <div class="card-block">
          <div class="row">
              <div class="col-sm-12 col-lg-12">
                  <input type="text" class="form-control" wire:model='search_main' placeholder="Поиск клиентов">
              </div>
          </div>
        </div>
        <div class="card-block" style="overflow: auto">
          <table class="table-sm table-bordered table-striped table-hover bg-light bg-gradient" style="width: 100%;min-width:100%;table-layout:auto;">
            <thead>
                <tr>
                    <th>
                        Имя клиента	
                    </th>
                    <th sortable wire:click="sortBy('summa')" :direction="$sortField==='summa' ? $sortDirection : null">
                        Сумма
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($main_clients as $client)
                <tr>
                    <td class="align-middle">
                        {{$client->name}}
                    </td>
                    <td class="align-middle">
                        {{number_format($client->sale->sum(function($t){return $t->price * $t->quantity;}) - $client->sale_history->sum('paid'))}} сум
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
        </div> --}}
        
      </div>
      <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <livewire:kindergarden-debt-clients/>
        {{-- <div class="card-block">
          <div class="row">
              <div class="col-sm-12 col-lg-12">
                  <input type="text" class="form-control" wire:model='search_kindergarten' placeholder="Поиск клиентов">
              </div>
          </div>
        </div>
        <div class="card-block" style="overflow: auto">
          <table class="table-sm table-bordered table-striped table-hover bg-light bg-gradient" style="width: 100%;min-width:100%; table-layout:auto;">
            <thead>
                <tr>
                    <th>
                        Имя клиента
                    </th>
                    <th>
                        Сумма
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kindergarten_clients as $client)
                <tr>
                    <td class="align-middle">
                        {{$client->name}}
                    </td>
                    <td class="align-middle">
                        {{number_format($client->sale->sum(function($t){return $t->price * $t->quantity;}) - $client->sale_history->sum('paid'))}} сум
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">
                        <h2>Клиент нет</h2>
                    </td>
                @endforelse
            </tbody>
        </table>
      </div> --}}
    </div>
  
      
  </div>
  
  
  
