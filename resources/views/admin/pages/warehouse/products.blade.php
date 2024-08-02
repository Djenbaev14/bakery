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
                  <h4 class="col-lg-3 col-sm-12">Склад 1
                  </h4>
                  <button class="col-lg-2 col-sm-12 btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal1">Добавить</button>
                    <!-- The Modal -->
                    <div class="modal fade" id="myModal1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                    
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Добавить товар
                            </h4>
                            <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                          </div>
                          <div class="container mt-3 mb-3">
                            <form action="{{route('products.create')}}" method="POST">
                              @csrf
                              <div class="form-group">
                                <span>Названия товара</span>
                                <input type="text" required name="name" class="form-control" value={{old('name')}}>
                              </div>
                              <div class="form-group">
                                <span>Цена</span>
                                <input type="text" required name="price" class="form-control" value={{old('price')}}>
                              </div>
                              <div class="form-group">
                                <label for="exampleFormControlSelect1">Единица измерения</label>
                                <select class="form-control" name="union_id">
                                  @foreach ($unions as $union)
                                      <option value="{{$union->id}}">{{$union->name}}</option>
                                  @endforeach
                                </select>
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
            {{-- @livewire('search-product') --}}
        </div>
        <div class="card">
          
        <div class="card-block">
          <div class="row">
            <div class="col-lg-12 col-sm-6">
                {{-- <input type="text" class="form-control mt-2" wire:model='search' placeholder="Поиск продуктов"> --}}
                <input type="text" class="form-control mt-2" id="searchInput" onkeyup="searchTable()" placeholder="Поиск продуктов" style="width: 100%">
            </div>
          </div>
        </div>
        <div class="card-block" style="overflow: auto">
          <table id="myTable" class="table table-sm table-bordered table-striped table-hover">
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
                       <a href="{{route('products.show',$product->id)}}">{{ $product->name}}</a>
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
                    <td class="d-flex">
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
    </div>
</div>
@endsection

@push('js')
    <script>
      function getVal(id,name,price){
          $('#id').val(id);
          $('#name').val(name);
          $('#price').val(price);
      }
      
      function getId(id,name){
          $('#product_id').val(id);
          $('#product_name').val(name);
      }
    </script>
    
  <script>
    function searchTable() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");

      // Har bir qatorni aylanib chiqish
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
          if (td[j]) {
            txtValue = td[j].textContent || td[j].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
              break; // Agar mos keladigan ma'lumot topilsa, qolgan ustunlarni tekshirishni to'xtatadi
            } else {
              tr[i].style.display = "none";
            }
          }       
        }
      }
    }
  </script>
@endpush