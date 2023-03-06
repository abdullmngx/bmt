<!doctype html>
<html lang="en">
  <head>
    <title>@yield('title')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"  integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>
  <body class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center text-white p-3" style="background: #9575CD">
                    <h4>VIP Lounge.</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="bg-white p-3">
                    @yield('content')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="bg-light p-3 text-center">
                    <div class="mb-4">
                        <a href="#" class="text-dark"><i class="fa fa-instagram fa-2x"></i></a>
                        <a href="#" class="text-dark"><i class="fa fa-telegram fa-2x"></i></a>
                        <a href="#" class="text-dark"><i class="fa fa-envelope fa-2x"></i></a>
                    </div>
                    <p>&copy; <script>document.write(new Date().getFullYear())</script> VIP Lounge</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
  </body>
</html>