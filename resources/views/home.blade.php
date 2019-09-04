@extends('layouts.app')
@section('title', 'AtHomeCare Admin Panel')




@section('content')
        
<div class="row">
<div class="col-md-12">
<div class="card">
        <h5 class="card-header">
            <div class="col-md-12 text-center title">مرحبا بك مجدداً {{ Auth::user()->name_ar }}</div>
        </h5>
<div class="card-body">

<div class="container-fluid">
<div class="row">

<div class="col-md-3">
<div class="card-counter primary">
<i class="fas fa-file"></i>
<span class="count-numbers">{{ $ordersToday }}</span>
<span class="count-name">حجوزات اليوم</span>
</div>
</div>
<div class="col-md-3">
<div class="card-counter danger">
<i class="fas fa-file-invoice"></i>
<span class="count-numbers">{{ $ordersSucceededToday }}</span>
<span class="count-name">حجوزات تمت اليوم</span>
</div>
</div>
<div class="col-md-3">
<div class="card-counter success">
<i class="fas fa-file-invoice-dollar"></i>
<span class="count-numbers">{{ $ordersPaidToday }}</span>
<span class="count-name">حجوزات تم دفعها اليوم</span>
</div>
</div>

<div class="col-md-3">
<div class="card-counter success">
<i class="fas fa-user"></i>
<span class="count-numbers">{{ $clientsToday }}</span>
<span class="count-name">عملاء جدد اليوم</span>
</div>
</div>


</div>
</div>   


</div>

<div class="card-footer">
        <div class="col-md-12"><button class="btn btn-primary col-md-6 offset-md-3">تحميل التقرير اليومى</button></div>
</div>

</div>
</div>


</div>

     
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">
                <div class="col-md-12 text-center title">الإحصائيات</div>
            </h5>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                الحجوزات
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $orders }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                المستشفيات
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $hospitals }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                الأطباء
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $doctors }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                الخدمات
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $services }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                حجوزات ناجحة
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $ordersSucceeded }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                حجوزات جارية
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $ordersPending }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                حجوزات مدفوعة
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $ordersPaid }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                حجوزات جديدة
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $ordersNew }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                مستشفيات جديدة
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $hospitalsNew }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                أطباء جدد
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $doctorsNew }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                رسائل جديدة
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $contactsNew }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="circle-tile">
                                                        <a href="#">
                                                            <div class="circle-tile-heading green">
                                                                <i class="fa fa-money fa-fw fa-3x"></i>
                                                            </div>
                                                        </a>
                                                        <div class="circle-tile-content green">
                                                            <div class="circle-tile-description text-faded">
                                                                الحسابات البنكية
                                                            </div>
                                                            <div class="circle-tile-number text-faded">
                                                                {{ $bankaccountsNumber }}
                                                            </div>
                                                            <a href="#" class="circle-tile-footer">عرض التفاصيل <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{--

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $ordersYear->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $clientsYear->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
                <h5 class="card-header">
                    <div class="col-md-12 text-center title">تفاصيل الحجوزات</div>
                </h5>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $bestSales->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="card circle-p">
                <h5 class="card-header">
                    <div class="col-md-12 text-center title">تفاصيل الحجوزات</div>
                </h5>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $topDoctors->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card profile-card-5">
            <div class="card-img-block">
                <img class="card-img-top" src="{{ Auth::user()->image }}" alt="Card image cap">
            </div>
            <div class="card-body pt-0">
            <h5 class="card-title">{{ Auth::user()->name_ar }}</h5>
            <p class="card-text">{{ Auth::user()->description_ar }}</p>
            <a href="#" class="btn btn-primary">مشاهدة البروفايل</a>
            </div>
        </div>
    </div>

</div>





<div class="row">
    <div class="col-md-12">
        <div class="card">
                <h5 class="card-header">
                    <div class="col-md-12 text-center title">الفواتير</div>
                </h5>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                    <thead>
                                        <tr>
                                        <th>إسم المستشفى</th>
                                        <th>الرابط</th>
                                        <th>الحجوزات</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>{{ $invoice->hospital->name_ar }}</td>
                                                <td>{{ $invoice->url }}</td>
                                                <td>vyas</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="row">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">
                        <div class="col-md-12 text-center title">السجل</div>
                </h5>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="timeline">
                                    @foreach($activity as $a)
                                        <li>
                                            <a target="_blank" href="https://www.totoprayogo.com/#">User</a>
                                            <a href="#" style="padding-left: 23px;" class="float-right">{{ $a->created_at }}</a>
                                            <p>{{ $a->description }}</p>
                                        </li>
                                    @endforeach    
                                </ul>           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <div class="col-md-6">
        <div class="card">
                <h5 class="card-header">
                        <div class="col-md-12 text-center title">اخر المستشفيات المضافة</div>
                </h5>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                                <table>
                                        <thead>
                                            <tr>
                                            <th>الإسم باللغة العربية</th>
                                            <th>الإسم باللغة الإنجليزية</th>
                                            <th>الوصف</th>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">
                                           
                                            @foreach ($hospitalsNewShow as $hospital)
                                                <tr>
                                                    <td>{{ $hospital->name_ar }}</td>
                                                    <td>{{ $hospital->name_en }}</td>
                                                    <td>{{ $hospital->description_ar }}</td>
                                                </tr>
                                            @endforeach
                                            
                                            
                                        </tbody>
                                    </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card profile-card-3">
            <div class="background-block">
                <img src="https://images.pexels.com/photos/459225/pexels-photo-459225.jpeg?auto=compress&cs=tinysrgb&h=650&w=940" alt="profile-sample1" class="background"/>
            </div>
            <div class="profile-thumb-block">
                <img src="https://randomuser.me/api/portraits/men/41.jpg" alt="profile-image" class="profile"/>
            </div>
            <div class="card-content">
            <h2>Justin Mccoy<small>Designer</small></h3>
            <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div>
            </div>
        </div>

    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card">
                <h5 class="card-header">
                        <div class="col-md-12 text-center title">إحصائيات شهر {{ \Carbon\Carbon::now()->month }}</div>
                </h5>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                        <h3 class="bars">المستشفيات</h3>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $hospitalsInMonthPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ $hospitalsInMonthPercentage }}</div>
                                        </div>
                                        <h3 class="bars">الأطباء</h3>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $doctorsInMonthPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ $doctorsInMonthPercentage }}</div>
                                        </div>
                                        <h3 class="bars">الفواتير</h3>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $invoicesInMonthPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ $invoicesInMonthPercentage }}</div>
                                        </div>
                                        <h3 class="bars">مستخدمين التطبيق</h3>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $usersInMonthPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ $usersInMonthPercentage }}</div>
                                        </div>
                                        <h3 class="bars">الطلبات الجارية</h3>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $ordersPendingInMonthPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ $ordersPendingInMonthPercentage }}</div>
                                        </div>
                                        <h3 class="bars">الطلبات المنتهية</h3>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $ordersPaidInMonthPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ $ordersPaidInMonthPercentage }}</div>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    {!! $topHospitalOrders->container() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-header">
                <div class="col-md-12 text-center title">عنوان</div>
            </h5>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @foreach ($users as $user)
                                <img class="rounded-circle" src="{{ $user->image }}" width="100" height="100" alt="Card image cap">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <h5 class="card-header">
                <div class="col-md-12 text-center title">عنوان</div>
            </h5>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $ordersMonths->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>






<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">
                    <div class="col-md-12 text-center title">المستشفيات الموجودة حول العالم</div>
            </h5>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" id="pop-div">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


--}}

@endsection

@section('footer')


@endsection
