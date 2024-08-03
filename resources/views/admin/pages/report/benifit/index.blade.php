@extends('admin.layouts.main')

@section('title', 'Trio System')

@section('breadcrumb')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
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
                    <h4>Выгода
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
                    <form action="{{route('report-benifit')}}" method="GET">
                        <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="date" name="start_date" required class="form-control" value="{{ $start_date }}">
                            </div>
                            <div class="col-md-6 form-group">
                            <input type="date" name="end_date" required class="form-control" value="{{ $end_date }}">
                            </div>
                            <div class="col-md-12 form-group" >
                            <input type="submit" class="btn btn-sm btn-primary" value="Фильтр">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header">
                    <h5>Фойда</h5>
                </div>
                <div class="card-body" style="overflow: auto">
                    
                    <table class="table table-sm table-bordered ">
                        <thead>
                            <tr>
                                <th>
                                  Был произведен (штук)
                                </th>
                                <th>
                                  Приход	
                                </th>
                                <th>
                                  Расход	
                                </th>
                                <th>
                                  Фойда	
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$production_count}}</td>
                                <td>{{number_format($sale_coming)}} сум</td>
                                <td>{{number_format($expenditure)}} сум</td>
                                <td>{{number_format($sale_coming-$expenditure)}} сум</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Расход</h5>
                </div>
                <div class="card-body" style="overflow: auto">
                    
                    <table class="table table-sm table-bordered ">
                        <thead>
                            <tr>
                                <th>
                                  Поставщик ушун расход
                                </th>
                                <th>
                                  Ичшилар расход	
                                </th>
                                <th>
                                  Ойлик	
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{number_format($expenditure_suppliers)}} сум</td>
                                <td>{{number_format($expenditure_users)}} сум</td>
                                <td>{{number_format($expenditure_salaries)}} сум</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection