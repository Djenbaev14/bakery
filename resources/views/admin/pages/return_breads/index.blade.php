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
                  <h4>Страница возвращенных продуктов</h4>
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
            <form action="{{route('return_bread.index')}}" method="GET">
              <div class="row">
                <div class="col-md-6 form-group">
                    <input type="date" name="start_date" value="{{$start_date}}"  required class="form-control pl-2 pr-2" >
                  </div>
                  <div class="col-md-6 form-group">
                    <input type="date" name="end_date" value="{{$end_date}}" required class="form-control pl-2 pr-2" >
                  </div>
                  <div class="col-md-2 form-group" >
                    <input type="submit" class="btn btn-sm btn-primary" value="Фильтр">
                  </div>
              </div>
            </form>
          </div>
          <div class="card-block" style="overflow: auto">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>
                          Добавил
                        </th>
                        <th>
                          Клиент
                        </th>
                        <th>
                          Название продукта
                        </th>
                        <th>
                          Количество
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
                    @forelse ($products as $product)
                    <tr class="<?=($product->status==1) ? "bg-primary text-light" : "";?>">
                        <td class="align-middle">
                            {{ $product->user->username}}
                        </td>
                        <td class="align-middle">
                          {{ $product->client->name }}
                        </td>
                        <td class="align-middle">
                          {{ $product->sale_item->bread->name }}
                        </td>
                        <td class="align-middle">
                          {{$product->quantity}}
                        </td>
                        <td class="align-middle">
                          {{\Carbon\Carbon::parse($product->created_at)->format('d M Y H:i:s')}}
                        </td>
                        <td class="d-flex justify-content-center">
                          @if ($product->status == 1)
                          <span>Принят</span>
                          @else
                            <form action="{{route('return_bread.reception',$product->id)}}" method="post" class="mr-2">
                              @csrf
                              <button class="btn btn-primary btn-sm"> <i class="fa fa-check"></i></button>
                            </form>
                          @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <h2>Нет возвращенных продуктов</h2>
                        </td>
                    @endforelse
                </tbody>
            </table>
          </div>
          <span class="d-flex justify-content-end">{{$products->links()}}</span>
        </div>
    </div>
</div>


@endsection
@push('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
@endpush

