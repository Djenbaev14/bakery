<div>
    
  <div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-block">
              <div class="row">
                <div class="col-lg-12 col-sm-6">
                    <input type="text" class="form-control mt-2" wire:model='search' placeholder="Поиск">
                </div>
              </div>
            </div>
            <div class="card-block" style="overflow: auto">
                <table class="table table-sm table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            {{-- <th>
                              №
                            </th> --}}
                            <th>
                              Название продукта
                            </th>
                            <th>
                              Добавил
                            </th>
                            <th>
                              Количество
                            </th>
                            <th>
                              Себе стоимость
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
                        @forelse ($production as $pro)
                        <tr>
                            {{-- <td class="align-middle">
                                {{ ($production ->currentpage()-1) * $production ->perpage() + $loop->index + 1 }}
                                {{$pro->id}}
                            </td> --}}
                            <td class="align-middle">
                                {{ $pro->bread->name}}
                            </td>
                            <td class="align-middle">
                                {{ $pro->user->username}}
                            </td>
                            <td class="align-middle">
                              {{ $pro->quantity }}
                            </td>
                            <td class="align-middle">
                              @if (auth()->user()->role_id==1)
                                {{ number_format($pro->cost_price) }} сум
                              @endif
                            </td>
                            <td class="align-middle">
                              {{\Carbon\Carbon::parse($pro->created_at)->format('d M Y H:i:s')}}
                            </td>
                            <td class="align-middle d-flex justify-content-between">
                              <form action="{{route('productions.destroy',$pro->id)}}" method="post">
                                @csrf
                                <button class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></button>
                            </form>
                            
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#returnProduct<?php echo $pro->id ?>">
                              <i class="fa fa-minus text-light"></i>
                            </button>

                            
                                <!-- The Modal -->
                                <div class="modal fade" id="returnProduct<?php echo  $pro->id ?>">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
          
                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title">Изменение количества товаров</h4>
                                      </div>
                                      
                                      <form action="{{route('productions.changeQuan',$pro->id)}}" method="post">
                                        @csrf
                                        <div class="card-block" style="overflow: auto">
                                          <input type="number" name="quantity" class="form-control" value="0"><br><br>
                                          <button class="btn btn-sm btn-primary">Сохранить</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <h2>Производство нет</h2>
                            </td>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- <span class="d-flex justify-content-end">{{$production->links('pagination::bootstrap-4')}}</span> --}}
        </div>
    </div>

  </div>
</div>
