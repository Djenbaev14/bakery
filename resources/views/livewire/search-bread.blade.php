<div>
    
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
                    <th>
                      №
                    </th>
                    <th>
                      Названия товара
                    </th>
                    <th>
                      Количество (Кг)
                    </th>
                    <th>
                      Цена
                    </th>
                    <th>
                      Цена Перечисление
                    </th>
                    <th>
                      Себе стоимость
                    </th>
                    <th>
                      Действия
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($breads as $bread)
                <tr>
                    <td class="align-middle">
                        {{-- {{ ($breads ->currentpage()-1) * $breads ->perpage() + $loop->index + 1 }} --}}
                        {{$bread->id}}
                    </td>
                    <td class="align-middle">
                        <a href="{{route('breads.show',$bread->id)}}">{{ $bread->name}}</a>
                    </td>
                    <td class="align-middle">
                      {{ warehouse_quan($bread->id) }}
                    </td>
                    <td class="align-middle">
                      {{number_format($bread->price)}} сум
                    </td>
                    <td class="align-middle">
                      {{number_format($bread->kindergarden_price)}} сум
                    </td>
                    <td class="align-middle">
                      <?php
                             $total=0;
                            if (auth()->user()->role_id==1) {
                              foreach ($bread->bread_product as $b_product){
                                  $total+=$b_product->product->price*($b_product->quantity/$b_product->milky_quan);
                              }
                                number_format($total);
                            }
                             ?>
                      {{number_format($total)}} сум
                    </td>
                    <td class="d-flex justify-content-around">
                      {{-- <form action="{{route('breads.destroy',$bread->bread_product[0]->id)}}" method="post" class="mr-2">
                        @csrf
                        <button class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></button>
                      </form> --}}
                      <button type="button" class="btn btn-sm btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#UpdateBread<?php echo $bread->id ?>">
                        <i class="fa fa-edit"></i>
                      </button>
                        
                        <!-- The Modal -->
                        <div class="modal fade" id="UpdateBread<?php echo $bread->id ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                        
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <h4 class="modal-title">Изменить продукта
                                </h4>
                                <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                              </div>
                              <div class="container mt-3 mb-3">
                                <form action="{{route('breads.update')}}" method="POST">
                                  @csrf
                                  <div class="form-group">
                                    <span>Названия товара
                                    </span>
                                    <input type="text" name="name" id="name" class="form-control" value="{{$bread->name}}">
                                  </div>
                                  @foreach ($bread->bread_product as $b)
                                  
                                  <div class="row align-items-center shadow p-3 mb-5  m-2 bg-white rounded">
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                            <label class="control-label" for="address_line_two_0">Наз про 
                                            </label>
                                            <select class="form-control" name="product_id[]">
                                              @foreach ($products as $product)
                                                @if ($product->id == $b->product_id)
                                                  <option value="{{$product->id}}" selected class="bg-info bg-gradient">{{$product->name}}</option>
                                                @else
                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                                @endif
                                              @endforeach
                                            </select>
                                      </div>
                                    </div>
                                    <div class="col-sm-3">
                                      <div class="form-group">
                                          <label class="control-label" for="address_line_two_0">Кол товар</label>
                                          <input type="text" name="litr[]" required value='{{$b->milky_quan}}' class="form-control">
                                      </div>
                                    </div>
                                    <div class="col-sm-3">
                                      <div class="form-group">
                                          <label class="control-label" for="address_line_two_0">Кол продукта</label>
                                          <input type="text" name="quantity[]" required value='{{$b->quantity}}' class="form-control">
                                      </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div>
                                            <a href="javascript:void(0)" class="remove-item-update btn btn-sm remove-social-media rounded-circle border"><i class="fa fa-minus"></i></a>
                                        </div>
                                    </div>
                                  </div>
                                  @endforeach
                                  <div id="update-container">
                                    <div class="panel container-item-update">
                                        <div class="panel-body">
                                            <div class="panel-body">
                                                <div class="row align-items-center shadow p-3 mb-5 bg-white rounded m-2">
                                                    <div class="col-sm-4">
                                                      <div class="form-group">
                                                          <label class="control-label" for="address_line_two_0">Названия</label>
                                                          <select class="form-control product_id" name="product_id[]">
                                                            @foreach ($products as $product)
                                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                                            @endforeach
                                                          </select>
                                                      </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                      <div class="form-group">
                                                          <label class="control-label" for="address_line_two_0">Литр</label>
                                                          <input type="text" name="litr[]" required class="form-control">
                                                      </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                      <div class="form-group">
                                                          <label class="control-label" for="address_line_two_0">Количество</label>
                                                          <input type="text" name="quantity[]" required class="form-control">
                                                      </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div>
                                                            <a href="javascript:void(0)" class="remove-item-update btn btn-sm remove-social-media rounded-circle border"><i class="fa fa-minus"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="row justify-content-center mb-4">
                                      <a class="btn btn-primary btn-sm col-10 " id="add-update" href="javascript:;" role="button"><i class="fa fa-plus"></i> Добавить ингридиенты</a>
                                  </div>

                                  <div class="form-group">
                                    <span >Цена</span>
                                    <input type="number" required name="price" id="price" min="0" class="form-control" value="{{$bread->price}}">
                                  </div>
                                  <div class="form-group">
                                    <span >Цена (Перечисления)</span>
                                    <input type="number" required name="kindergarden_price" id="kindergarden_price" min="0" class="form-control" value="{{$bread->kindergarden_price}}">
                                  </div>
                                  {{-- @foreach ($bread->bread_delivery_price as $b_d_price)
                                  <div class="">
                                    <div class="form-group">
                                      <span>Цена {{$b_d_price->user->username}}</span>
                                      <input type="number" required name="user_price[{{$b_d_price->user->id}}]" class="form-control" value="{{$b_d_price->price}}">
                                    </div>
                                    <div class="form-group">
                                      <span>Цена (Перечисления) {{$b_d_price->user->username}}</span>
                                      <input type="number" required name="user_kindergarden_price[{{$b_d_price->user->id}}]" class="form-control" value="{{$b_d_price->kindergarden_price}}">
                                    </div>
                                  </div>
                                @endforeach --}}
                                
                                @foreach ($users as $user)
                                <div class="">
                                  <div class="form-group">
                                    <span>Цена {{$user->username}}</span>
                                    <input type="text" required name="user_price[{{$user->id}}]" class="form-control" value=<?=$bread->bread_delivery_price->where('user_id',$user->id)->count() > 0 ? $bread->bread_delivery_price->where('user_id',$user->id)->first()->price : "";?>>
                                  </div>
                                  <div class="form-group">
                                    <span>Цена (Перечисления) {{$user->username}}</span>
                                    <input type="number" required name="user_kindergarden_price[{{$user->id}}]" class="form-control" value=<?=$bread->bread_delivery_price->where('user_id',$user->id)->count() > 0 ? $bread->bread_delivery_price->where('user_id',$user->id)->first()->kindergarden_price : "";?>>
                                  </div>
                                </div>
                              @endforeach
                                  {{-- <div class="form-group">
                                    <span >Цена выплачиваемая работникам</span>
                                    <input type="number" required name="kpi" id="kpi" min="0" class="form-control" value="{{$bread->kpi}}">
                                  </div> --}}
                                  <input type="hidden" name="id" id="id" value="{{$bread->id}}">
                                  <button type="submit" class="btn btn-primary" id="save2">Изменить</button>
                                </form>
                              </div>
                        
                            </div>
                          </div>
                        </div>
                        
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">
                        <h2>Нет продукта</h2>
                    </td>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
