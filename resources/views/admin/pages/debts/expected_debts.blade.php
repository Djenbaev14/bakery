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
                  <h4>Ожидаемое долги
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
            @livewire('expected-debt')
        </div>
    </div>
</div>
@endsection


@push('js')
    <script>
        function updateDate(id) {
        $('#user_id').val(id);
      }
    </script>
    <script>
        
        var block =document.getElementById("block");
        var total_price=document.getElementById("total_price");
        var paid=document.getElementById("paid");

        function checkAll(o,total) {
          var boxes = document.getElementsByClassName("check");
          var k=0;

          for (var x = 0; x < boxes.length; x++) {
          var obj = boxes[x];
          if (obj.type == "checkbox") {
            if (obj.name != "check")
              obj.checked = o.checked;
          }
          }

          for (let i = 0; i < boxes.length; i++) {
            if(boxes[i].checked){
              k+=1;
            }
          }
          if(o.checked){
            block.classList.remove('d-none');
            total_price.value=total;
          }else{
            block.classList.add('d-none');
            total_price.value=0;
          }

        }


        function check(e,total) {
          var check =document.getElementsByClassName("check");
          var cc=document.getElementById("cc");
          var j=0;
          var k=0;

          for (let i = 0; i < check.length; i++) {
            if(check[i].checked){
              k+=1;
            }
          }

          if(e.checked){
            if(total_price.value){
              total_price.value=parseInt(total_price.value)+total;
            }else{
              total_price.value=total;
            }
          }else{
              cc.checked=false;
              total_price.value=parseInt(total_price.value)-total;
          }
          console.log(k);
        
        
          for (let i = 0; i < check.length; i++) {
              j+=check[i].checked == true ? 1 : 0;
          }
          if(j>0){
            block.classList.remove('d-none');
          }else{
            cc.checked=false;
            block.classList.add('d-none');
          }
        }
    </script>
@endpush