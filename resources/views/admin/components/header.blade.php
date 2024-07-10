<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue position-fixed bg-primary">


  <div class="m-header">
      <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
      <a href="#!" class="b-brand">
          <!-- ========   change your logo hear   ============ -->
          {{-- <img src="/admin/images/logo.png" alt="" class="logo">
          <img src="/admin/images/logo-icon.png" alt="" class="logo-thumb"> --}}
      </a>
      <a href="#!" class="mob-toggler">
          <i class="feather icon-more-vertical"></i>
      </a>
  </div>
  <div class="collapse  navbar-collapse">
      <ul class="navbar-nav ml-auto">
          <li class="d-flex">
            <span>{{auth()->user()->username}} &nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></span>
              <div class="dropdown drp-user">
                  <a href="#" class="dropdown-toggle " data-toggle="dropdown">
                    <i class="fa fa-user-circle h4 mt-3" aria-hidden="true"></i>

                  </a>
                  <div class="dropdown-menu dropdown-menu-right profile-notification">
                      <?php 
                                // $user=DB::table('users')
                                // ->where('users.id','=',auth()->user()->id)
                                // ->join('roles','users.role_id','=','roles.id')
                                // ->join('user_salaries','users.id','=','user_salaries.user_id')
                                // ->select('roles.r_name',DB::raw('SUM(user_salaries.summa) as balance'))         
                                // ->groupBy('users.id')
                                // ->get();
                                // $expenditure=DB::table('users')
                                // ->where('users.id','=',auth()->user()->id)
                                // ->join('roles','users.role_id','=','roles.id')
                                // ->join('expenditures','users.id','=','expenditures.user_id')
                                // ->select(DB::raw('SUM(expenditures.price) as expenditure_balance'))         
                                // ->groupBy('users.id')
                                // ->get();
                                // $role=DB::table('users')
                                // ->where('users.id','=',auth()->user()->id)
                                // ->join('roles','users.role_id','=','roles.id')
                                // ->select('roles.r_name')         
                                // ->get();
                      ?>
                      <ul class="list-group">
                          <li class="list-group-item"><span class="font-weight-bold">Имя:</span>&nbsp;&nbsp;  {{auth()->user()->username}}</li>
                          <li class="list-group-item"><span class="font-weight-bold">Телофон номер:</span>&nbsp;&nbsp;{{auth()->user()->phone}}</li>
                          @if (auth()->user()->role_id!=1)
                            <li class="list-group-item"><span class="font-weight-bold">КПИ:</span>&nbsp;&nbsp;  {{auth()->user()->KPI}} сум</li>
                            <li class="list-group-item"><span class="font-weight-bold">Баланс:</span>&nbsp;&nbsp; {{number_format(user_balance(auth()->user()))}} сум</li>
                          @endif
                          <li class="list-group-item"><span class="bg-primary bg-gradient rounded text-light pr-1 pl-1">Роли:</span>  
                            
                            <span class="bg-info bg-gradient rounded text-light pr-1 pl-1">{{auth()->user()->role->r_name}}</span>
                          </li>
                      </ul>
                      <div class="row d-flex align-items-center justify-content-center m-3">
                        <a href="{{route('logout')}}" class="col-12 dud-logout bg-danger text-light p-2 text-center" title="Logout">
                            <i class="feather icon-log-out"></i>&nbsp;Выход из системы
                        </a>
                      </div>
                  </div>
              </div>
          </li>
      </ul>
  </div>


</header>
