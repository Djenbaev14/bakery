<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        @yield('title', 'Dashboard')
    </title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="" />
    <meta name="keywords"
        content="" />
    <meta name="author" content="Webclub.UZ" />

    <!-- Favicon icon -->
    <link rel="icon" href="/admin/images/favicon.ico" type="image/x-icon">
    

    <!-- vendor css -->
    <link rel="stylesheet" href="/admin/css/style.css">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet" /> --}}
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <link rel="stylesheet" href="./vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    {{-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" /> --}}
    @livewireStyles
    @stack('css')
</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->
    @include('admin.components.navbar')
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    @include('admin.components.header')
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper" >
            <div class="pcoded-content ">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                        @yield('breadcrumb')
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            @yield('content')
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Required Js -->
    {{-- <script src="/admin/js/vendor-all.min.js"></script>
    <script src="/admin/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/admin/js/pcoded.min.js"></script> --}}



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/admin/js/vendor-all.min.js"></script>
    <script src="/admin/js/plugins/bootstrap.min.js"></script>
    <script src="/admin/js/ripple.js"></script>
    <script src="/admin/js/pcoded.min.js"></script>
    @include('sweetalert::alert')
    @stack('js')
  <script>
    $("form").submit(function () {
        $("#save").attr("disabled", true);
        });
        
    $("form").submit(function () {
        $("#save2").attr("disabled", true);
        });
        
    $("form").submit(function () {
        $("#save3").attr("disabled", true);
        });
        
  </script>
  
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
  <script>  
    $('.inputNumber').on('keydown keyup', function() {
      this.oldVal = this.value.replace(/\D/g, '');
      this.value = Number(this.oldVal).toLocaleString();
    })
    function Comma(Num) { //function to add commas to textboxes
        Num += '';
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        return x1 + x2;
    }
    
    
  </script>
    @livewireScripts
</body>

</html>
