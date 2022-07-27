<!DOCTYPE html>
<html>
<head>
	<title>Quản trị</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <base href="{{asset('/')}}"/>
	<link rel="stylesheet" href="admin/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="admin/css/font-awesome.min.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="admin/css/style.css" type="text/css" media="screen" />
  <link rel="shortcut icon" href="{Ilogo.imgI}">
	<script src="admin/bootstrap/js/jquery-1.11.2.min.js"></script>
</head>
<style type="text/css">
  .bglogin{
        position: fixed;
    width: 100%;
    height: 100%;
    object-fit: cover;
    -webkit-filter: blur(5px);
        z-index: -1;
  }
  .login{
        background: rgba(204, 204, 204, 0.63);
    padding: 20px 40px;
    max-width: 500px;
        background: rgba(204, 204, 204, 0.63);
    padding: 20px 40px;
    max-width: 500px;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    position: absolute;
    height: 320px;
  }
  .login h1{
text-align: center;
    text-transform: uppercase;
    font-family: robob;
    margin: 0px 0px 10px 0px;
    font-size: 24px;
    color: #00923F;
  }
  .login .loginlogo{
    margin: 10px auto;
    max-height: 70px;
    max-width: 100%;
  }
  .login form .item{
    display: flex;
    width: 100%;
  }
  .login form .item input{
    height: 40px;
    float: left;
    border: 1px solid #6D6D6D;
    flex: 1;
    padding-left: 5px;
  }
  .login form .item i{
    width: 40px;
    height: 40px;
    background: #00923f;
    text-align: center;
    font-size: 18px;
    color: #fff;
    padding: 10px 0px;
    float: left;
  }
  .login .btnlogin{
    background: #00923f;
    padding: 2px;
  }
  .login .btnlogin button{
    background: #00923f;
    border: 1px solid #ccc;
    width: 100%;
    color:#fff;
    text-transform: uppercase;
    font-size: 22px;
    font-family: robo;
    padding: 10px;
  }
  .rem input[name=remember]{
    margin: 8px 0px;
    padding: 10px;
    width: 15px;
    height: 15px;
    display: inline;
    float: left;
  }
  .rem label[for=remember]{
    color: #fff;
    display: inline;
    float: left;
    margin: 5px 0px 0px 5px;
  }
  .forget{
        font-family: robob;
    font-size: 16px;
    margin: 3px 0px;
    display: block;
    color: #C55A0B;
  }
  .container-fluid{
        width: 100vw;
    height: 100vh;
    position: relative;
  }
</style>
<body>
<img class="bglogin" src="admin/images/bg.png">
<div class="container-fluid">
  <div class="login col-xs-12 col-md-6">
    <img src="{Ilogo.imgI}" class="img-responsive loginlogo" alt="">
    <form class="tac" action="{{$admincp}}/login" method="POST">
    {!! csrf_field() !!}
      <div class="item aclr">
        <i class="fa fa-user" aria-hidden="true"></i>
        <input type="text" name="username" value="" placeholder="Tài khoản đăng nhập">
      </div>
      </br>
      <div class="item aclr">
        <i class="fa fa-key" aria-hidden="true"></i>
        <input type="password" name="password" placeholder="Mật khẩu đăng nhập">
      </div>
      <div class="aclr">
        <div class="pull-left aclr rem">
          <!-- <input name="remember" type="checkbox">
          <label for="remember">Ghi nhớ tài khoản</label> -->
        </div>
        {{-- <div class="pull-right">
          <a class="clmain forget" href="#">Quên mật khẩu?</a>
        </div> --}}
      </div>
      <div class="btnlogin" style="margin-top: 20px;">
        <button type="submit">Đăng nhập</button>
      </div>
    </form>
  </div>
</div>
</body>