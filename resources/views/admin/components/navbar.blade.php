<nav class="pcoded-navbar menu-light position-fixed">
  <div class="navbar-wrapper  ">
      <div class="navbar-content scroll-div " >

          <ul class="nav pcoded-inner-navbar ">
              <li class="nav-item pcoded-menu-caption">
                  <label>Меню</label>
              </li>
              @if (auth()->user()->role_id == 1)
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Главная</span></a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{route('sales.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-dollar-sign"></i></span><span class="pcoded-mtext">Продажи</span></a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{route('sales2.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-dollar-sign"></i></span><span class="pcoded-mtext">Продажи</span></a>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#" class="nav-link d-flex align-items-center"><span class="pcoded-micon"><i class="fa fa-warehouse"></i></span><span class="pcoded-mtext">Склад</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{route('suppliers.index')}}">Поставщики</a></li>
                        <li><a href="{{route('products.index')}}">Склад 1</a></li>
                        <li><a href="{{route('breads.index')}}">Склад 2</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('controls.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-cog"></i></span><span class="pcoded-mtext">Доступ контроль</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{route('productions.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-shopping-cart"></i></span><span class="pcoded-mtext">Производство</span></a>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#" class="nav-link d-flex align-items-center"><span class="pcoded-micon"><i class="fa fa-warehouse"></i></span><span class="pcoded-mtext">Долги</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{route('debts.index')}}">Долг</a></li>
                        <li><a href="{{route('expected.debts.index')}}">Ожидаемое долги</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-users"></i></span><span class="pcoded-mtext">Пользователи</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{route('expenditure.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-coins"></i></span><span class="pcoded-mtext">Расход</span></a>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#" class="nav-link d-flex align-items-center"><span class="pcoded-micon"><i class="fa fa-truck"></i></span><span class="pcoded-mtext">Доставка</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{route('deliveries.index')}}">Доставка</a></li>
                        <li><a href="{{route('deliveries.delivery-history')}}">История доставок</a></li>
                    </ul>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#" class="nav-link d-flex align-items-center"><span class="pcoded-micon"><i class="fa fa-users"></i></span><span class="pcoded-mtext">Клиенты</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{route('clients.index')}}">Список клиентов</a></li>
                        <li><a href="{{route('debt_clients.index')}}">Долг клиенты</a></li>
                        <li><a href="{{route('clients.breads')}}">Клиенты</a></li>
                    </ul>
                </li>
                
                <li class="nav-item pcoded-hasmenu">
                    <a href="#" class="nav-link d-flex align-items-center"><span class="pcoded-micon"><i class="fa fa-file"></i></span><span class="pcoded-mtext">Отчет</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{route('report-benifit')}}">Выгода</a></li>
                        <li><a href="{{route('report-sale')}}">Платежи</a></li>
                        <li><a href="{{route('report-balance')}}">Баланс</a></li>
                        <li><a href="{{route('report-group')}}">Группа</a></li>
                        <li><a href="{{route('report-warehouse')}}">Склад</a></li>
                        <li><a href="{{route('report-warehouse-2')}}">Производства</a></li>
                        <li><a href="{{route('report-delivery')}}">Доставщик продажа</a></li>
                        <li><a href="{{route('report-admin')}}">Админ продажа</a></li>
                        <li><a href="{{route('report-active')}}">Актив клиенты </a></li>
                        {{-- report-active --}}
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{route('fines.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-exclamation-circle"></i></span><span class="pcoded-mtext">Штраф </span></a>
                </li>

                @elseif(auth()->user()->role_id == 3)
                    {{-- <li class="nav-item">
                        <a href="{{route('sales.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-dollar-sign"></i></span><span class="pcoded-mtext">Продажи</span></a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="{{route('sales2.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-dollar-sign"></i></span><span class="pcoded-mtext">Продажи </span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('debts.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-warehouse"></i></span><span class="pcoded-mtext">Долг</span></a>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link d-flex align-items-center"><span class="pcoded-micon"><i class="fa fa-truck"></i></span><span class="pcoded-mtext">Доставка</span></a>
                        <ul class="pcoded-submenu">
                            <li><a href="{{route('deliveries.index')}}">Доставка</a></li>
                            <li><a href="{{route('deliveries.delivery-history')}}">История доставок</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('expenditure.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-coins"></i></span><span class="pcoded-mtext">Расход</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('clients.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-users"></i></span><span class="pcoded-mtext">Клиенты</span></a>
                    </li>
                @elseif(auth()->user()->role_id == 2)
                    <li class="nav-item">
                        <a href="{{route('home')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Главная</span></a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{route('sales.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-dollar-sign"></i></span><span class="pcoded-mtext">Продажи</span></a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="{{route('sales2.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-dollar-sign"></i></span><span class="pcoded-mtext">Продажи</span></a>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link d-flex align-items-center"><span class="pcoded-micon"><i class="fa fa-warehouse"></i></span><span class="pcoded-mtext">Склад</span></a>
                        <ul class="pcoded-submenu">
                            <li><a href="{{route('suppliers.index')}}">Поставщики</a></li>
                            <li><a href="{{route('products.index')}}">Склад 1</a></li>
                            <li><a href="{{route('breads.index')}}">Склад 2</a></li>
                        </ul>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link d-flex align-items-center"><span class="pcoded-micon"><i class="fa fa-warehouse"></i></span><span class="pcoded-mtext">Долги</span></a>
                        <ul class="pcoded-submenu">
                            <li><a href="{{route('debts.index')}}">Долг</a></li>
                            <li><a href="{{route('expected.debts.index')}}">Ожидаемое долги</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('controls.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-cog"></i></span><span class="pcoded-mtext">Доступ контроль</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('expenditure.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-coins"></i></span><span class="pcoded-mtext">Расход</span></a>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link d-flex align-items-center"><span class="pcoded-micon"><i class="fa fa-truck"></i></span><span class="pcoded-mtext">Доставка</span></a>
                        <ul class="pcoded-submenu">
                            <li><a href="{{route('deliveries.index')}}">Доставка</a></li>
                            <li><a href="{{route('deliveries.delivery-history')}}">История доставок</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('clients.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-users"></i></span><span class="pcoded-mtext">Клиенты</span></a>
                    </li>
                    
                @elseif(auth()->user()->role_id == 4)
                    <li class="nav-item">
                        <a href="{{route('productions.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-shopping-cart"></i></span><span class="pcoded-mtext">Производство</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('expenditure.index')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-coins"></i></span><span class="pcoded-mtext">Расход</span></a>
                    </li>
              @endif
          </ul>
      </div>
  </div>
</nav>
