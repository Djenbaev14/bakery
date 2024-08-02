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
                    <h4>Доступ контроль
                    </h4>
                  </div>
                </div>
              </div>
              <div class="card-block" >
                <form action="{{route('controls.create')}}" method="POST">
                  @csrf
                  <div class="d-flex bg-light p-3 align-items-center justify-content-between">
                    <div class="box col-sm-6">
                      @foreach ($workers->user as $worker)
                      <div class="form-check form-check-inline">
                        <label class="form-check-label pr-2 pl-2">
                          @if (in_array($worker->id,$arr))
                            <input type="checkbox" name="user_id[]" checked class="form-check-input" value="{{$worker->id}}">{{$worker->username}}
                          @else
                            <input type="checkbox" name="user_id[]" class="form-check-input" value="{{$worker->id}}">{{$worker->username}}
                          @endif
                        </label>
                      </div>
                      @endforeach
                    </div>
                    <div class="buttun-card col-sm-6">
                      <button class="btn btn-sm btn-primary pl-3 pr-3 mt-2 mb-2" name="access">Доступ</button>
                      <button class="btn btn-sm btn-danger pl-3 pr-3 mt-2 mb-2" name="limit">Ограничить</button>
                    </div>
                  </div>
                </form>
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
                            <th>
                              №
                            </th>
                            <th>
                              Имя 1
                            </th>
                            <th>
                              Имя 2
                            </th>
                            <th>
                              Начало времени
                            </th>
                            <th>
                              Конец времени
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($access_controls as $control)
                        <tr>
                            <td class="align-middle">
                                {{ ($access_controls ->currentpage()-1) * $access_controls ->perpage() + $loop->index + 1 }}
                            </td>
                            <td class="align-middle">
                                {{ $control->first_name}}
                            </td>
                            <td class="align-middle">
                              {{ $control->second_name }}
                            </td>
                            <td class="align-middle">
                              <span class="bg-primary bg-gradient rounded text-light pr-2 pl-2">
                                <span class="day">{{\Carbon\Carbon::parse($control->created_at)->format('d M Y H:i:s')}}</span>
                              </span>
                            </td>
                            <td class="align-middle">
                              @if ($control->end_date)
                              <span class="bg-success bg-gradient rounded text-light pr-2 pl-2">{{\Carbon\Carbon::parse($control->end_date)->format('d M Y H:i:s')}}</span>
                              @else
                                <span class="bg-danger bg-gradient rounded text-light pr-2 pl-2">Работает</span> 
                              @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <h2>Производство нет</h2>
                            </td>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <span class="d-flex justify-content-end">{{$access_controls->links()}}</span>
        </div>
    </div>

  </div>
@endsection

@push('js')
  <script>
    $("input[type=checkbox]").change(function(){
    var max= 2;
    if( $("input[type=checkbox]:checked").length == max ){
        $("input[type=checkbox]").attr('disabled', 'disabled');
        $("input[type=checkbox]:checked").removeAttr('disabled');
    }else{
         $("input[type=checkbox]").removeAttr('disabled');
    }
  });
  </script>
@endpush
