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
                    <h4>Продажа
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
                <div class="card-block" style="overflow: auto">
                    <table class="table table-sm table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                {{-- <th>
                                    №	
                                </th> --}}
                                <th>
                                    Имя доставщика	
                                </th>
                                <th>
                                    Рол	
                                </th>
                                {{-- <th>
                                    Итого
                                </th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($delivery as $admin)
                            <tr>
                                {{-- <td class="align-middle">
                                    {{ ($delivery ->currentpage()-1) * $delivery ->perpage() + $loop->index + 1 }}
                                </td> --}}
                                <td class="align-middle">
                                  <a href="{{route('history-admin',$admin->id)}}">{{$admin->username}}</a> <span class="bg-primary text-light rounded-circle pl-1 pr-1"> {{$admin->payment_history->where('status','0')->count()}}</span>
                                </td>
                                <td class="align-middle">
                                  {{$admin->role->r_name}}
                                </td>
                                {{-- <td class="align-middle">
                                    {{number_format($admin->payment_history->sum('paid'))}} сум
                                </td> --}}
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h2>Клента нет</h2>
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row m-1">
                        {{-- <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Общая итог: {{number_format($total_amount)}} сум</span> --}}
                    </div>
                </div>
            
                <span class="d-flex justify-content-end">{{$delivery->links('pagination::bootstrap-4')}}</span>
            </div>
        </div>
    </div>
@endsection

