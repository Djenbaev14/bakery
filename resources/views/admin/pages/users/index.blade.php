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
                  <h4 class="col-4">Управление пользователями
                  </h4>
                  <button class="col-2 btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal1">Добавить</button>
                    <!-- The Modal -->
                    <div class="modal fade" id="myModal1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                    
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Регистрация
                            </h4>
                            <button type="button" class="btn bordered btn-sm" data-bs-dismiss="modal"><i class="fa fa-window-close" ></i></button>
                          </div>
                          <div class="container mt-3 mb-3">
                            <form action="{{route('users.create')}}" method="POST">
                              @csrf
                              <div class="form-group">
                                <span>Имя</span>
                                <input type="text" name="username" required class="form-control" value={{old('username')}}>
                              </div>
                              <div class="form-group">
                                <span>Телефон номер</span>
                                <input type="text" name="phone" required class="form-control" value={{old('phone')}}>
                              </div>
                              <div class="form-group">
                                <span>Парол</span>
                                <input type="text" name="password" required class="form-control" value={{old('password')}}>
                              </div>
                              <div class="form-group">
                                <span >КПИ</span>
                                <input type="number" name="KPI" required min="0" class="form-control" value={{old('KPI')}}>
                              </div>
                              <div class="form-group">
                                <span>Роли</span>
                                <select class="form-control" name="role_id" aria-label="Default select example">
                                  @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->r_name}}</option>
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
            <div class="card-block" style="overflow: auto">
              {{-- <livewire:power-grid-table/> --}}
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                              №
                            </th>
                            <th>
                              Имя
                            </th>
                            <th>
                              Тип
                            </th>
                            <th>
                              Телефон номер
                            </th>
                            <th>
                              Обновлено
                            </th>
                            <th>
                              Создано
                            </th>
                            <th>
                              Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td class="align-middle">
                                {{ ($users ->currentpage()-1) * $users ->perpage() + $loop->index + 1 }}
                            </td>
                            <td class="align-middle">
                                {{ $user->username}}
                            </td>
                            <td class="align-middle">
                                <span class="rounded text-info border border-info p-1">{{ $user->r_name }}</span>
                            </td>
                            <td class="align-middle">
                              {{$user->phone}}
                            </td>
                            <td class="align-middle">
                              {{\Carbon\Carbon::parse($user->updated_at)->format('d M Y H:i:s')}}
                            </td>
                            <td class="align-middle">
                              {{\Carbon\Carbon::parse($user->created_at)->format('d M Y H:i:s')}}
                            </td>
                            <td class="align-middle <?=($user->role_id==1 && auth()->user()->role_id !=1) ? "d-none" : "d-flex justify-content-start align-items-center";?>" >
                              <a href="{{route('users.edit',$user->id)}}" class="btn btn-sm btn-primary mr-2"><i class="fa fa-edit"></i></a>
                              <form action="{{route('user.key',$user->id)}}" method="post" class="ml-2">
                                @csrf
                                <button class="btn btn-sm btn-success" ><i class="fa fa-key"></i></button>
                              </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <h2>Новостей нет</h2>
                            </td>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <span class="d-flex justify-content-end">{{$users->links()}}</span>
        </div>
    </div>

</div>
@endsection


@push('js')
    <script>
      function getValues(user_id,name,phone, kpi) {
        $('#phone').val(phone);
        $('#name').val(name);
        $('#kpi').val(kpi);
        $('#user_id').val(user_id);
      }
    </script>
@endpush

