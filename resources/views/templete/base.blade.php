<!DOCTYPE html>
<html lang="ja">
<head>
    <title>@yield('pageTitle')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" charset="UTF-8">
    <link rel="stylesheet" href="js/wijmo/styles/wijmo.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/base.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    @stack('css')
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="js/wijmo/controls/wijmo.min.js"></script>
    <script src="js/wijmo/controls/wijmo.input.min.js"></script>
    <script src="js/wijmo/controls/wijmo.grid.min.js"></script>
    <script src="js/wijmo/controls/wijmo.grid.detail.min.js"></script>
    <script src="js/wijmo/controls/wijmo.grid.xlsx.min.js"></script>
    <script src="js/wijmo/controls/wijmo.grid.filter.min.js"></script>
    <script src="js/wijmo/controls/wijmo.grid.multirow.min.js"></script>
    <script src="js/wijmo/controls/wijmo.xlsx.min.js"></script>
    <script src="js/wijmo/controls/cultures/wijmo.culture.ja.min.js"></script>
    <!-- ADD YMST ▽-->
    <script src="../js/wijmo/controls/wijmo.grid.search.min.js"></script>
    <script src="js/wijmo/controls/wijmo.grid.selector.min.js"></script>
    <!-- △ -->
    <script src="js/ajax_function.js"></script>
    <script src="js/common_definition.js"></script>
    <script src="js/common_function.js"></script>
    @stack('javascript')
    <div style="height:calc(100vh - 100px);">
        @yield('contents')
    </div>
</body>
<html>
