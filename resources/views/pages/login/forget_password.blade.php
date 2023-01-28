<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <title>Forget Password</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/style.css" rel="stylesheet" type="text/css"/>

    <script src="/assets/js/modernizr.min.js"></script>

</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class="card-box">
        <div class="panel-heading">
            <h4 class="text-center"> Reset Password</h4>
            {{--<p class="text-center">Email: memotiur@gmail.com</p>
            <p class="text-center">Pass: 123456</p>--}}
        </div>

        @if(session('failed'))
            <p style="color: red;text-align: center">{{session('failed')}}!</p>
        @endif

        <div class="p-20">
            <form class="form-horizontal m-t-20" action="/do-password-reset" method="post">
                <div class="form-group ">
                    <div class="col-12">
                        <input class="form-control" type="email" required="" value="" name="user_email"
                               placeholder="Email">
                        <input class="form-control" type="hidden" value="{{csrf_token()}}" name="_token">
                    </div>
                </div>


                <div class="form-group text-center m-t-40">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block text-uppercase waves-effect waves-light"
                                type="submit">Reset Password
                        </button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-12">
                        <a href="/" class="text-dark"><i class="fa fa-arrow-circle-o-right m-r-5"></i> Login</a>
                    </div>
                </div>
            </form>

        </div>
    </div>

</div>


<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/detect.js"></script>
<script src="/assets/js/fastclick.js"></script>
<script src="/assets/js/jquery.slimscroll.js"></script>
<script src="/assets/js/jquery.blockUI.js"></script>
<script src="/assets/js/waves.js"></script>
<script src="/assets/js/wow.min.js"></script>
<script src="/assets/js/jquery.nicescroll.js"></script>
<script src="/assets/js/jquery.scrollTo.min.js"></script>

<script src="/assets/js/jquery.core.js"></script>
<script src="/assets/js/jquery.app.js"></script>

</body>

</html>
