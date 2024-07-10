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
                  <h4>Долг</h4>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            @livewire('debt-filter')
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
      .act {
        background: #111;
      }
    </style>
@endpush


@push('js')
    <script>
      
      $('#cusTransfers').click(function() {
          if($(this).is(':checked'))
            $("#tran").prop("readonly", false);
          else if(!$(this).is(':checked'))
            $("#tran").prop("readonly", true);
        });
    
        $('#cusCash').click(function() {
          if($(this).is(':checked'))
            $("#ca").prop("readonly", false);
          else if(!$(this).is(':checked'))
            $("#ca").prop("readonly", true);
        });
        
        
        $('#sadik_cusTransfers').click(function() {
          if($(this).is(':checked'))
            $("#sadik_tran").prop("readonly", false);
          else if(!$(this).is(':checked'))
            $("#sadik_tran").prop("readonly", true);
        });
    
        $('#sadik_cusCash').click(function() {
          if($(this).is(':checked'))
            $("#sadik_ca").prop("readonly", false);
          else if(!$(this).is(':checked'))
            $("#sadik_ca").prop("readonly", true);
        });

        
        function getClient(id,debt) {
          $('#sale_id').val(id);
          $('#de').val(debt);
        }
        
        function sadik_getClient(id,debt) {
          $('#sadik_sale_id').val(id);
          $('#sadik_de').val(debt);
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
            if(k<=1){
              paid.min=0;
              paid.max=total_price.value;
              paid.value=0;
            }else{
              paid.value=total_price.value;
              paid.readOnly=true;
            }
          }else{
            block.classList.add('d-none');
            total_price.value=0;
            paid.value=0;
            paid.readOnly=false;
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
        
          if(k<=1){
            paid.min=0;
            paid.max=total_price.value;
            paid.value=0;
            paid.readOnly=false;
          }else{
            paid.value=total_price.value;
            paid.readOnly=true;
          }
        
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
        
        var kinderBlock =document.getElementById("kinderBlock");
        var kinder_total_price=document.getElementById("kinder_total_price");
        var kinder_paid=document.getElementById("kinder_paid");

        function kinderCheckAll(o,total) {
          var boxes = document.getElementsByClassName("kinder_check");
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
            kinderBlock.classList.remove('d-none');
            kinder_total_price.value=total;
            if(k<=1){
              kinder_paid.min=0;
              kinder_paid.max=kinder_total_price.value;
              kinder_paid.value=0;
            }else{
              kinder_paid.value=kinder_total_price.value;
              kinder_paid.readOnly=true;
            }
          }else{
            kinderBlock.classList.add('d-none');
            kinder_total_price.value=0;
            kinder_paid.value=0;
            kinder_paid.readOnly=false;
          }

        }


        function kinderCheck(e,total) {
          var check =document.getElementsByClassName("kinder_check");
          var cc=document.getElementById("kindergartenCheckAll");
          var j=0;
          var k=0;

          for (let i = 0; i < check.length; i++) {
            if(check[i].checked){
              k+=1;
            }
          }

          if(e.checked){
            if(kinder_total_price.value){
              kinder_total_price.value=parseInt(kinder_total_price.value)+total;
            }else{
              kinder_total_price.value=total;
            }
          }else{
              cc.checked=false;
              kinder_total_price.value=parseInt(kinder_total_price.value)-total;
          }
          console.log(k);
        
          if(k<=1){
            kinder_paid.min=0;
            kinder_paid.max=kinder_total_price.value;
            kinder_paid.value=0;
            kinder_paid.readOnly=false;
          }else{
            kinder_paid.value=kinder_total_price.value;
            kinder_paid.readOnly=true;
          }
        
          for (let i = 0; i < check.length; i++) {
              j+=check[i].checked == true ? 1 : 0;
          }
          if(j>0){
            kinderBlock.classList.remove('d-none');
          }else{
            cc.checked=false;
            kinderBlock.classList.add('d-none');
          }
        }
    </script>
@endpush
