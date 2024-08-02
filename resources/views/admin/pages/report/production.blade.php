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
                    <h4>Производство
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
                                  название продукта
                                </th>
                                <th>
                                    Количество(кг)
                                </th>
                                <th>
                                  Итого
                                </th>
                                <th>
                                  Обновлено
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($breads as $bread)
                            <tr>
                                <td class="align-middle">
                                  {{$bread->bread_name}}
                                </td>
                                <td class="align-middle">
                                  {{number_format($bread->total_quantity)}}
                                </td>
                                <td class="align-middle">
                                  {{number_format($bread->total_amount)}} сум
                                </td>
                                <td class="align-middle">
                                  {{$bread->updated_at}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h2>Производство нет</h2>
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row m-1">
                        <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Общая итог: {{number_format($total_amount[0]->total_amount)}} сум</span>
                    </div>
                </div>
            
                {{-- <span class="d-flex justify-content-end">{{$clients->links('pagination::bootstrap-4')}}</span> --}}
            </div>
        </div>
    </div>
@endsection

