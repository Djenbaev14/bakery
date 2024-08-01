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
                  <h4 class="col-lg-3 col-sm-12">Склад 2
                  </h4>
                  <button class="col-lg-2 col-sm-12 btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal1">Добавить</button>
                    <!-- The Modal -->
                    <div class="modal fade" id="myModal1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                    
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Склад 2
                            </h4>
                            <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                          </div>
                          <div class="container mt-3 mb-3">
                            <form action="{{route('breads.create')}}" method="POST">
                              @csrf
                              <div class="form-group">
                                <span>Названия товара</span>
                                <input type="text" required name="name" class="form-control" value={{old('name')}}>
                              </div>
                              <div id="main-container">
                                <div class="panel container-item">
                                    <div class="panel-body">
                                        <div class="panel-body">
                                            <div class="row shadow p-3 mb-5 bg-white rounded m-2 align-items-center">
                                                <div class="col-sm-4">
                                                  <div class="form-group">
                                                      <label class="control-label" for="address_line_two_0">Наз про</label>
                                                      <select class="form-control" name="product_id[]">
                                                        @foreach ($products as $product)
                                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                                        @endforeach
                                                      </select>
                                                  </div>
                                                </div>
                                                <div class="col-sm-3">
                                                  <div class="form-group">
                                                      <label class="control-label" for="address_line_two_0">Кол товар</label>
                                                      <input type="text" name="litr[]" required class="form-control">
                                                  </div>
                                                </div>
                                                <div class="col-sm-3">
                                                  <div class="form-group">
                                                      <label class="control-label" for="address_line_two_0">Кол про</label>
                                                      <input type="text" name="quantity[]" required class="form-control">
                                                  </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div>
                                                        <a href="javascript:void(0)" class="remove-item btn btn-sm remove-social-media rounded-circle border"><i class="fa fa-minus"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="row justify-content-center mb-4">
                                  <a class="btn btn-primary btn-sm col-10 " id="add-more" href="javascript:;" role="button"><i class="fa fa-plus"></i> Добавить ингридиенты</a>
                              </div>
                              <div class="form-group">
                                <span>Цена продажи</span>
                                <input type="number" required name="price" class="form-control" value={{old('price')}}>
                              </div>
                              <div class="form-group">
                                <span>Цена (Перечисления) продажи</span>
                                <input type="number" required name="kindergarden_price" class="form-control" value={{old('kindergarden_price')}}>
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
            {{-- @livewire('search-bread') --}}
          
        </div>
        <div class="card">
          <div class="card-block">
            <div class="row">
              <div class="col-lg-12 col-sm-6">
                  {{-- <input type="text" class="form-control mt-2" wire:model='search' placeholder="Поиск"> --}}
                  <input type="text" class="form-control mt-2" id="searchInput" onkeyup="searchTable()" placeholder="Поиск" style="width: 100%">
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
                              {{ $bread->name}}
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
                            {{-- {{number_format($bread->cost_price, 2, ',', ' ')}} сум --}}
                            <?php
                             $total=0;
                            if (auth()->user()->role_id==1) {
                              foreach ($bread->bread_product as $b_product){
                                  $total+=$b_product->product->price*($b_product->quantity/$b_product->milky_quan);
                              }
                            }
                              echo $total==0 ? '' : number_format($total).' сум';
                             ?>
                          </td>
                          <td class="d-flex justify-content-around">
                            {{-- <form action="{{route('breads.destroy',$bread->bread_product[0]->id)}}" method="post" class="mr-2">
                              @csrf
                              <button class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></button>
                            </form> --}}
                            <button type="button" class="btn btn-sm btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#UpdateBread<?php echo $bread->id ?>">
                              <i class="fa fa-edit"></i>
                            </button>
                            <a href="{{route('breads.show',$bread->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
                              
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
    </div>
</div>
@endsection

@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.3.2/select2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.js"></script>
    <script src="https://cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
    <script src="admin/js/pages/cloneDate.js" type="text/javascript"></script>
    <script src="admin/js/pages/cloneUpdate.js" type="text/javascript"></script>
      <script>
        $("form").submit(function () {
        $("#save").attr("disabled", true);
        });
      </script>
      <script>
        $('a#add-more').cloneData({
            mainContainerId: 'main-container', // Main container Should be ID
            cloneContainer: 'container-item', // Which you want to clone
            removeButtonClass: 'remove-item', // Remove button for remove cloned HTML
            removeConfirm: true, // default true confirm before delete clone item
            removeConfirmMessage: 'Are you sure want to delete?', // confirm delete message
            //append: '<a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media">Remove</a>', // Set extra HTML append to clone HTML
            minLimit: 1, // Default 1 set minimum clone HTML required
            maxLimit: 100, // Default unlimited or set maximum limit of clone HTML
            defaultRender: 1,
            init: function () {
                console.info(':: Initialize Plugin ::');
            },
            beforeRender: function () {
                console.info(':: Before rendered callback called');
            },
            afterRender: function () {
                console.info(':: After rendered callback called');
                

                //$(".selectpicker").selectpicker('refresh');
            },
            afterRemove: function () {
                console.warn(':: After remove callback called');
            },
            beforeRemove: function () {
                console.warn(':: Before remove callback called');
            }

        });

        $(document).ready(function () {
            $('.datepicker').datepicker();
        });
      </script>
      <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

      </script>

       <script>
        $('a#add-update').cloneDataUpdate({
            updateContainerId: 'update-container', // Main container Should be ID
            cloneUpdateContainer: 'container-item-update', // Which you want to clone
            removeButtonClassUpdate: 'remove-item-update', // Remove button for remove cloned HTML
            removeConfirm: true, // default true confirm before delete clone item
            removeConfirmMessage: 'Are you sure want to delete?', // confirm delete message
            //append: '<a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media">Remove</a>', // Set extra HTML append to clone HTML
            minLimit: 0, // Default 1 set minimum clone HTML required
            maxLimit: 100, // Default unlimited or set maximum limit of clone HTML
            defaultRender: 1,
            init: function () {
                console.info(':: Initialize Plugin ::');
            },
            beforeRender: function () {
                console.info(':: Before rendered callback called');
            },
            afterRender: function () {
                console.info(document.getElementsByClassName("product_id"));
                //$(".selectpicker").selectpicker('refresh');
            },
            afterRemove: function () {
                console.warn(':: After remove callback called');
            },
            beforeRemove: function () {
                console.warn(':: Before remove callback called');
            }

        });

        

      </script>
      <script>
        function getVa(bre,id,name,price,kindergarden_price,kpi){
            $('#bre').val(bre);
            $('#id').val(id);
            $('#name').val(name);
            $('#price').val(price);
            $('#kindergarden_price').val(kindergarden_price);
            $('#kpi').val(kpi);
        }

        
      </script>
      
      <script>
      async function getData (id) {
       const response = await fetch(`http://127.0.0.1:8000/store-two/${id}`)
        .then(response => response.json())
        .then(data => data.map(res => console.log(res.product_id)))
        .catch(error => console.log("qate"))
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
