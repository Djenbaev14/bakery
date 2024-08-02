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
                    <h4>Баланс
                    </h4>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
  <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <table class="table table-sm table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    Имя 	
                                </th>
                                <th>
                                  Баланс	
                                </th>
                                <th>
                                    КПИ
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td class="align-middle">
                                  <a href="{{route('report-balance-show',$user->id)}}">{{$user->username}}</a>
                                </td>
                                <td class="align-middle">
                                  {{number_format(user_balance($user))}} сум 
                                </td>
                                <td class="align-middle">
                                  {{$user->KPI}} сум
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h2>Пользовател нет</h2>
                                </td>
                            @endforelse
                        </tbody>
                    </table>  
                </div>
            
            </div>
        </div>
    </div>
@endsection

