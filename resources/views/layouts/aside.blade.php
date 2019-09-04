<aside>
<div class="sidebar right ">
<div class="user-panel">
<div class="float-right image">
<img src="http://via.placeholder.com/160x160" class="rounded-circle" alt="User Image">
</div>
<div class="float-right info">
<p style="margin-top:7px; margin-right:5px; font-size:1.4em; text-transform:capitalize;">{{ Auth::user()->name_ar }}</p>
</div>
</div>
<ul class="list-sidebar bg-defoult">
<li> <a href="#" data-toggle="collapse" data-target="#dashboard" class="collapsed active" > <i class="fa fa-th-large"></i> <span class="nav-label"> مستخدمين التطبيق </span> <span class="fa fa-chevron-left float-left"></span> </a>
<ul class="sub-menu collapse" id="dashboard">
<li class="active"><a href="{{ url("../public/hospitals") }}">المستشفيات</a></li>
<li><a href="{{ url("../public/doctors") }}">الأطباء</a></li>
<li><a href="{{ url("../public/users") }}">الزائرين</a></li>
</ul>
</li>
<li> <a href="{{ url("../public/services") }}"><i class="fa fa-diamond"></i> <span class="nav-label">الخدمات</span></a> </li>

<li> <a href="{{ url("../public/states") }}"><i class="fa fa-laptop"></i> <span class="nav-label">حالات وجود الطبيب</span></a> </li>
<li> <a href="#" data-toggle="collapse" data-target="#tables" class="collapsed active" ><i class="fa fa-table"></i> <span class="nav-label">عمليات الزائرين</span><span class="fa fa-chevron-left float-left"></span></a>
<ul  class="sub-menu collapse" id="tables" >
<li><a href="{{ url("../public/ratings") }}">التقييمات</a></li>
<li><a href="{{ url("../public/comments") }}">التعليقات</a></li>
<li><a href="{{ url("../public/contacts") }}">الرسائل</a></li>
</ul>
</li>

<li> <a href="#" data-toggle="collapse" data-target="#tablesone" class="collapsed active" ><i class="fa fa-table"></i> <span class="nav-label">إعدادات الموقع</span><span class="fa fa-chevron-left float-left"></span></a>
<ul  class="sub-menu collapse" id="tablesone" >
<li><a href="{{ url("../public/settings") }}">إعدادات الموقع</a></li>
<li><a href="{{ url("../public/bankaccounts") }}">الحسابات البنكية</a></li>
</ul>
</li>

<li> <a href="{{ url("../public/orders") }}"><i class="fa fa-pie-chart"></i> <span class="nav-label">الحجوزات</span> </a></li>
<li> <a href="{{ url("../public/settings") }}"><i class="fa fa-files-o"></i> <span class="nav-label">إعدادات الموقع</span></a> </li>
<li> <a href="{{ url("../public/statuses") }}"><i class="fa fa-files-o"></i> <span class="nav-label">حالات وصول الطبيب</span></a> </li>
<li> <a href="{{ url("../public/logactivity") }}"><i class="fa fa-files-o"></i> <span class="nav-label">السجل</span></a> </li>
</ul>
</div>
</aside>


</div>

