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
                  <h4 class="col-lg-3 col-sm-12"> Штраф
                  </h4>
                  <div class="col-lg-2 col-sm-12">
                    <button class="btn btn-sm btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#myModal2">Добавить</button>
                  </div>
                  <div class="modal fade" id="myModal2">
                    <div class="modal-dialog">
                      <div class="modal-content">
                  
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Штраф
                          </h4>
                          <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                        </div>
                        <div class="container mt-3 mb-3">
                          <form action="{{route('fines.create')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                              <span>Пользователь</span>
                              <select name="user_id" class="form-control selectpicker">
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->username}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group">
                              <span>Сумма</span>
                              <input type="number" required name="price" class="form-control rounded" style="border: 1px solid #ccc;padding:6px 12px;" value={{old('price')}}>
                            </div>
                            <div class="form-group">
                              <span>Причина штрафа</span>
                              <textarea name="comment" class="form-control rounded" style="border: 1px solid #ccc;padding:6px 12px;"></textarea>
                            </div>
                            <div class="mb-3">
                              <label for="formFile" class="form-label">Загрузите фото</label>
                              <input class="form-control" type="file" id="formFile" name="image">
                            </div>
                            <input type="date" name="created_at" id="datetime" name="datetime" value="{{date('Y-m-d')}}"><br><br> 
                            <button type="submit" class="btn btn-primary " id="save">Добавить</button>
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
          <div class="card-body">
            <div class="card-block">
              <form action="{{route('fines.index')}}" method="GET">
                <div class="row">
                  <div class="col-md-6 form-group">
                      <input type="date" name="start_date" required class="form-control pl-2 pr-2" value="{{ $start_date }}">
                    </div>
                    <div class="col-md-6 form-group">
                      <input type="date" name="end_date" required class="form-control pl-2 pr-2" value="{{ $end_date }}">
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
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Штраф</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Ожидание</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-sm table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                          <th>
                            Имя
                          </th>
                          <th>
                            Штраф Сумма
                          </th>
                          <th>
                              Комментария
                          </th>
                          <th>
                              Файл
                          </th>
                            <th>
                                Время
                            </th>
                            {{-- <th>
                              Действия
                            </th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fines as $fine)
                        <tr>
                          <td class="align-middle">
                              {{ $fine->user->username}}
                          </td>
                            <td class="align-middle">
                              {{number_format($fine->price)}} сум
                            </td>
                            <td class="align-middle">
                              {{ $fine->comment }}
                            </td>
                            <td class="align-middle">
                              <img src="{{asset('admin/fines/'.$fine->image)}}" width="100px">
                            </td>
                            <td class="align-middle">
                              {{\Carbon\Carbon::parse($fine->created_at)->format('d M Y H:i:s')}}
                            </td>
                            {{-- <td class="align-middle">
                              <a href="" class="btn btn-success btn-sm" data-confirm-delete="true"><i class="fa fa-check"></i></a>
                              <a href="{{route('fines.destroy',$fine->id)}}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fa fa-trash"></i></a>
                            </td> --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <h2>Штраф нет</h2>
                            </td>
                        @endforelse
                    </tbody>
                </table>
              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table table-sm table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                          <th>
                            Имя
                          </th>
                          <th>
                            Штраф Сумма
                          </th>
                          <th>
                              Комментария
                          </th>
                          <th>
                              Файл
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
                        @forelse ($fines_expectation as $fine)
                        <tr>
                          <td class="align-middle">
                              {{ $fine->user->username}}
                          </td>
                            <td class="align-middle">
                              {{number_format($fine->price)}} сум
                            </td>
                            <td class="align-middle">
                              {{ $fine->comment }}
                            </td>
                            <td class="align-middle">
                              <img src="{{asset('admin/fines/'.$fine->image)}}" width="100px">
                            </td>
                            <td class="align-middle">
                              {{\Carbon\Carbon::parse($fine->created_at)->format('d M Y H:i:s')}}
                            </td>
                            <td class="align-middle">
                              <a href="{{route('fines.check',$fine->id)}}" class="btn btn-success btn-sm" data-confirm-delete="true"><i class="fa fa-check"></i></a>
                              <a href="{{route('fines.destroy',$fine->id)}}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <h2>Штраф нет</h2>
                            </td>
                        @endforelse
                    </tbody>
                </table>
              </div>
            </div>
            <div class="">
                {{-- <span class="bg-info bg-gradient rounded text-light pr-1 pl-1 mb-1">Итого: {{number_format($expenditures->sum('price'))}} сум</span> --}}
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
@endpush

