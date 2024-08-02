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
                  <h4 class="col-4">Управление пользователями
                  </h4>
                </div>
              </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 mt-3 mb-3">
      <div class="card p-3">
        <form action="{{route('users.update',$user->id)}}" method="POST">
          @csrf
          <div class="form-group">
            <span>Имя</span>
            <input type="text" name="username" value="{{$user->username}}" class="form-control">
          </div>
          <div class="form-group">
            <span>Телефон номер</span>
            <input type="text" name="phone" value="{{$user->phone}}" class="form-control">
          </div>
          <div class="form-group">
            <span >КПИ</span>
            <input type="number" name="KPI" value="{{$user->KPI}}" min="0" class="form-control">
          </div>
            {{-- <div class="form-group">
              <span>Текущий пароль</span>
              <input type="text" name="current_password" class="form-control">
            </div>
            <div class="form-group">
              <span>Новый пароль</span>
              <input type="text" name="new_password" class="form-control">
            </div> --}}
          <button type="submit" class="btn btn-primary" id="save2">Изменить</button>
        </form>
      </div>
    </div>
</div>
@endsection


