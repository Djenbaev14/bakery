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
                    <div class="col-12"><h4>{{$user->username}}
                    </h4></div>
                  </div>
                  
                  {{-- <form action="{{route('report-warehouse')}}" method="GET">
                    <div class="row">
                      <div class="col-md-6 form-group">
                          <input type="date" name="start_date" required class="form-control" value="{{ $start_date }}">
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="date" name="end_date" required class="form-control" value="{{ $end_date }}">
                        </div>
                        <div class="col-md-2 form-group" >
                          <input type="submit" class="btn btn-sm btn-primary" value="Фильтр">
                        </div>
                    </div>
                  </form> --}}
                </div>
              </div>
          </div>
      </div>
  </div>
    <div class="row">
          <div class="col-sm-12">
              <div class="card">
                  <div class="card-block" style="overflow: auto">
                    <h5>Приход</h5>

                    @if ($user->role_id==3)
                      <table class="table table-sm table-bordered table-striped table-hover mt-4">
                          <thead>
                              <tr>
                                  <th>
                                      Количество
                                  </th>
                                  <th>
                                    КПИ
                                  </th>
                                  <th>
                                    Приход
                                  </th>
                                  <th>
                                    Добавлено
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                              @forelse ($coming as $com)
                                <tr>
                                    <td class="align-middle">
                                      {{$com->quantity}}
                                    </td>
                                    <td class="align-middle">
                                      {{$com->delivery_kpi}} сум
                                    </td>
                                    <td class="align-middle">
                                      {{number_format($com->quantity * $com->delivery_kpi)}} сум
                                    </td>
                                    <td class="align-middle">
                                      {{\Carbon\Carbon::parse($com->created_at)->format('d M Y H:i:s')}}
                                    </td>
                                </tr>
                              @empty
                              <tr>
                                  <td colspan="10" class="text-center">
                                      <h2>Добавлено нет</h2>
                                  </td>
                              </tr>
                              @endforelse
                          </tbody>
                      </table>
                      <div class="row m-1">
                        <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Общий итог: {{number_format($coming->sum(function($t){return $t->delivery_kpi * $t->quantity;}))}} сум</span>
                        <span class="bg-primary bg-gradient rounded text-light pr-1 pl-1 ml-2">Общий  кол: {{number_format($coming->sum('quantity'))}}</span>
                      </div>
                      <span class="d-flex justify-content-end">{{$coming->links('pagination::bootstrap-4')}}</span>
                    @elseif($user->role_id==4)
                      <table class="table table-sm table-bordered table-striped table-hover mt-4">
                          <thead>
                              <tr>
                                  <th>
                                      Количество
                                  </th>
                                  <th>
                                    КПИ
                                  </th>
                                  <th>
                                    Приход
                                  </th>
                                  <th>
                                    Добавлено
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                              @forelse ($coming as $com)
                                <tr>
                                    <td class="align-middle">
                                      {{$com->quantity}}
                                    </td>
                                    <td class="align-middle">
                                      {{$com->worker_kpi}} сум
                                    </td>
                                    <td class="align-middle">
                                      {{number_format($com->quantity * $com->worker_kpi)}} сум
                                    </td>
                                    <td class="align-middle">
                                      {{\Carbon\Carbon::parse($com->created_at)->format('d M Y H:i:s')}}
                                    </td>
                                </tr>
                              @empty
                              <tr>
                                  <td colspan="10" class="text-center">
                                      <h2>Добавлено нет</h2>
                                  </td>
                              </tr>
                              @endforelse
                          </tbody>
                      </table>
                      <div class="row m-1">
                        <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Общий итог: {{number_format($coming->sum(function($t){return $t->worker_kpi * $t->quantity;}))}} сум</span>
                        <span class="bg-primary bg-gradient rounded text-light pr-1 pl-1 ml-2">Общий  кол: {{number_format($coming->sum('quantity'))}}</span>
                      </div>
                      <span class="d-flex justify-content-end">{{$coming->links('pagination::bootstrap-4')}}</span>
                    @elseif($user->role_id==2)
                      <table class="table table-sm table-bordered table-striped table-hover mt-4">
                          <thead>
                              <tr>
                                  <th>
                                      Количество
                                  </th>
                                  <th>
                                    КПИ
                                  </th>
                                  <th>
                                    Приход
                                  </th>
                                  <th>
                                    Добавлено
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                              @forelse ($coming as $com)
                                <tr>
                                  <td class="align-middle">
                                    {{$com->quantity}}
                                  </td>
                                  <td class="align-middle">
                                    {{$com->seller_kpi}} сум
                                  </td>
                                  <td class="align-middle">
                                    {{number_format($com->quantity * $com->seller_kpi)}} сум
                                  </td>
                                  <td class="align-middle">
                                    {{\Carbon\Carbon::parse($com->created_at)->format('d M Y H:i:s')}}
                                  </td>
                                </tr>
                              @empty
                              <tr>
                                  <td colspan="10" class="text-center">
                                      <h2>Добавлено нет</h2>
                                  </td>
                              </tr>
                              @endforelse
                          </tbody>
                      </table>
                      <div class="row m-1">
                        <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Общий итог: {{number_format($coming->sum(function($t){return $t->seller_kpi * $t->quantity;}))}} сум</span>
                        <span class="bg-primary bg-gradient rounded text-light pr-1 pl-1 ml-2">Общий  кол: {{number_format($coming->sum('quantity'))}}</span>
                      </div>
                      <span class="d-flex justify-content-end">{{$coming->links('pagination::bootstrap-4')}}</span>
                    @endif
                  </div>
              
              </div>
          </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block" style="overflow: auto">
                  <h5>Расход</h5>
                    <table class="table table-sm table-bordered table-striped table-hover mt-4">
                        <thead>
                            <tr>
                                <th>
                                  Имя
                                <th>
                                  Добавил
                                </th>
                                <th>
                                  Расход
                                </th>
                                <th>
                                  Добавлено
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenditure_salaries as $salary)
                            <tr>
                              <td class="align-middle">
                                {{$salary->expenditure->user->username}}
                              </td>
                              <td class="align-middle">
                                {{$salary->user->username}}
                              </td>
                              <td class="align-middle">
                                {{number_format($salary->expenditure->price)}} сум
                              </td>
                              <td class="align-middle">
                                {{\Carbon\Carbon::parse($salary->created_at)->format('d M Y H:i:s')}}
                              </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h2>Расход нет</h2>
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row m-1">
                        <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Общий  итог: {{number_format(expenditure_salary($user))}} сум</span>
                    </div>
                    <span class="d-flex justify-content-end">{{$expenditure_salaries->links('pagination::bootstrap-4')}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
          <div class="card">
              <div class="card-block" style="overflow: auto">
                <h5>Штраф</h5>
                  <table class="table table-sm table-bordered table-striped table-hover mt-4">
                      <thead>
                          <tr>
                              <th>
                                Причина штрафа
                              </th>
                              <th>
                                ШТРАФ СУММА
                              </th>
                              <th>
                                Добавлено
                              </th>
                          </tr>
                      </thead>
                      <tbody>
                          @forelse ($fines as $fine)
                          <tr>
                            <td class="align-middle">
                              {{$fine->comment}}
                            </td>
                            <td class="align-middle">
                              {{number_format($fine->price)}} сум
                            </td>
                            <td class="align-middle">
                              {{\Carbon\Carbon::parse($fine->created_at)->format('d M Y H:i:s')}}
                            </td>
                          </tr>
                          @empty
                          <tr>
                              <td colspan="10" class="text-center">
                                  <h2>Штраф нет</h2>
                              </td>
                          @endforelse
                      </tbody>
                  </table>
                  <div class="row m-1">
                      <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Общий  итог: {{number_format($fines->sum('price'))}} сум</span>
                  </div>
                  <span class="d-flex justify-content-end">{{$expenditure_salaries->links('pagination::bootstrap-4')}}</span>
              </div>
          </div>
      </div>
  </div>
@endsection

