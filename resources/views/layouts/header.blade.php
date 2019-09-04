<header class="header">
        <nav class="navbar navbar-expand-sm navbar-toggleable-md navbar-light pt-0 ">
          <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="nav-wrapper">
            <a class="navbar-brand text-center mt-1" href="#">
              <img src="{{ asset("images/logo.png") }}" height="30">
                <h6>At Home Care
                <br/>نرعاك</h6>
            </a>
            <div class="float-right"> <a href="#" class="button-right"><i class="fas fa-th"></i></a> </div>
          </div>
          <div class="collapse navbar-collapse flex-row-reverse ml-5" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item dropdown messages-menu">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" data-target="#notifications" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-success bg-success">{{ count($contact) }}</span>
                </a>
                <div class="dropdown-menu" id="notifications" aria-labelledby="navbarDropdownMenuLink">
                  <ul class="dropdown-menu-over list-unstyled">
                    <li class="header-ul text-center">لديك {{ count($contact) }} رسائل جديدة</li>
                    <li>
                      <!-- inner menu: contains the actual data -->
                      <ul class="menu list-unstyled">
                        @foreach($contact as $c)
                        <li><!-- start message -->
                        <a href="#">
                          <div class="float-right">
                            <img src="http://via.placeholder.com/160x160" class="rounded-circle  " alt="User Image">
                          </div>
                          <h4>
                          {{ $c->name }}
                          <small><i class="fa fa-clock-o"></i>{{ $c->created_at }}</small>
                          </h4>
                          <p>{{ $c->text }}</p>
                        </a>
                      </li>
                      @endforeach
                      <!-- end message -->
                    </ul>
                  </li>
                  <li class="footer-ul text-center"><a href="{{ url("../public/contacts") }}">مشاهدة كل الرسائل</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item dropdown notifications-menu">
              <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" data-target="#messages" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-warning bg-warning">{{ count($activity) }}</span>
              </a>
              <div id="messages" class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <ul class="dropdown-menu-over list-unstyled">
                  <li class="header-ul text-center">لديك {{ count($activity) }} إشعارات جديدة</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu list-unstyled">
                      <li>
                        @foreach($activity as $a)
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> {{ $a->description }}
                        </a>
                        @endforeach
                      </li>
                    </ul>
                  </li>
                  <li class="footer-ul text-center"><a href="{{ url("../public/activitylog") }}">مشاهدة الكل</a></li>
                </ul>
              </div>
            </li>
            
            <li class="nav-item dropdown  user-menu">
              <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" data-target="#actions" aria-haspopup="true" aria-expanded="false">
                <img src="{{ Auth::user()->image }}" class="user-image" alt="User Image" >
                <span class="hidden-xs">{{ Auth::user()->name_ar }}</span>
              </a>
              <div class="dropdown-menu" id="actions" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    تسجيل الخروج
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>             
             </div>
            </li>
          </ul>
        </div>
      </nav>
    </header>