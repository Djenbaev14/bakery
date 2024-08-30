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
                  <h4 class="col-lg-3 col-sm-12"> Расход
                  </h4>
                  @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                  <div class="col-lg-4 col-sm-6">
                      <button class="btn btn-sm btn-primary mr-2 mb-1" data-bs-toggle="modal" data-bs-target="#myModal1">Добавить тип расход</button>
                    @endif
                    <button class="btn btn-sm btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#myModal2">Добавить расход</button>
                  </div>
                  <div class="modal fade" id="myModal1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                  
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Расход тип
                          </h4>
                          <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                        </div>
                        <div class="container mt-3 mb-3">
                          <form action="{{route('expenditure_type.create')}}" method="POST">
                            @csrf
                            <div class="form-group">
                              <span>Расход название типа</span>
                              <input type="text" required name="name" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary" id="save">Добавить</button>
                          </form>
                        </div>
                  
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="myModal2">
                    <div class="modal-dialog">
                      <div class="modal-content">
                  
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Расход
                          </h4>
                          <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                        </div>
                        <div class="container mt-3 mb-3">
                          <form action="{{route('expenditure.create')}}" method="POST">
                            @csrf
                            <div class="form-group">
                              <span>Тип</span>
                              <select name="expenditure_type_id" id="expenditure_type" class="form-control">
                                <option hidden>Все расход</option>
                                @foreach ($expenditure_type as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group user_salery" style="display: none">
                              <span>Пользователь</span>
                              <select name="user_id" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->username}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group">
                              <span>Сумма денег</span>
                              <input type="number" required name="price" class="form-control" value={{old('price')}}>
                            </div>
                            <div class="form-group">
                              <span>Комментария</span>
                              <textarea name="comment" class="form-control"></textarea>
                            </div>
                            <input type="date" name="created_at" id="datetime" name="datetime" value="{{date('Y-m-d')}}"><br><br> 
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
    </div>
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="card-block">
            <form action="{{route('expenditure.index')}}" method="GET">
              <div class="row">
                <div class="col-md-6 form-group">
                    <input type="date" name="start_date" required class="form-control pl-2 pr-2" value="{{ $start_date }}">
                  </div>
                  <div class="col-md-6 form-group">
                    <input type="date" name="end_date" required class="form-control pl-2 pr-2" value="{{ $end_date }}">
                  </div>
                  <div class="col-md-3 form-group">
                    <select name="user_id" class="form-control selectpicker">
                      @if (auth()->user()->role_id==1 && auth()->user()->role_id==2)
                        <option hidden>Все</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}" <?=$user->id == $user_id ? 'selected' : '';?>>{{$user->username}}</option>
                        @endforeach
                      @endif
                      <option value="{{auth()->user()->id}}" selected>{{auth()->user()->username}}</option>
                    </select>
                  </div>  
                  <div class="col-md-2 form-group" >
                    <input type="submit" class="btn btn-sm btn-primary" value="Фильтр">
                  </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-block" style="overflow: auto">
          {{-- <livewire:expenditures-table/> --}}
          <table class="table table-sm table-bordered table-striped table-hover">
              <thead>
                  <tr>
                    <th>
                      Пользователь
                    </th>
                    <th>
                      Маъсул
                    </th>
                      <th>
                          Тип
                      </th>
                      <th>
                          Комментария
                      </th>
                      <th>
                          Сумма
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
                  @forelse ($expenditures as $expenditure)
                  <tr>
                    <td class="align-middle">
                        @if (count($expenditure->expenditure_salary) > 0)
                          {{ $expenditure->expenditure_salary->first()->user->username}}
                        @else
                          <span class="border border-info pl-1 pr-1 rounded text-info">none</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        {{ $expenditure->user->username}}
                    </td>
                      <td class="align-middle">
                        {{$expenditure->expenditure_type->name}}
                      </td>
                      <td class="align-middle">
                        {{ $expenditure->comment }}
                      </td>
                      <td class="align-middle">
                        {{number_format($expenditure->price)}} сум
                      </td>
                      <td class="align-middle">
                        {{\Carbon\Carbon::parse($expenditure->created_at)->format('d M Y H:i:s')}}
                      </td>
                      <td class="d-flex justify-content-around">
                        <a href="{{route('expenditure.delete',$expenditure->id)}}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fa fa-trash"></i></a>
                      </td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="8" class="text-center">
                          <h2>Расходы нет</h2>
                      </td>
                  @endforelse
              </tbody>
          </table>
          <div class="">
              <span class="bg-info bg-gradient rounded text-light pr-1 pl-1 mb-1">Итого: {{number_format($expenditures->sum('price'))}} сум</span>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection


@push('js')
  <script>
    $(document).ready(function () {
    $('.selectpicker').selectize({
        sortField: 'text'
    });
    });
  </script>
  <script>
    document.querySelector('#expenditure_type').addEventListener('change', () => {
      const select_value = document.querySelector('#expenditure_type').value
      console.log(select_value);
      if (select_value === "1") {
        document.querySelector('.user_salery').style.display = 'block';
      } else {
        document.querySelector('.user_salery').style.display = 'none';
      }
    })
  </script>
@endpush

