@extends('admin.layouts.main')

@section('title', 'Trio System')

@section('breadcrumb')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    {{-- <h5 class="m-b-10">Новости</h5> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
              <div class="container">
                <div class="row justify-content-between align-items-center">
                  <h4 class="col-4">Доставка
                  </h4>
                  @if (auth()->user()->role_id==3)
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal2">Перемещать</button>
                    <!-- The Modal -->
                    <div class="modal fade" id="myModal2">
                      <div class="modal-dialog">
                        <div class="modal-content">
                    
                          <div class="modal-header">
                            <h4 class="modal-title">Перемещения
                            </h4>
                            <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                          </div>
                          <div class="container mt-3 mb-3">
                            <form action="{{route('deliveries.refund')}}" method="POST">
                              @csrf
                              <div class="form-group">
                                <span>Товар</span>
                                <select class="form-control"  required name="bread_id" aria-label="Default select example">
                                  @foreach ($delivery_breads as $m)
                                    <option value="{{$m->id}}">{{$m->name}} ({{$m->quantity}}) штук</option>
                                  @endforeach
                                </select>
                              </div>    
                              <div class="form-group">
                                <span>Количество</span>
                                <input type="number" name="quantity" min="1" required class="form-control" value={{old('quantity')}}>
                              </div>
                              <button type="submit" class="btn btn-primary" id="save">Добавить</button>
                            </form>
                          </div>
                    
                        </div>
                      </div>
                    </div>
                    @else
                      <button class="btn btn-primary col-2" data-bs-toggle="modal" data-bs-target="#myModal1">Добавить</button>
                      <!-- The Modal -->
                      <div class="modal fade" id="myModal1">
                        <div class="modal-dialog">
                          <div class="modal-content">
                      
                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Доставка
                              </h4>
                              <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                            </div>
                            <div class="container mt-3 mb-3">
                              <form action="{{route('deliveries.create')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                  <span>Грузовик</span>
                                  <select class="form-control" required name="truck_id" aria-label="Default select example">
                                    @foreach ($trucks as $truck)
                                      <option value="{{$truck->id}}">{{$truck->username}}</option>
                                    @endforeach
                                  </select>
                                </div>  
                                <div class="form-group">
                                  <span>Товар</span>
                                  <select class="form-control" required name="bread_id" aria-label="Default select example">
                                    @foreach ($breads as $bread)
                                      <option value="{{$bread->id}}">{{$bread->name}} ({{warehouse_quan($bread->id)}})штук</option>
                                    @endforeach
                                  </select>
                                </div>  
                                <div class="form-group">
                                  <span>Количество</span>
                                  <input type="text" name="quantity" required class="form-control" value={{old('quantity')}}>
                                </div>
                                <button type="submit" class="btn btn-primary" id="save2">Добавить</button>
                              </form>
                            </div>
                      
                          </div>
                        </div>
                      </div>
                  @endif
                </div>
              </div>
            </div>
            
        </div>
    </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-block" style="overflow: auto">
          <table class="table table-sm table-bordered table-striped table-hover">
              <thead>
                  <tr>
                      <th>
                        Названия
                      </th>
                      <th>
                        Добавил
                      </th>
                      <th>
                        Доставщик
                      </th>
                      <th>
                        Количество
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
                  @forelse ($deliveries as $delivery)
                  <tr>
                      <td class="align-middle">
                          {{ $delivery->bread->name}}
                      </td>
                      <td class="align-middle">
                        {{ $delivery->responsible->username }}
                      </td>
                      <td class="align-middle">
                        {{ $delivery->truck->username }}
                      </td>
                      <td class="align-middle">
                        {{$delivery->quantity}}
                      </td>
                      <td class="align-middle">
                        {{\Carbon\Carbon::parse($delivery->created_at)->format('d M Y H:i:s')}}
                      </td>
                      <td class="d-flex justify-content-center">
                        @if (auth()->user()->role_id!=3)
                          <form action="{{route('deliveries.destroy',$delivery->id)}}" method="post">
                            @csrf
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                          </form>
                        @endif
                      </td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="8" class="text-center">
                          <h2>Доставка нет</h2>
                      </td>
                  @endforelse
              </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
@endpush

@push('js')

    <script>
      $(document).ready(function () {
      $('.selectpicker').selectize({
          sortField: 'text'
      });
      });
    </script>
    <script>
      
        var price = document.getElementsByClassName("price");
        var quantity = document.getElementsByClassName("quantity");
        var bread_id = document.getElementsByClassName("bread_id");
        var summa = document.getElementsByClassName('summa');
        for (let i = 0; i < quantity.length; i++) {
          quantity[i].oninput = function() {
            summa[i].value = quantity[i].value * price[i].value;
            var obsun = 0;
            for (let id = 0; id < summa.length; id++) {
              if(summa[id].value){
                obsun += parseInt(summa[id].value);
              }
            }
            document.getElementById("total_price").value=obsun;

            var q = 0;
            for (let j = 0; j < quantity.length; j++) {
              if(quantity[j].value){
                q += parseInt(quantity[j].value);
              }
            }
            document.getElementById("total_count").innerHTML=q;

          };
          price[i].oninput = function() {
            summa[i].value = quantity[i].value * price[i].value;
            
            var obsun = 0;
            for (let id = 0; id < summa.length; id++) {
              if(summa[id].value){
                obsun += parseInt(summa[id].value);
              }
            }
            document.getElementById("total_price").value=obsun;
          };

        }
    </script>
@endpush