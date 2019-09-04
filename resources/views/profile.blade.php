@extends('layouts.app')

@section('content')
    
<div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="{{ $user->image }}" alt=""/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                                <h5>
                                    {{ $user->name_ar }}
                                </h5>
                                <h6>
                                    {{ $user->type }}
                                </h6>
                                @if($user->type !== 'client')<p class="proile-rating">التقييم : <span>{{ $user->rating }}</span></p>@endif
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        @if($user->type == 'hospital')
                        <p>الأطباء</p>
                        @foreach($user->doctors as $doctor)
                            <a href="">{{ $doctor->name_ar }}</a><br/>
                        @endforeach
                        <p>الحجوزات</p>
                        @foreach($user->hospitalOrders as $order)
                            <a href="">{{ $order->name }}</a><br/>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>الرقم</label>
                                        </div>
                                        <div class="col-md-6">
                                          <p>{{ $user->id }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>الإسم</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>{{ $user->name_ar }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>البريد الإلكترونى</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>رقم الهاتف</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>{{ $user->mobile }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>النوع</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>{{ $user->type }}</p>
                                        </div>
                                    </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>الوصف باللغة العربية</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>{{ $user->description_ar }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>الوصف باللغة الإنجليزية</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>{{ $user->description_en }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>العنوان</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>{{ $user->address }}</p>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>           
    </div>

@endsection