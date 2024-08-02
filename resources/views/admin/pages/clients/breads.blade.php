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
                  <h4 class="col-lg-3 col-sm-12 ">Клиенты
                  </h4>
                </div>
              </div>
            </div>
            {{-- @livewire('search-client') --}}
        </div>
        <div class="card">
          <div class="card-body">
            <div class="card-block">
              <form action="{{route('clients.breads')}}" method="GET">
                <div class="row">
                  <div class="col-md-4 form-group">
                      <input type="date" name="date" required class="form-control pl-2 pr-2" value="{{ $date }}">
                    </div>
                    <div class="col-md-2 form-group" >
                      <input type="submit" class="btn btn-primary" value="Фильтр">
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-block" style="overflow: auto">
              <table id="myTable" class="table table-sm table-striped table-hover">
                  <thead class="table-bordered">
                      <tr>
                          <th>
                            Имя
                          </th>
                          @foreach ($breads as $bread)
                              <th>
                                {{$bread->name}}
                              </th>
                          @endforeach
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($clients as $client)
                      <tr>
                          <td class="align-middle">
                              <a href="{{route('clients.breads.show',$client->id)}}">{{ $client->name}}</a>
                          </td>
                          @foreach ($breads as $bread)
                            <td class="align-middle">
                                {{ $client->sale->where('bread_id',$bread->id)->sum('quantity')}}
                            </td>
                          @endforeach
                      </tr>
                      @empty
                      <tr>
                          <td colspan="8" class="text-center">
                              <h2>Клиенты нет</h2>
                          </td>
                      @endforelse
                  </tbody>
              </table>
          </div>
        </div>
    </div>

</div>
@endsection



