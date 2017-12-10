 
        
        <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Takoradi Polytechnic">
    <meta name="author" content="Takoradi Polytechnic">
    <title>School Resource Planning System  | The Nest School</title>
    <meta name="msapplication-TileColor" content="#9f00a7">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
  <!-- Favicons-->
  <link rel="icon" href="assets/favicon.png" sizes="32x32">
  <!-- Favicons-->
  <link rel="apple-touch-icon-precomposed" href="assets/favicon.png">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="assets/favicon.png">
  <!-- For Windows Phone -->

 <style>
    
html{
    
    
    
}
body{
    
    
    
}
</style>
   <!-- uikit -->
    <link rel="stylesheet" href="{!! url('public/plugins/uikit/css/uikit.almost-flat.min.css') !!}"/>

    <!-- altair admin login page -->
    <link rel="stylesheet" href="{!! url('public/assets/css/login_page.min.css') !!}" />

</head>

<body class="login_page">

    <div class="login_page_wrapper">
         <!-- if there are login errors, show them here -->
		 @if (count($errors) > 0)

                <div class="uk-form-row">
                    <div class="alert alert-danger" style="background-color: red;color: white">
                       
                          <ul>
                            @foreach ($errors->all() as $error)
                              <li> {!!  $error  !!} </li>
                            @endforeach
                      </ul>
                </div>
              </div>
            @endif
             <div class="login_heading">
                    <img src="{!! url('public/assets/img/logo.PNG') !!}"class="thumbnail" style="width:120px;height: auto"/>
                </div>
            <center><h4 class="uk-text-primary uk-text-upper uk-text-large"> NEST SCHOOL COMPLEX - SCHOOL SOFTWARE</h4></center>
        <div class="md-card" id="login_card">
            <div class="md-card-content large-padding" id="login_form">
               
                <form action="login" method="Post">
                    <div class="uk-form-row">
                        <label for="login_username">Staff ID</label>
                        <input class="md-input" type="text" required="" id="login_username" name="fund" value="{{ old('fund') }}" />
                    
                    </div>
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="uk-form-row">
                        <label for="login_password">Password</label>
                        <input class="md-input" type="password" id="login_password" name="password" required="" value="{{ old('password') }}"/>
                    </div>
                    <div class="uk-margin-medium-top">
                        <button type="submit"  class="md-btn md-btn-primary md-btn-block md-btn-large">Login </button>
                    </div>
                    <div class="uk-margin-top">
                         
                        <span class="icheck-inline">
                            <input type="checkbox" name="remember" id="login_page_stay_signed" data-md-icheck />
                            <label for="login_page_stay_signed" class="inline-label">Stay signed in</label>
                        </span>
                    </div>
                </form>
            </div>
             
             
        </div>
            <p style=""align='center' class="uk-text-small">  <a style="text-decoration: none" href='#' target='_'>&copy<?php echo date("Y")?> | Nest School. All Rights Reserved</a> </p>
    </div>

    <!-- common functions -->
    <script src="{!! url('public/assets/js/common.min.js') !!}"></script>
    <!-- altair core functions -->
    <script src="{!! url('public/assets/js/altair_admin_common.min.js') !!}"></script>

    <!-- altair login page functions -->
    <script src="{!! url('public/assets/js/pages/login.min.js') !!}"></script>

</body>

 </html>