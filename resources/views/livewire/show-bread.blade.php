<div>
    <div>
        <div class="card-block" style="overflow: auto; ">
          <div style="display:inline-flex;">
            <button type="button" class="font-weight-bold {{$active1}} btn btn-light border" wire:click="coming()">Производство</button>
            <button type="button" class="font-weight-bold {{$active2}} btn btn-light border"  wire:click="expenditure()">Продано</button>
          </div>
        </div>
        <div class="card-block {{$display1}}" style="overflow: auto">
            <span class="bg-outline-primary bg-gradient border border-primary text-primary pr-1 pl-1">Итого количество: {{$coming_bread->sum('quantity')}}</span><br><br> 
            <table class="table table-sm table-sm table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            Добавить
                        </th>
                        <th>
                          Количество
                        </th>
                        <th>
                            Себе стоимость
                        </th>
                        <th>
                            Сумма
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
                    @forelse ($coming_bread as $bread)
                    <tr>
                        <td class="align-middle">
                            {{ $bread->user->username}}
                        </td>
                        <td class="align-middle">
                          {{$bread->quantity}}
                        </td>
                        <td class="align-middle">
                          {{ number_format($bread->cost_price) }} сум
                        </td>
                        <td class="align-middle">
                          {{ number_format($bread->cost_price * $bread->quantity) }} сум
                        </td>
                        <td class="align-middle">
                          {{\Carbon\Carbon::parse($bread->created_at)->format('d M Y H:i:s')}}
                        </td>
                        <td class="d-flex justify-content-center">
                          <form action="" method="post">
                            <button class="btn btn-danger btn-sm" <?=(auth()->user()->role_id==2) ? "" : "disabled"?>><i class="fa fa-trash"></i></button>
                          </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <h2>Поступления нет</h2>
                        </td>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-block {{$display2}}" style="overflow: auto">
            <span class="bg-outline-primary bg-gradient border border-primary text-primary pr-1 pl-1">Итого количество: {{$expenditure_bread->sum('quantity')}}</span><br><br>
            <table class="table table-sm table-bordered table-striped table-hover">
              <thead>
                  <tr>
                    @foreach ($sellers as $seller)
                        <th>{{$seller->username}}</th>
                    @endforeach
                  </tr>
              </thead>
              <tbody>
                <tr>
                  @foreach ($sellers as $seller)
                    <td>{{$seller->sale_item->sum('quantity')}}</td>  
                  @endforeach
                </tr>
              </tbody>
            </table>
            {{-- <span class="d-flex justify-content-end">{{$expenditure_bread->links('pagination::bootstrap-4')}}</span> --}}
        </div>
    </div>
    
</div>
