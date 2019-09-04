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


@endsection

@section('footer')


@endsection
