
  <header>
<!--
    <div class="dropdown language-main">
      <button class="btn btn-default dropdown-toggle language-button" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Dropdown
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu language-menu" aria-labelledby="dropdownMenu1">
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Separated link</a></li>
      </ul>
    </div>
-->
    
    <nav class="navbar navbar-default menu">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="{{ asset('storage/img/grooki.jpg') }}"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active-link"><a href="#">@lang('main')</a></li>
            <li><a href="#">@lang('support')</a></li>
            <li><a href="#">@lang('blog')</a></li>
            <li><a href="#">@lang('contacts')</a></li>
            <li>
                <div class="dropdown language-main">
                  <div class="dropbtn {{ $language }}">{{ $language }}</div>
                  <div class="dropdown-content">
                    <a href="/en">EN</a>
                    <a href="/ru">RU</a>
                  </div>
                </div>
            </li>    
            
          </ul>
          <ul class="nav navbar-nav navbar-right icons">
            <li><a href="#"><img src="{{ asset('storage/img/facebook.png') }}"></a></li>
            <li><a href="#"><img src="{{ asset('storage/img/twitter.png') }}"></a></li>
            <li><a href="#"><img src="{{ asset('storage/img/google_plus.png') }}"></a></li>
            <li><a href="#"><img src="{{ asset('storage/img/rss.png') }}"></a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
        <i class="glyphicon glyphicon-globe globe" aria-hidden="true"></i>
      </div><!-- /.container -->
    </nav>
  </header>
