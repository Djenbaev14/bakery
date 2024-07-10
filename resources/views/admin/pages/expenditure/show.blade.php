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
                  <h4> Расход {{$user->username}}
                  </h4>
              </div>
            </div>
            <div class="card-block">
              <form action="{{route('expenditure.show',$user->id)}}" method="GET">
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
            <div class="card-block" style="overflow: auto">
              <table class="table table-sm table-bordered table-striped table-hover">
                  <thead>
                      <tr>
                          <th>
                              №
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
                              {{ ($expenditures ->currentpage()-1) * $expenditures ->perpage() + $loop->index + 1 }}
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
                            <form action="{{route('expenditure.destroy',$expenditure->id)}}" method="post">
                              @csrf
                              <button class="btn btn-outline-danger btn-sm"> <i class="fa fa-trash"></i></button>
                            </form>
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
                
                {{-- <span class="bg-success bg-gradient rounded text-light pr-1 pl-1 mr-4 mb-1">{{$ex[0]->role_name}} расход: {{number_format($price)}} сум</span> --}}
                  <span class="bg-info bg-gradient rounded text-light pr-1 pl-1 mb-1">Итого: {{number_format($expenditures->sum('price'))}} сум</span>
              </div>
            </div>
            <span class="d-flex justify-content-end">{{$expenditures->links('pagination::bootstrap-4')}}</span>
        </div>
    </div>
</div>
@endsection


@push('js')
@endpush

