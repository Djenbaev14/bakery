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
                  <h4>Заработная плата рабочих
                  </h4>
                </div>
              </div>
            </div>
            <div class="card-block">
              <form action="{{route('users_salary.index')}}" method="GET">
                <div class="row">
                  <div class="col-md-6 form-group">
                      <input type="date" name="start_date" value="{{$start_date}}"  required class="form-control pr-2 pl-2" >
                    </div>
                    <div class="col-md-6 form-group">
                      <input type="date" name="end_date" value="{{$end_date}}" required class="form-control pr-2 pl-2" >
                    </div>
                    <div class="col-md-2 form-group" >
                      <input type="submit" class="btn btn-sm btn-primary" value="Фильтр">
                    </div>
                </div>
              </form>
            </div>
            <div class="card-block" style="overflow: auto">
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
                              Баланстан кайтарыу
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td class="align-middle">
                                <a href="{{route('users_salary.show',$user->id)}}">{{ $user->username}}</a>
                            </td>
                            <td class="align-middle">
                              {{ number_format($user->user_salary->sum('summa')-$user->expenditure->sum('price')) }} сум
                            </td>
                            <td class="align-middle">
                              <button type="button" class="btn btn-sm btn-danger ml-2" data-bs-toggle="modal" data-bs-target="#balancEdit<?php echo $user->id ?>">
                                <i class="fa fa-minus"></i>
                              </button>

                              
                      <!-- The Modal -->
                      <div class="modal fade" id="balancEdit<?php echo  $user->id ?>">
                        <div class="modal-dialog">
                          <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Баланстан кайтарыу
                              </h4>
                            </div>
                            <div class="container mt-3 mb-3">
                              <form method="POST" action="{{route('users_salary.expenditure')}}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <div class="form-group">
                                  <label class="form-check-label" for="exampleCheck1">Сумма:</label>
                                  <input type="number" name="summa" max="{{$user->user_salary->sum('summa')-$user->expenditure->sum('price')}}" class="form-control" id="exampleCheck1">
                                </div>
                                <button type="submit" class="btn btn-primary">Сохранить</button>
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
                                <h2>Нет рабочих</h2>
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
@endpush

