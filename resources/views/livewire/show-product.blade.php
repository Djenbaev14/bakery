<div>
    <div class="card-block" style="overflow: auto; ">
      <div style="display:inline-flex;">
        <button type="button" class="font-weight-bold {{$active1}} btn btn-light border" wire:click="coming()">+Поступления</button>
        <button type="button" class="font-weight-bold {{$active2}} btn btn-light border"  wire:click="expenditure()">-Расходы</button>
      </div>
    </div>
    <div class="card-block {{$display1}}" style="overflow: auto">
      <span class="bg-outline-primary bg-gradient border border-primary text-primary pr-1 pl-1">Итого количество: {{$coming_products->sum ('quantity')}}
      </span><br><br>
        <table class="table table-sm table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        Поставщик
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
                        Дата создания
                    </th>
                    <th>
                        Действия
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($coming_products as $product)
                <tr>
                    <td class="align-middle">
                        {{ $product->supplier->name}}
                    </td>
                    <td class="align-middle">
                      {{$product->quantity}}
                    </td>
                    <td class="align-middle">
                      {{ number_format($product->price) }} сум
                    </td>
                    <td class="align-middle">
                      {{ number_format($product->price * $product->quantity) }} сум
                    </td>
                    <td class="align-middle">
                      {{\Carbon\Carbon::parse($product->created_at)->format('d M Y H:i:s')}}
                    </td>
                    <td class="d-flex justify-content-center">
                      <form action="{{route('product-show.destroy',$product->id)}}" method="post">
                        @csrf
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
        <span class="bg-outline-primary bg-gradient border border-primary text-primary pr-1 pl-1">Итого количество: {{number_format($expenditure_products->sum('quantity'),3)}}</span><br><br>
        <table class="table table-sm table-bordered table-striped table-hover">
          <thead>
              <tr>
                <th>
                  Количество
                </th>
                <th>
                    Дата создания
                </th>
              </tr>
          </thead>
          <tbody>
              @forelse ($expenditure_products as $product)
              <tr>
                  <td class="align-middle">
                      {{ $product->quantity}}
                  </td>
                  <td class="align-middle">
                    {{\Carbon\Carbon::parse($product->created_at)->format('d M Y H:i:s')}}
                  </td>
              </tr>
              @empty
              <tr>
                  <td colspan="8" class="text-center">
                      <h2>Расходы нет</h2>
                  </td>
              @endforelse
          </tbody>
        </table>
    </div>
</div>
