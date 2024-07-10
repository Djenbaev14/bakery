<div>
    <div class="card-block">
        <div class="row">
          <div class="col-12">
            <form action="{{route('sales.create')}}" method="POST">
                @csrf
                <div class="row">
                  <div class="form-group col-12">
                    <span>Покупатель</span>
                    <select class="form-control" name="client_id"  wire:model='client_id' wire:change="client_change"> 
                      <option hidden class="bg-secondary bg-gradient text-light">Выберите Покупателя</option>
                      @foreach ($clients as $client)
                          <option value="{{$client->id}}">{{$client->name}} | {{number_format($client->payment_history->sum('paid')-$client->sale->sum('total'))}} сум</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-12">
                    <span>Товар</span>
                    <select class="form-control" name="bread_id[]" wire:model='bread_id' wire:change="bread_change" id="bread_id" >
                      <option hidden class="bg-secondary bg-gradient text-light" selected>Выберите товар</option>
                      @forelse ($breads as $bread)
                        <option value="{{$bread->id}}" >{{$bread->name}} ({{$bread->quantity}}) штук</option>
                      @empty
                        <option class="bg-secondary bg-gradient text-light">Нет товаров</option>
                      @endforelse
                    </select>
                  </div>
                  <div class="form-group  col-12">
                    <span>Количество</span>
                    <input type="number" onchange="myFunction()" class="form-control" name="quantity[]" max="<?=count($breads)>0 ? $bread->quantity : "" ;?>" wire:model='quantity' id="quantity">
                  </div>
                  <div class="form-group col-12">
                    <span>Цена</span>
                    <input type="text" class="form-control pl-2" <?=(auth()->user()->role_id==3) ? "readonly" : "";?> name="price[]" wire:model='price'>
                  </div>
                  <div class="col-12 row justify-content-between mt-5 ">
                      <div class="input-group input-group-sm  mb-3 col-lg-5">
                          <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Общая сумма:</span>
                          </div>
                          <input type="text" readonly class="form-control" name="total_price" wire:model='total_price' aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                          <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm"> сум</span>
                          </div>
                      </div>
                      <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded" id="save">Продать товар</button>
                      </div>
                  </div>
                  <p id="demo"></p>
                </div>
            </form>
          </div>
        </div>
      </div>
</div>

<script>

  // document.getElementById("quantity").addEventListener("change", myFunc);

  // function myFunction() {
  //   let quantity = document.getElementById('quantity').value;
  //   console.log(quantity);

  // }
</script>