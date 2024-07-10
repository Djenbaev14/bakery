@extends('admin.layouts.main')

@section('title', 'Все новости')

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
                  {{-- <h4>Список поставщиков
                  </h4> --}}
                  <h4 class="col-lg-3 col-sm-12">Список поставщиков
                  </h4>
                  {{-- <button class="col-lg-2 col-sm-12 btn btn-primary" data-bs-toggle="modal" data-bs-target="#myClient">Добавить</button> --}}
                  <button class="col-lg-3 col-sm-12 btn btn-primary" style="display: inline-block" data-bs-toggle="modal" data-bs-target="#myClient">Добавить поставщика
                  </button>
                    <!-- The Modal -->
                    <div class="modal fade" id="myClient">
                      <div class="modal-dialog">
                        <div class="modal-content">
                    
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Добавить поставщика
                            </h4>
                            <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                          </div>
                          <div class="container mt-3 mb-3">
                            <form action="{{route('suppliers.create')}}" method="POST">
                              @csrf
                              <div class="form-group">
                                <span>Имя</span>
                                <input type="text" name="name" required class="form-control" value={{old('name')}}>
                              </div>
                              <div class="form-group">
                                <span>Телефон номер</span>
                                <input type="text" name="phone" required class="form-control" value={{old('phone')}}>
                              </div>
                              <div class="form-group">
                                <span>Описание</span>
                                <textarea name="comment" class="form-control" value={{old('comment')}}></textarea>
                              </div> 
                              <button type="submit" class="btn btn-primary" id="save">Добавить</button>
                            </form>
                          </div>
                    
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
        <div class="card">
          <div class="card-block">
            <div class="card-block" style="overflow: auto">
                <table class="table table-sm table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                              ФИО
                            </th>
                            <th>
                              Номер телефона
                            </th>
                            <th>
                              Баланс
                            </th>
                            <th>
                              Информация
                            </th>
                            <th>
                              Действия
                            </th>
                        </tr>
                    </thead>
                  <tbody>
                    @forelse ($suppliers as $supplier)
                    <tr>
                        <td class="align-middle">
                          <a href="{{route('suppliers.show',$supplier->id)}}">{{$supplier->name}}</a>
                        </td>
                        {{-- <td class="align-middle">
                            {{ $client->sale[0]->user->name}}
                        </td> --}}
                        <td class="align-middle">
                          {{$supplier->phone}}
                        </td>
                        <td class="align-middle">
                          {{number_format($supplier->transfers_to_supplier->sum('paid')-$supplier->coming_product->sum(function($t){return $t->price * $t->quantity;}))}} сум
                        </td>
                        <td class="align-middle">
                          {{$supplier->comment}}
                        </td>
                        <td class="d-flex justify-content-around"> 
                          <button type="button" class="btn btn-sm btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#clientUpdate" onclick="getClientUpdate('{{$supplier->id}}','{{$supplier->name}}','{{$supplier->phone}}','{{$supplier->comment}}')">
                            <i class="fa fa-edit"></i>
                          </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <h2>Нет поставщика</h2>
                        </td>
                    @endforelse
                </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="clientUpdate">
      <div class="modal-dialog">
        <div class="modal-content">
    
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Изменить клиента
            </h4>
            <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
          </div>
          <div class="container mt-3 mb-3">
            <form action="{{route('suppliers.update')}}" method="POST">
              @csrf
              <div class="form-group">
                <span>Имя</span>
                <input type="text" name="name" id="name" class="form-control">
              </div>
              <div class="form-group">
                <span>Телефон номер</span>
                <input type="text" name="phone" id="phone" class="form-control" >
              </div>
              <div class="form-group">
                <span>Комментария</span>
                <textarea name="comment" id="comment" class="form-control"></textarea>
              </div> 
              <input type="hidden" name="id" id="id">
              <button type="submit" class="btn btn-primary" id="save2">Изменить</button>
            </form>
          </div>
    
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
      function getClientUpdate(id,name,phone,comment){
          $('#id').val(id);
          $('#name').val(name);
          $('#phone').val(phone);
          $('#comment').val(comment);
      }
    </script>
@endpush

