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
                  <h4>{{$bread->name}}
                  </h4>
                </div>
              </div>
            </div>
            <div class="card-block">
                <form action="{{route('breads.show',$bread->id)}}" method="GET">
                  <div class="row">
                    <div class="col-md-6 form-group">
                        <input type="date" name="start_date" value="{{$start_date}}"  required class="form-control" >
                      </div>
                      <div class="col-md-6 form-group">
                        <input type="date" name="end_date" value="{{$end_date}}" required class="form-control" >
                      </div>
                      <div class="col-md-2 form-group" >
                        <input type="submit" class="btn btn-sm btn-primary" value="Фильтр">
                      </div>
                  </div>
                </form>
              </div>
              
            {{-- @livewire('show-bread',['bread'=>$bread,'start_date'=>$start_date,'end_date'=>$end_date]) --}}
        </div>
        <div class="card">
          <div class="card-block">
            
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Производство</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Продано</button>
              </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="card-block" style="overflow: auto">
                    <span class="bg-outline-primary bg-gradient border border-primary text-primary pr-1 pl-1">Итого количество: {{$coming_bread->sum('quantity')}}</span><br><br> 
                    <table class="table table-sm table-sm table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                  Ответственный
                                </th>
                                <th>
                                  Количество
                                </th>
                                <th>
                                    Себе стоимость
                                </th>
                                <th>
                                    Сумма
                                </th>
                                <th>
                                    Дата создания
                                </th>
                                <th>
                                    Действия
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($coming_bread as $bread)
                            <tr>
                                <td class="align-middle">
                                    {{ $bread->responsible->username}}
                                </td>
                                <td class="align-middle">
                                  {{$bread->quantity}}
                                </td>
                                <td class="align-middle">
                                  {{ number_format($bread->cost_price) }} сум
                                </td>
                                <td class="align-middle">
                                  {{ number_format($bread->cost_price * $bread->quantity) }} сум
                                </td>
                                <td class="align-middle">
                                  {{\Carbon\Carbon::parse($bread->created_at)->format('d M Y H:i:s')}}
                                </td>
                                <td class="d-flex justify-content-center">
                                  <form action="" method="post">
                                    <button class="btn btn-danger btn-sm" <?=(auth()->user()->role_id==2) ? "" : "disabled"?>><i class="fa fa-trash"></i></button>
                                  </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <h2>Поступления нет</h2>
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
              </div>
              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="card-block" style="overflow: auto">
                    <span class="bg-outline-primary bg-gradient border border-primary text-primary pr-1 pl-1">Итого количество: {{$expenditure_bread->sum('quantity')}}</span><br><br>
                    <table class="table table-sm table-bordered table-striped table-hover">
                      <thead>
                          <tr>
                            @foreach ($sellers as $seller)
                                <th>{{$seller->username}}</th>
                            @endforeach
                          </tr>
                      </thead>
                      <tbody>
                        <tr>
                          @foreach ($sellers as $seller)
                            <td>{{$seller->sale->sum('quantity')}}</td>  
                          @endforeach
                        </tr>
                      </tbody>
                    </table>
                    {{-- <span class="d-flex justify-content-end">{{$expenditure_bread->links('pagination::bootstrap-4')}}</span> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush