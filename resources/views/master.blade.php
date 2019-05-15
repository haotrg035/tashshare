
<!doctype html>
<html lang="en">
  <head>
    <title>TaskShare</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('css')
  </head>
  <body class="h-100">
    <div id="page-first-wrapper" class="container-fluid h-100 bg-light ">
        <div id="page-second-wrapper" class="row h-100">
            @include('page-left-side')
            @include('page-right-side')
        </div><!-- page Wrapper  -->
    </div>
    <!-- Optional JavaScript -->
    @include('js')
    @hasSection ('private-js')
        @yield('private-js')
    @endif
  </body>
</html>
