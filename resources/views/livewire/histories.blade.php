<div>
    <div class="card-block" style="overflow: auto">
      <table class="table table-sm table-bordered table-striped table-hover bg-light bg-gradient" >
          <thead>
              <tr>
                  <th>
                    Общая сумма
                  </th>
                  <th>
                    Оплаченная
                  </th>
                  <th>
                    Долг
                  </th>
                  <th>
                    Время
                  </th>
                  <th>
                    Действия
                  </th>
              </tr>
          </thead>
          {{-- <tbody>
              @forelse ($sales as $sale)
              <tr>
                  <td class="align-middle">
                    {{$sale->user->username}}
                  </td>
                  <td class="align-middle">
                    {{$sale->client->name}}
                  </td>
                  <td class="align-middle">
                    {{number_format($sale->total)}} сум
                  </td>
                  <td class="align-middle">
                        {{number_format($sale->sale_history->sum('paid'))}} сум
                  </td>
                  <td class="align-middle">
                    @if ($sale->total-$sale->sale_history->sum('paid') != 0)
                      <span class="rounded text-danger border border-danger p-1">{{number_format($sale->total-$sale->sale_history->sum('paid'))}}  сум</span>
                    @else
                      <span class="rounded text-success border border-success p-1">Оплачено</span>
                    @endif
                  </td>
                  <td class="align-middle">
                    {{\Carbon\Carbon::parse($sale->created_at)->format('d M Y H:i:s')}}
                  </td>
                  <td class="d-flex justify-content-around">
                    <button class="btn btn-success bg-gradient btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#debt" onclick="getClient('{{$sale->id}}','{{$sale->total-$sale->sale_history->sum('paid')}}}')"> <i class="fa fa-check"></i></button>
                    <button type="button" class="btn btn-sm btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#UpdateBread<?php echo $sale->id ?>">
                      <i class="fa fa-eye"></i>
                    </button>
                    
                        <!-- The Modal -->
                        <div class="modal fade" id="UpdateBread<?php echo  $sale->id ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
  
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <h4 class="modal-title">Продукты
                                </h4>
                              </div>
                                
                                  <div class="card-block" style="overflow: auto">
                                    <table class="table table-bordered table-striped table-hover bg-light bg-gradient" >
                                        <thead>
                                            <tr>
                                                <th>
                                                  Продукта
                                                </th>
                                                <th>
                                                  Цена товара
                                                </th>
                                                <th>
                                                  Количество
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($sale->sale_item as $s_item)
                                            <tr>
                                                <td class="align-middle">
                                                    {{ $s_item->bread->name}}
                                                </td>
                                                <td class="align-middle">
                                                  {{$s_item->price}}
                                                </td>
                                                <td class="align-middle">
                                                  {{$s_item->quantity }}
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
                                  </div>
                              <div class="container mt-3 mb-3">
  
                              </div>
  
                            </div>
                          </div>
                        </div>
  
  
                  </td>
              </tr>
              @empty
              <tr>
                  <td colspan="10" class="text-center">
                      <h2>Продажи нет</h2>
                  </td>
              @endforelse
          </tbody> --}}
      </table>
    </div>
</div>
