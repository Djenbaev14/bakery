<div>
  <div class="card-block row ">
      <div class="col-sm-12 col-lg-12">
          <input type="text" class="form-control  border-bottom " wire:model.debounce.300ms="search" placeholder="Поиск клиентов">
      </div>
  </div>
  <div class="card-block " style="overflow: auto">
    
    <table id="myTable" class="table-sm table-bordered table-striped table-hover bg-light bg-gradient" style="width: 100%;min-width:100%;table-layout:auto;">
      <thead>
          <tr>
              <th>
                Маҳсулот номи	
              </th>
              <th>
                Маъсул
              </th>
              <th>
                Xаридор
              </th>
              <th>
                Товар нархи
              </th>
              <th>
                Тан нарх
              </th>
              <th>
                Толанган нарх
              </th>
              <th>
                Карз нархи
              </th>
              <th>
                Миқдор (дона)
              </th>
              <th>
                Вақти
              </th>
              <th>
                Действия
              </th>
          </tr>
      </thead>
      <tbody>
          @forelse ($sales as $sale)
          <tr>
              <td class="align-middle">
                  {{$sale->bread->name}}
              </td>
              <td class="align-middle">
                  {{$sale->user->username}}
              </td>
              <td class="align-middle">
                  {{$sale->client->name}}
              </td>
              <td class="align-middle">
                {{number_format($sale->price)}} сум
              </td>
              <td class="align-middle">
                {{number_format($sale->price * $sale->quantity)}} сум
              </td>
              <td class="align-middle">
                {{number_format($sale->sale_history->sum('paid'))}} сум
              </td>
              <td class="align-middle">
                {{($sale->price * $sale->quantity-$sale->sale_history->sum('paid') > 0)? number_format($sale->price * $sale->quantity-$sale->sale_history->sum('paid')) :  0;}} сум
              </td>
              <td class="align-middle">
                {{number_format($sale->quantity)}}
              </td>
              <td class="align-middle">
                {{\Carbon\Carbon::parse($sale->created_at)->format('d M Y H:i:s')}}
              </td>
              <td>
                {{-- <form action="{{route('sales.destroy',$sale->id)}}" method="post" class="mr-2">
                  @csrf
                  <button class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></button>
                  
                </form> --}}
                <a href="{{route('sales.destroy', $sale->id) }}" class="btn btn-danger btn-sm" data-confirm-delete="true">Delete</a>
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
    <p class="d-flex justify-content-end">{{$sales->links('pagination::bootstrap-4')}}</p>
  </div>
</div>
