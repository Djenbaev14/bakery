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
                  <h4 class="col-lg-3 col-sm-12 ">Клиенты
                  </h4>
                  <button class="col-lg-2 col-sm-12 btn btn-primary" data-bs-toggle="modal" data-bs-target="#myClient">Добавить</button>
                    <!-- The Modal -->
                    <div class="modal fade" id="myClient">
                      <div class="modal-dialog">
                        <div class="modal-content">
                    
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Создать клиента
                            </h4>
                            <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                          </div>
                          <div class="container mt-3 mb-3">
                            <form action="{{route('clients.create')}}" method="POST">
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
                                <span>Комментария</span>
                                <textarea name="comment" class="form-control" value={{old('comment')}}></textarea>
                              </div> 
                              <div class="form-group">
                                <input type="checkbox" name="kindergarden" value="1">
                                <span>Перечисления</span>
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
            {{-- @livewire('search-client') --}}
        </div>
        <div class="card">
          <div class="card-block">
            <div class="row">
              <div class="col-lg-12 col-sm-6">
                  {{-- <input type="text" class="form-control mt-2" wire:model='search' placeholder="Поиск клиентов"> --}}
                  <input type="text" class="form-control mt-2" id="searchInput" onkeyup="searchTable()" placeholder="Поиск клиентов" style="width: 100%">
              </div>
            </div>
          </div>
          <div class="card-block" style="overflow: auto">
              <table id="myTable" class="table table-sm table-striped table-hover">
                  <thead class="table-bordered">
                      <tr>
                          <th>
                            Имя
                          </th>
                          <th>
                            Добавил
                          </th>
                          <th>
                            Номер телефона
                          </th>
                          <th>
                            Действия
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($clients as $client)
                      <tr>
                          <td class="align-middle">
                              {{ $client->name}}
                          </td>
                          <td class="align-middle">
                              {{ $client->user->username}}
                          </td>
                          <td class="align-middle">
                            {{$client->phone}}
                          </td>
                          <td class="d-flex justify-content-start"> 
                            <button type="button" class="btn btn-sm btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#clientUpdate" onclick="getClientUpdate('{{$client->id}}','{{$client->name}}','{{$client->phone}}','{{$client->comment}}','{{$client->kindergarden}}')">
                              <i class="fa fa-edit"></i>
                            </button>
                            <a href="{{route('clients.show',$client->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
                          </td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="8" class="text-center">
                              <h2>Клиенты нет</h2>
                          </td>
                      @endforelse
                  </tbody>
              </table>
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
            <form action="{{route('clients.update')}}" method="POST">
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
              <div class="form-group">
                <input type="checkbox" name="kindergarden" id="kindergarden">
                <span>Перечисления</span>
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


@push('js')
      <script>
        function getClientUpdate(id,name,phone,comment,kindergarden){
            $('#id').val(id);
            $('#name').val(name);
            $('#phone').val(phone);
            if(kindergarden == 1){
              $('#kindergarden').prop("checked", true)
            }else{
              $('#kindergarden').prop("checked", false)
            }
            $('#comment').val(comment);
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

