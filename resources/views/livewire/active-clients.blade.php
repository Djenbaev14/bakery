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
{{-- @livewire('active-clients') --}}

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
              <div class="container">
                <div class="row justify-content-between align-items-center">
                  <h4>Актив клиенты
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
                <h5>Основной</h5>
                <table class="table table-sm table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                Имя клиента	
                            </th>
                            <th>
                                Телефон номер	
                            </th>
                            <th>
                                Общий объем продаж
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                        <tr>
                            <td class="align-middle">
                              {{$client->client_name}}
                            </td>
                            <td class="align-middle">
                              {{$client->client_phone}}
                            </td>
                            <td class="align-middle">
                              {{number_format($client->total_amount)}} сум
                            </td>
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
                    <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Итого: {{number_format($summa)}} сум</span>
                </div>
            </div>
        
            <span class="d-flex justify-content-end">{{$clients->links('pagination::bootstrap-4')}}</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-block">
                <h5 >Перечисления</h5>
                <table class="table table-sm table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                Имя клиента	
                            </th>
                            <th>
                                Телефон номер	
                            </th>
                            <th>
                                Общий объем продаж
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kindergarden as $kinder)
                        <tr>
                            <td class="align-middle">
                              {{$kinder->client_name}}
                            </td>
                            <td class="align-middle">
                              {{$kinder->client_phone}}
                            </td>
                            <td class="align-middle">
                              {{number_format($kinder->total_amount)}} сум
                            </td>
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
                    <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">Итого: {{number_format($kindergarden_summa)}} сум</span>
                </div>
            </div>
        
            <span class="d-flex justify-content-end">{{$clients->links('pagination::bootstrap-4')}}</span>
        </div>
    </div>
</div>
@endsection

