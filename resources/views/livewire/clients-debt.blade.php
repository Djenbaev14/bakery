<div>
        <div class="card-block">
            
            <div class="row mb-4">
                <div class="col-12">
                    <button type="button" class="{{ $active1 }}  btn btn-light text-dark" wire:click="main()">Основной</button>
                    <button type="button" class="{{ $active2 }}  btn btn-light text-dark"  wire:click="kindergarden()">Перечисления</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <input type="text" class="form-control " wire:model='search' placeholder="Поиск клиентов">
                </div>
            </div>
        </div>
        <div class="card-block" style="overflow: auto">
            <table class="table table-sm table-bordered table-striped table-hover">
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
                    @forelse ($clients as $client)
                    <tr>
                        <td class="align-middle">
                          <span class="bg-danger bg-gradient rounded text-light p-1 pr-2 pl-2">{{$client->client_name}}</span>
                        </td>
                        <td class="align-middle">
                          {{$client->sum}}
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
            <div class="row m-1">
                <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Итого: {{number_format($total_debts)}} сум</span>
            </div>
        </div>
    
        <span class="d-flex justify-content-end">{{$clients->links('pagination::bootstrap-4')}}</span>

        
</div>
