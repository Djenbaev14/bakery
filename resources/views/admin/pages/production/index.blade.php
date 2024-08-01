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
                  <h4>Производство
                  </h4>
                </div>
              </div>
            </div>
            <div class="card-block">
              <form action="{{route('productions.create')}}" method="POST">
                @csrf
                <div class="form-group">
                  <select name="bread_id"  id="select" class="form-control selectpicker" >
                    @foreach ($breads as $bread)
                    <option hidden class="bg-secondary bg-gradient text-light">Выберите товар</option>
                      <option value="{{$bread->id}}">{{$bread->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="d-flex bg-light p-3">
                  @foreach ($workers as $worker)
                  <div class="form-check form-check-inline">
                    <label class="form-check-label pr-2 pl-2">
                      <input type="checkbox" name="user_id[]" class="form-check-input" value="{{$worker->id}}">{{$worker->name}}
                    </label>
                  </div>
                  @endforeach
                </div>
                <div class="row justify-content-center mt-3">
                  <div class="col-lg-6 col-sm-12 ">Количество</h5>
                    <input type="text" class="calculator-screen z-depth-1 form-control mb-2" name="quantity"/>
                  
                    <div class="calculator-keys row">
                  
                  
                      <button type="button" value="1" class="btn btn-primary waves-effect col-4 border p-3">1</button>
                      <button type="button" value="2" class="btn btn-primary waves-effect col-4 border p-3">2</button>
                      <button type="button" value="3" class="btn btn-primary waves-effect col-4 border p-3">3</button>
                      <button type="button" value="4" class="btn btn-primary waves-effect col-4 border p-3">4</button>
                      <button type="button" value="5" class="btn btn-primary waves-effect col-4 border p-3">5</button>
                      <button type="button" value="6" class="btn btn-primary waves-effect col-4 border p-3">6</button>
                      <button type="button" value="7" class="btn btn-primary waves-effect col-4 border p-3">7</button>
                      <button type="button" value="8" class="btn btn-primary waves-effect col-4 border p-3">8</button>
                      <button type="button" value="9" class="btn btn-primary waves-effect col-4 border p-3">9</button>
                      <button type="button" value="0" class="btn btn-primary waves-effect col-6 border p-3">0</button>
                      <button type="button" class="all-clear function btn btn-primary waves-effect col-6 border p-3" value="all-clear">AC</button>
                      <button type="submit" class="btn btn-primary waves-effect col-12 border p-3" id="save" >Добавить товар</button>
                    </div>
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
                <table class="table table-sm table-bordered table-striped table-hover" >
                    <thead>
                        <tr>
                            <th>
                              Название продукта
                            </th>
                            <th>
                              Ответственный
                            </th>
                            <th>
                              Количество
                            </th>
                            <th>
                              Себе стоимость
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
                        @forelse ($production as $pro)
                        <tr>
                            <td class="align-middle">
                                {{ $pro->bread->name}}
                            </td>
                            <td class="align-middle">
                                {{ $pro->responsible->username}}
                            </td>
                            <td class="align-middle">
                              {{ $pro->quantity }}
                            </td>
                            <td class="align-middle">
                              @if (auth()->user()->role_id==1)
                                {{ number_format($pro->cost_price) }} сум
                              @endif
                            </td>
                            <td class="align-middle">
                              {{\Carbon\Carbon::parse($pro->created_at)->format('d M Y H:i:s')}}
                            </td>
                            <td class="align-middle d-flex justify-content-between">
                              <form action="{{route('productions.destroy',$pro->id)}}" method="post">
                                @csrf
                                <button class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></button>
                              </form>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#returnProduct<?php echo $pro->id ?>">
                              <i class="fa fa-minus text-light"></i>
                            </button>
                            
                            
                                <!-- The Modal -->
                                <div class="modal fade" id="returnProduct<?php echo  $pro->id ?>">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
          
                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title">Изменение количества товаров</h4>
                                      </div>
                                      
                                      <form action="{{route('productions.changeQuan',$pro->id)}}" method="post">
                                        @csrf
                                        <div class="card-block" style="overflow: auto">
                                          <input type="number" name="quantity" class="form-control" value="0" max="{{$pro->quantity}}"><br><br>
                                          <button class="btn btn-sm btn-primary">Сохранить</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            

                            
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
  <script>
    const calculator = {
      displayValue: '0',
      firstOperand: null,
      waitingForSecondOperand: false,
      operator: null,
    };
    
    function inputDigit(digit) {
      const { displayValue, waitingForSecondOperand } = calculator;
    
      if (waitingForSecondOperand === true) {
        calculator.displayValue = digit;
        calculator.waitingForSecondOperand = false;
      } else {
        calculator.displayValue = displayValue === '0' ? digit : displayValue + digit;
      }
    }
    
    function inputDecimal(dot) {
      // If the `displayValue` does not contain a decimal point
      if (!calculator.displayValue.includes(dot)) {
        // Append the decimal point
        calculator.displayValue += dot;
      }
    }
    
    function handleOperator(nextOperator) {
      const { firstOperand, displayValue, operator } = calculator
      const inputValue = parseFloat(displayValue);
    
      if (operator && calculator.waitingForSecondOperand)  {
        calculator.operator = nextOperator;
        return;
      }
    
      if (firstOperand == null) {
        calculator.firstOperand = inputValue;
      } else if (operator) {
        const currentValue = firstOperand || 0;
        const result = performCalculation[operator](currentValue, inputValue);
    
        calculator.displayValue = String(result);
        calculator.firstOperand = result;
      }
    
      calculator.waitingForSecondOperand = true;
      calculator.operator = nextOperator;
    }
    
    const performCalculation = {
      '/': (firstOperand, secondOperand) => firstOperand / secondOperand,
    
      '*': (firstOperand, secondOperand) => firstOperand * secondOperand,
    
      '+': (firstOperand, secondOperand) => firstOperand + secondOperand,
    
      '-': (firstOperand, secondOperand) => firstOperand - secondOperand,
    
      '=': (firstOperand, secondOperand) => secondOperand
    };
    
    function resetCalculator() {
      calculator.displayValue = '0';
      calculator.firstOperand = null;
      calculator.waitingForSecondOperand = false;
      calculator.operator = null;
    }
    
    function updateDisplay() {
      const display = document.querySelector('.calculator-screen');
      display.value = calculator.displayValue;
    }
    
    updateDisplay();
    
    const keys = document.querySelector('.calculator-keys');
    keys.addEventListener('click', (event) => {
      const { target } = event;
      if (!target.matches('button')) {
        return;
      }
    
      if (target.classList.contains('operator')) {
        handleOperator(target.value);
        updateDisplay();
        return;
      }
    
      if (target.classList.contains('decimal')) {
        inputDecimal(target.value);
        updateDisplay();
        return;
      }
    
      if (target.classList.contains('all-clear')) {
        resetCalculator();
        updateDisplay();
        return;
      }
    
      inputDigit(target.value);
      updateDisplay();
    });
  </script>
  
<script>
  $(document).ready(function () {
  $('.selectpicker').selectize({
      sortField: 'text'
  });
  });
</script>
  
@endpush


