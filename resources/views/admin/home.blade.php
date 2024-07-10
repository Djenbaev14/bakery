@extends('admin.layouts.main')

@section('title', 'Dashboard')

@section('breadcrumb')
  @if (auth()->user()->role_id == 1) 
    <div class="page-header">
      <div class="page-block">
        <div class="row">
          <div class="col-lg-3 col-sm-12 card card-1 mb-3">
            <h4><i class="fa fa-users"></i></h4>
            <h4>{{$clients->count()}} <i class="fa fa-arrow-circle-up"></i></h4>
            <h5>Клиенты</h5>
          </div>
          <div class="col-lg-3 col-sm-12 card card-2 mb-3">
            <h4><i class="fa fa-users"></i></h4>
            <h4>{{$count}}  <i class="fa fa-hourglass-half" aria-hidden="true"></i></h4>
            <h5>Должники</h5>
          </div>
          <div class="col-lg-3 col-sm-12 card card-3 mb-3">
            <h4><i class="fa fa-hourglass-half" aria-hidden="true"></i></h4>
            <h4><?=($debt_clients>0) ? number_format($debt_clients) : 0;?> сум</h4>
            <h5>Наличные долги</h5>
          </div>
          <div class="col-lg-3 col-sm-12 card card-4 mb-3">
            <h4><i class="fa fa-hourglass-half" aria-hidden="true"></i></h4>
            <h4><?=($debt_kindergarden_clients>0) ? number_format($debt_kindergarden_clients) : 0;?> сум</h4>
            <h5>Долги (Перечисления)</h5>
          </div>
          <div class="col-lg-3 col-sm-12 card card-4 mb-3">
            <h4><i class="fa fa-hourglass-half" aria-hidden="true"></i></h4>
            <h4><?=($debt_suppliers>0) ? number_format($debt_suppliers) : 0;?> сум</h4>
            <h5>Долг от Поставщиков</h5>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection




@push('css')
  <link rel="stylesheet" href="/path/to/cdn/bootstrap.min.css" />
  <style>
    .card{
      padding: 20px 10px; 
      margin: 0 5px;
    }
    .card h4,.card h5{
      color: #fff;
    }
    .card-1{
      background: rgb(13,63,109);
      background: linear-gradient(90deg, rgba(13,63,109,1) 0%, rgba(228,11,148,1) 100%);
    }
    .card-2{
      background: rgb(40,78,227);
      background: linear-gradient(90deg, rgba(40,78,227,1) 0%, rgba(123,208,136,1) 100%);
    }
    .card-3{
      background: rgb(42,74,206);
      background: linear-gradient(90deg, rgba(42,74,206,1) 0%, rgba(110,186,227,1) 100%);
    }
    .card-4{
      background: rgb(223,130,43);
      background: linear-gradient(90deg, rgba(223,130,43,1) 0%, rgba(223,249,94,1) 100%);
    }
  </style>
@endpush

@push('js')
  <script src="/path/to/cdn/jquery.slim.min.js"></script>
  <script src="/path/to/cdn/bootstrap.bundle.min.js"></script>
  <script src="jquery.bsSelectDrop.js"></script>

  <script>
      $('select').bsSelectDrop({
    btnWidth:'fit-content',
    btnEmptyText:'Select An Option...',
    btnClass:'btn btn-outline-secondary',
  });


  $('select').bsSelectDrop({
    dark<a href="https://www.jqueryscript.net/menu/">Menu</a>:true,
  });

  $('select').bsSelectDrop({
    search:true,
  });

  $('select').bsSelectDrop({
    menuPreHtml:'<b>jQueryScript</b>',
    menuAppendHtml:'<b>End</b>',
  });

  $('select').bsSelectDrop({
    dropUp:false,
    dropStart:false,
    dropEnd:false,
    dropCenter:false,
    dropHeaderClass:'secondary',
  });

  $('select').bsSelectDrop({
    showActionMenu:true,
    deselectAllText:'Deselect All',
    selectAllText:'Select All',
  });

  </script>
@endpush