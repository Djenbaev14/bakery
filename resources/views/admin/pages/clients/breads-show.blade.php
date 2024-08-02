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
                    <div class="col-12"><h4>{{$client->name}}
                    </h4></div>
                  </div>
                  
                  <form action="{{route('clients.breads.show',$client->id)}}" method="GET">
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
                  </form>
                </div>
              </div>
          </div>
      </div>
  </div>
  
    {{-- @foreach ($period as $dt)
        {{$dt->format("Y-m-d \n")}}
    @endforeach --}}
  <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block" style="overflow: auto">
                    <table class="table table-sm table-bordered table-striped table-hover mt-4">
                        <thead>
                            <tr>
                              @foreach ($period as $dt)
                                  <th>{{$dt->format("d/m/Y \n")}}</th>
                              @endforeach
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                            @foreach ($period as $dt)
                            <td>
                              @foreach ($breads as $bread)
                              {{$bread->name}} - <b>{{$client->sale()->whereDate('created_at',$dt->format('Y-m-d'))->where('bread_id',$bread->id)->sum('quantity')}}</b>  <br>
                              @endforeach
                            </td>
                            @endforeach
                          </tr>
                        </tbody>
                    </table>
                </div>
            
            </div>
        </div>
  </div>
@endsection
