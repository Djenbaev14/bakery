<div>
    <div class="card-block">
      <div class="row">
        <div class="col-lg-12 col-sm-6">
            <input type="text" class="form-control mt-2" wire:model='search' placeholder="Поиск продуктов">
        </div>
      </div>
    </div>
    <div class="card-block" style="overflow: auto">
        <table class="table table-sm table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>
                      Названия товара
                    </th>
                    <th>
                      Количество
                    </th>
                    <th>
                      Цена
                    </th>
                    <th>
                      Действия
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td class="align-middle">
                      {{ $product->name}}
                    </td>
                    <td class="align-middle">
                      {{product_quan($product->id)}}
                        {{$product->union->name}}
                    </td>
                    <td class="align-middle">
                      {{number_format($product->price)}} сум
                    </td>
                    {{-- <td class="align-middle">
                      {{\Carbon\Carbon::parse($product->updated_at)->format('d M Y H:i:s')}}
                    </td> --}}
                    <td class="d-flex justify-content-around">
                      <button type="button" class="btn btn-sm btn-success mr-3" data-bs-toggle="modal" data-bs-target="#quantity" onclick="getId('{{$product->id}}','{{$product->name}}')">
                        <i class="fa fa-plus"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-primary mr-3" data-bs-toggle="modal" data-bs-target="#UpdateProduct" onclick="getVal('{{$product->id}}','{{$product->name}}','{{$product->price}}')">
                        <i class="fa fa-edit"></i>
                      </button>
                      <a href="{{route('products.show',$product->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
                        
                        <!-- The Modal -->
                        <div class="modal fade" id="UpdateProduct">
                          <div class="modal-dialog">
                            <div class="modal-content">
                        
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <h4 class="modal-title">Изменить продукта
                                </h4>
                                <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                              </div>
                              <div class="container mt-3 mb-3">
                                <form action="{{route('products.update')}}" method="POST">
                                  @csrf
                                  <div class="form-group">
                                    <span>Названия товара
                                    </span>
                                    <input type="text" required name="name" id="name" class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <span >Цена</span>
                                    <input type="number" name="price" required id="price" min="0" class="form-control">
                                  </div>
                                  <input type="hidden" name="id" id="id">
                                  <button type="submit" class="btn btn-primary" id="save2">Изменить</button>
                                </form>
                              </div>
                        
                            </div>
                          </div>
                        </div>
                        <!-- The Modal -->
                        <div class="modal fade" id="quantity">
                          <div class="modal-dialog">
                            <div class="modal-content">
                        
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <h4 class="modal-title">Поставить товар на склад
                                </h4>
                                <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                              </div>
                              <div class="container mt-3 mb-3">
                                <form action="{{route('products.addQuantity')}}" method="POST">
                                  @csrf
                                  <input type="hidden" name="product_id" id="product_id">
                                  <div class="form-group">
                                    <span >Название
                                    </span>
                                    <input type="text" id="product_name" disabled name="name" class="form-control pl-2 mt-2"> 
                                  </div>
                                  <div class="row">
                                    <div class="form-group col-lg-6">
                                      <span>Количество
                                      </span>
                                      <input type="numer" required name="quantity" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                      <span>Цена
                                      </span>
                                      <input type="numer" required name="price" class="form-control">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleFormControlSelect1">Поставщик</label>
                                    <select class="form-control" name="supplier_id">
                                      <option hidden>Выберите поставщика</option>
                                      @foreach ($suppliers as $supplier)
                                          <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <input type="date" name="created_at" id="datetime" name="datetime" value="{{date('Y-m-d')}}">
                                  <br><br>
                                  <button type="submit" class="btn btn-sm btn-primary" id="save3">Добавить</button>
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
                        <h2>Продуктов нет</h2>
                    </td>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
