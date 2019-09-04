<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Service;
use App\Status;
use App\Setting;
use App\Contact;
use App\Order;
use App\Doctor;
use Carbon\Carbon;
/*use App\Charts\OrdersMonths;
use App\Charts\OrdersYear;
use App\Charts\DoctorsYear;
use App\Charts\ClientsYear;
use App\Charts\BestSales;
use App\Charts\TopHospitalOrders;
use Khill\Lavacharts\Lavacharts;*/
use Spatie\Activitylog\Models\Activity;
use DB;
use App\BankAccount;
use App\Invoice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
       /* $today_users = User::count();
        $yesterday_users = User::whereDate('created_at', today())->count();
        $users_2_days_ago = User::whereDate('created_at', today()->subDays(2))->count();*/
       
        /*-- Charts Variables --*/

        /*$ordersJan = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 1)->count();
        $ordersFeb = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 2)->count();
        $ordersMar = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 3)->count();
        $ordersAbr = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 4)->count();
        $ordersMay = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 5)->count();
        $ordersJun = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 6)->count();
        $ordersJul = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 7)->count();
        $ordersAug = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 8)->count();
        $ordersSep = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 9)->count();
        $ordersOct = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 10)->count();
        $ordersNov = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 11)->count();
        $ordersDec = Order::whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 12)->count();


        $clientsJan = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 1)->count();
        $clientsFeb = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 2)->count();
        $clientsMar = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 3)->count();
        $clientsAbr = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 4)->count();
        $clientsMay = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 5)->count();
        $clientsJun = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 6)->count();
        $clientsJul = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 7)->count();
        $clientsAug = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 8)->count();
        $clientsSep = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 9)->count();
        $clientsOct = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 10)->count();
        $clientsNov = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 11)->count();
        $clientsDec = User::whereType('client')->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 12)->count();


        $bestHospitalSales = Order::max('hospital_id');

        $bestHospitalSalesJan = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 1)->count();
        $bestHospitalSalesFeb = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 2)->count();
        $bestHospitalSalesMar = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 3)->count();
        $bestHospitalSalesAbr = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 4)->count();
        $bestHospitalSalesMay = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 5)->count();
        $bestHospitalSalesJun = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 6)->count();
        $bestHospitalSalesJul = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 7)->count();
        $bestHospitalSalesAug = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 8)->count();
        $bestHospitalSalesSep = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 9)->count();
        $bestHospitalSalesOct = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 10)->count();
        $bestHospitalSalesNov = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 11)->count();
        $bestHospitalSalesDec = Order::whereHospitalId($bestHospitalSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 12)->count();


        $bestDoctorSales = Order::min('doctor_id');

        $bestDoctorSalesJan = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 1)->count();
        $bestDoctorSalesFeb = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 2)->count();
        $bestDoctorSalesMar = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 3)->count();
        $bestDoctorSalesAbr = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 4)->count();
        $bestDoctorSalesMay = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 5)->count();
        $bestDoctorSalesJun = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 6)->count();
        $bestDoctorSalesJul = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 7)->count();
        $bestDoctorSalesAug = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 8)->count();
        $bestDoctorSalesSep = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 9)->count();
        $bestDoctorSalesOct = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 10)->count();
        $bestDoctorSalesNov = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 11)->count();
        $bestDoctorSalesDec = Order::whereDoctorId($bestDoctorSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 12)->count();


        $bestClientSales = Order::min('client_id');

        $bestClientSalesJan = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 1)->count();
        $bestClientSalesFeb = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 2)->count();
        $bestClientSalesMar = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 3)->count();
        $bestClientSalesAbr = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 4)->count();
        $bestClientSalesMay = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 5)->count();
        $bestClientSalesJun = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 6)->count();
        $bestClientSalesJul = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 7)->count();
        $bestClientSalesAug = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 8)->count();
        $bestClientSalesSep = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 9)->count();
        $bestClientSalesOct = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 10)->count();
        $bestClientSalesNov = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 11)->count();
        $bestClientSalesDec = Order::whereClientId($bestClientSales)->whereYear('created_at' , Carbon::now()->year)->whereMonth('created_at' , 12)->count();

        $topHospitalOrdersNames = DB::table('orders')
        ->select('hospital_id', DB::raw('COUNT(hospital_id) as orders'))
        ->groupBy('hospital_id')
        ->orderBy(DB::raw('COUNT(hospital_id)'), 'DESC')
        ->take(3)
        ->get();

        $topHospitalOrdersNamesByMonth = DB::table('orders')
        ->select('hospital_id', DB::raw('COUNT(hospital_id) as orders'))
        ->whereMonth('created_at' , Carbon::now()->month)
        ->groupBy('hospital_id')
        ->orderBy(DB::raw('COUNT(hospital_id)'), 'DESC')
        ->take(5)
        ->get();

        $thonnames = [];
        $thonorders = [];

        foreach($topHospitalOrdersNames as $thon){

            array_push($thonnames , $thon->hospital_id);
            array_push($thonorders , $thon->orders);
        }


        $topHospitalOrdersNamesByMonth = DB::table('orders')
        ->select('hospital_id', DB::raw('COUNT(hospital_id) as orders'))
        ->whereMonth('created_at' , Carbon::now()->month)
        ->groupBy('hospital_id')
        ->orderBy(DB::raw('COUNT(hospital_id)'), 'DESC')
        ->take(5)
        ->get();
        
        $thonnamesmonth = [];
        $thonordersmonth = [];

        foreach($topHospitalOrdersNamesByMonth as $thonmonth){
            array_push($thonnamesmonth , $thonmonth->hospital_id);
            array_push($thonordersmonth , $thonmonth->orders);
        }*/

        /*-- Charts Variables --*/


        /*$ordersYear = new OrdersYear;
        $ordersYear->labels(['يناير', 'فبراير', 'مارس', 'إبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر']);
        $ordersYear->dataset('My dataset', 'line', [$ordersJan,$ordersFeb, $ordersMar, $ordersMay ,$ordersJun ,$ordersJul,$ordersAug,$ordersSep,$ordersOct,$ordersNov,$ordersDec])->options(['exporting' => ['width' => '600']]);
        $ordersYear->height(200);
        $ordersYear->displayAxes(false);
        $ordersYear->displayLegend(false);
    

        $clientsYear = new ClientsYear;
        $clientsYear->labels(['يناير', 'فبراير', 'مارس', 'إبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر']);
        $clientsYear->dataset('My dataset', 'line', [$clientsJan,$clientsFeb, $clientsMar, $clientsMay ,$clientsJun ,$clientsJul,$clientsAug,$clientsSep,$clientsOct,$clientsNov,$clientsDec]);
        $clientsYear->height(200);
        $clientsYear->displayAxes(false);
        $clientsYear->displayLegend(false);

        $bestSales = new BestSales;
        $bestSales->labels(['يناير', 'فبراير', 'مارس', 'إبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر']);
        $bestSales->dataset('My dataset', 'line', [$bestHospitalSalesJan,$bestHospitalSalesFeb, $bestHospitalSalesMar, $bestHospitalSalesMay ,$bestHospitalSalesJun ,$bestHospitalSalesJul,$bestHospitalSalesAug,$bestHospitalSalesSep,$bestHospitalSalesOct,$bestHospitalSalesNov,$bestHospitalSalesDec]);
        $bestSales->dataset('My dataset', 'line', [$bestDoctorSalesJan,$bestDoctorSalesFeb, $bestDoctorSalesMar, $bestDoctorSalesMay ,$bestDoctorSalesJun ,$bestDoctorSalesJul,$bestDoctorSalesAug,$bestDoctorSalesSep,$bestDoctorSalesOct,$bestDoctorSalesNov,$bestDoctorSalesDec]);
        $bestSales->dataset('My dataset', 'line', [$bestClientSalesJan,$bestClientSalesFeb, $bestClientSalesMar, $bestClientSalesMay ,$bestClientSalesJun ,$bestClientSalesJul,$bestClientSalesAug,$bestClientSalesSep,$bestClientSalesOct,$bestClientSalesNov,$bestClientSalesDec]);

        $topDoctors = new DoctorsYear;
        $topDoctors->labels($thonnames);
        $topDoctors->dataset('My dataset', 'pie', $thonorders);
        $topDoctors->displayAxes(false);
        $topDoctors->displayLegend(false);

        $ordersMonths = new OrdersMonths;
        $ordersMonths->labels($thonnamesmonth);
        $ordersMonths->dataset('My dataset', 'bar', $thonordersmonth);
        $clientsYear->displayLegend(false);

        $topHospitalOrders = new TopHospitalOrders;
        $topHospitalOrders->labels($thonnames);
        $topHospitalOrders->dataset('My dataset', 'doughnut', $thonorders);
        $topHospitalOrders->options([
            'scales' => [
              'xAxes' => [
                'gridLines'=> [
                   'lineWidth' => 0
                ]
              ],
              'yAxes' => [
                'gridLines'=> [
                   'lineWidth' => 0
                ]
              ],
            ],
          ]);
        $clientsYear->displayAxes(false);
        $clientsYear->displayLegend(false);

        $lava = new Lavacharts; // See note below for Laravel

        $popularity = $lava->DataTable();

        $popularity->addStringColumn('Country')
                ->addNumberColumn('Popularity')
                ->addRow(array('Germany', 200))
                ->addRow(array('United States', 300))
                ->addRow(array('Brazil', 400))
                ->addRow(array('Canada', 500))
                ->addRow(array('France', 600))
                ->addRow(array('RU', 700));

        $lava->GeoChart('Popularity', $popularity);*/

        $ordersToday = Order::whereDay('created_at', Carbon::now()->day)->count();
        $ordersSucceededToday = Order::whereDay('created_at', Carbon::now()->day)->whereHas('state', function ($query) {
            $query->whereId(4);
        })->count();
        $ordersPaidToday = Order::whereDay('created_at', Carbon::now()->day)->whereHas('state', function ($query) {
            $query->whereId(5);
        })->count();
        $clientsToday = User::whereDay('created_at', Carbon::now()->day)->whereType('client')->count();

        $orders = Order::count();
        $hospitals = User::where('type' , 'hospital')->count();
        $doctors = Doctor::count();
        $services = Service::count();
        $activity = Activity::limit(12)->get();

        $ordersSucceeded = Order::whereHas('state', function ($query) {
            $query->whereId(4);
        })->count();
        $ordersPending = Order::whereHas('state', function ($query) {
            $query->whereId(1)->orWhere('id' , 2);
        })->count();
        $ordersPaid = Order::whereHas('state', function ($query) {
            $query->whereId(5);
        })->count();
        $ordersNew = Order::whereDay('created_at', Carbon::now()->day)->whereHas('state', function ($query) {
            $query->whereId(1);
        })->count();
        $hospitalsNew = User::whereType('hospital')->whereMonth('created_at' , Carbon::now()->month)->count();
        $doctorsNew = User::whereType('doctor')->whereMonth('created_at' , Carbon::now()->month)->count();
        $contactsNew = Contact::whereMonth('created_at' , Carbon::now()->month)->count();
        $bankaccountsNumber = BankAccount::whereMonth('created_at' , Carbon::now()->month)->count();
        
        $hospitalsNewShow = User::whereType('hospital')->whereMonth('created_at' , Carbon::now()->month)->get();

        $invoices = Invoice::with('hospital')->get();


        $hospitalsInMonth = User::whereType('hospital')->whereMonth('created_at' , Carbon::now()->month)->count();
        $hospitalsInMonthPercentage = $hospitalsInMonth / 100 * 100;
        $doctorsInMonth = User::whereType('doctor')->whereMonth('created_at' , Carbon::now()->month)->count();
        $doctorsInMonthPercentage = $doctorsInMonth / 100 * 100;

        $invoicesInMonth = User::whereType('hospital')->whereMonth('created_at' , Carbon::now()->month)->count();
        $invoicesInMonthPercentage = $invoicesInMonth / 100 * 100;

        $usersInMonth = User::whereType('doctor')->whereMonth('created_at' , Carbon::now()->month)->count();
        $usersInMonthPercentage = $usersInMonth / 100 * 100;

        $ordersPendingInMonth = User::whereType('hospital')->whereMonth('created_at' , Carbon::now()->month)->count();
        $ordersPendingInMonthPercentage = $ordersPendingInMonth / 100 * 100;

        $ordersPaidInMonth = User::whereType('doctor')->whereMonth('created_at' , Carbon::now()->month)->count();
        $ordersPaidInMonthPercentage = $ordersPaidInMonth / 100 * 100;

        $users = User::limit(16)->get();

        return view('home' , compact('ordersToday','ordersSucceededToday','ordersPaidToday','clientsToday','ordersYear','orders','hospitals','doctors','services','ordersSucceeded','ordersPending','ordersPaid','hospitalsNew','doctorsNew','contactsNew','bankaccountsNumber','ordersNew','clientsYear','bestSales','invoices','hospitalsInMonthPercentage','doctorsInMonthPercentage','invoicesInMonthPercentage','usersInMonthPercentage','ordersPendingInMonthPercentage','ordersPaidInMonthPercentage','ordersMonths','topHospitalOrders','hospitalsNewShow','lava','activity','contact','activity','bestHospitalSales','bestDoctorSales','bestClientSales','topHospitalOrdersnames','topDoctors','users'));
    }


    public function services()
    {
        return view('services'); 
    }

    public function states()
    {
        
        return view('states'); 
    }

    public function statuses()
    {
        return view('statuses'); 
    }

    public function hospitals() 
    {
        $services = Service::all();

        return view('hospitals' , compact('services')); 
    }

    public function doctors()
    {   
        $hospitals = User::where('type' , 'hospital')->get();
        $services = Service::all();
        $statuses = Status::all();

        return view('doctors' , compact('services','statuses','hospitals')); 
    }
    public function comments()
    {
        return view('comments'); 
    }
    public function users()
    {
        return view('users'); 
    }
    public function profile($id){
        $user = User::whereId($id)->with(['hospitalOrders','doctors'])->first();
        return view('profile', compact('user'));
    }
    public function settings()
    {
        $settings = Setting::findOrFail(1);
        return view('settings', compact('settings')); 
    }
    public function orders()
    {
        return view('orders' , compact('orders'));
    }
    public function hospitalorders($id)
    {
        $hospital_id = $id;
        return view('hospitalorders' , compact('hospital_id'));
    }
    public function contacts()
    {
        return view('contacts' , compact('contacts'));
    }
    public function bankaccounts()
    {
        return view('bankaccounts' , compact('bankaccounts'));
    }
    public function invoices()
    {
        return view('invoices' , compact('invoices'));
    }
    public function invoice($id)
    {
        $hospital_id = $id;
        return view('invoice' , compact('hospital_id'));
    }
    public function ratings()
    {
        return view('ratings');
    }

    public function activityLog()
    {
        $activity = Activity::all();

        return view('activitylog', compact('activity'));
    }
}
