<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\BlastMessage;
use App\Models\Client;
use App\Models\CommerceItem;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Order;
use App\Models\Project;
use App\Models\Provider;
use App\Models\Request as ModelsRequest;
use App\Models\SaldoUser;
use App\Models\User;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class DashboardController extends Controller
{
    public $user_info;


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Your auth here
            $granted = false;
            $user = auth()->user();
            $granted = userAccess('DASHBOARD');
            if ($granted) {
                return $next($request);
            }
            abort(403);
        });
    }

    public function index(Request $request)
    {
        $userId = FacadesAuth::user()->id;
        // return count(auth()->user()->listTeams);
        if (count(auth()->user()->listTeams)== 0) {
            return redirect()->route('teams.create');
        }

        if ($request->has('v')) {
            $dateS = Carbon::now()->startOfMonth();
            $dateE = Carbon::now()->startOfMonth()->addMonth(1);
            $event = Contract::whereBetween('expired_at', [$dateS, $dateE])->get();

            $arr_event = array();
            $stat = array();

            $stat['client'] = Client::where('user_id', auth()->user()->id)->count();
            $stat['project'] = Project::count();
            $stat['order'] = Order::where('user_id', auth()->user()->id)->count();
            $stat['product'] = CommerceItem::where('user_id', auth()->user()->id)->count();

            foreach ($event as $key => $ev) {
                $arr_event[$key]['title'] = $ev->title;
                $arr_event[$key]['start'] = $ev->expired_at->format('Y-m-d');
                $arr_event[$key]['end'] = $ev->expired_at->format('Y-m-d');
                $arr_event[$key]['className'] = 'bg-gradient-to-tl from-red-600 to-rose-400';
                $arr_event[$key]['url'] = url("/commercial/contract/" . $ev->id);
            }

            return view('main-side.dashboard', ['event' => $arr_event, 'stat' => $stat]);
        } else {
            return view('dashboard', ['userId' => $userId]);
        }
    }

    public function show(Request $request)
    {

        if (empty(auth()->user()->currentTeam)) {
            return redirect()->route('teams.create');
        }

        if ($request->has('v')) {

            $dateS = Carbon::now()->startOfMonth();
            $dateE = Carbon::now()->startOfMonth()->addMonth(1);
            $event = Contract::whereBetween('expired_at', [$dateS, $dateE])->get();

            $arr_event = array();
            $stat = array();

            $stat['client'] = Client::where('user_id', auth()->user()->id)->count();
            $stat['project'] = Project::count();
            $stat['order'] = Order::where('user_id', auth()->user()->id)->count();
            $stat['product'] = CommerceItem::where('user_id', auth()->user()->id)->count();

            foreach ($event as $key => $ev) {
                $arr_event[$key]['title'] = $ev->title;
                $arr_event[$key]['start'] = $ev->expired_at->format('Y-m-d');
                $arr_event[$key]['end'] = $ev->expired_at->format('Y-m-d');
                $arr_event[$key]['className'] = 'bg-gradient-to-tl from-red-600 to-rose-400';
                $arr_event[$key]['url'] = url("/commercial/contract/" . $ev->id);
            }

            return view('main-side.dashboard', ['event' => $arr_event, 'stat' => $stat]);
        } else {
            return view('admin');
        }
    }

    /**
     * getOutBound
     *
     * @return mixed
     */
    public function getOutBound()
    {
        $currentMonth = now()->format('Y-m');
        $filterMonth = request()->input('filterMonth', $currentMonth);
        $year = substr($filterMonth, 0, 4);
        $month = substr($filterMonth, 5, 2);

        $requestsCount = ModelsRequest::where('is_inbound', 0)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $requestsClients = ModelsRequest::where('is_inbound', 0)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('client_id')
            ->distinct('client_id')
            ->count();

        $failRequest = ModelsRequest::where('is_inbound', 0)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', 'UNDELIVERED')
            ->count();

        $successRequest = ModelsRequest::where('is_inbound', 0)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', ['ACCEPTED', 'SENT', 'DELIVERED', 'READ', 'PENDING'])
            ->count();


        $blastMessageCount = BlastMessage::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();


        $blastMessageClientCount = BlastMessage::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('client_id')
            ->count();


        $blastMessageSuccessCount = BlastMessage::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', ['ACCEPTED', 'SENT', 'DELIVERED', 'READ', 'PENDING', 'PROCESS'])
            ->count();

        $blastMessageFailCount = BlastMessage::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', 'UNDELIVERED')
            ->count();


        $totalCount = $blastMessageCount + $requestsCount;
        $totalSuccessCount = $successRequest + $blastMessageSuccessCount;
        $totalFailCount = $failRequest + $blastMessageFailCount;

        return view(
            'dashboard.out-bound',
            compact(
                'filterMonth',
                'requestsCount',
                'requestsClients',
                'failRequest',
                'successRequest',
                'blastMessageCount',
                'totalCount',
                'totalFailCount',
                'totalSuccessCount',
                'blastMessageClientCount',
                'blastMessageSuccessCount',
                'blastMessageFailCount'
            )
        );
    }

    /**
     * getInBound
     *
     * @return mixed
     */
    public function getInBound()
    {

        $currentMonth = now()->format('Y-m');
        $filterMonth = request()->input('filterMonth', $currentMonth);
        $year = substr($filterMonth, 0, 4);
        $month = substr($filterMonth, 5, 2);

        $requestsCount = ModelsRequest::where('is_inbound', 1)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $requestsClients = ModelsRequest::where('is_inbound', 1)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->distinct('client_id')
            ->count('client_id');

        $failRequest = ModelsRequest::where('is_inbound', 1)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', 'UNDELIVERED')
            ->count();

        $successRequest = ModelsRequest::where('is_inbound', 1)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', ['ACCEPTED', 'SENT', 'DELIVERED', 'READ', 'PENDING'])
            ->count();

        return view(
            'dashboard.in-bound',
            compact(
                'filterMonth',
                'requestsCount',
                'requestsClients',
                'failRequest',
                'successRequest',

            )
        );
    }

    /**
     * activeUser
     *
     * @return mixed
     */
    public function activeUser()
    {
        return view('user.user-active-user');
    }

    public function orderSummary(User $user)
    {
        return view('dashboard-order-summary', ['user' => $user]);
    }
    public function revenueSummary(User $user)
    {
        $status = request('status', '');

        $totalOrders = Order::when($status !== '', function ($query) use ($status) {
            return $query->where('status', $status);
        })
        ->whereBetween('date', [Carbon::now()->subMonth(), Carbon::now()])
        ->sum('total');

        $totalBillings = Billing::when($status !== '', function ($query) use ($status) {
            return $query->where('status', $status);
        })
        ->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()])
        ->sum('amount');

        $totalRevenue = $totalOrders + $totalBillings;

        return view('dashboard-revenue-summary', [
            'user' => $user,
            'totalRevenue' => $totalRevenue
        ]);
    }



    public function providerSummary()
    {
        // Ambil semua provider beserta saldo terbaru dan blast messages
        $providers = Provider::with(['saldoUsers' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'blastMessages'])->get();

        foreach ($providers as $provider) {
            $provider->latestBalance = $provider->saldoUsers->isNotEmpty() ? $provider->saldoUsers->first()->balance : 0;
            $provider->totalUsage = $provider->blastMessages->sum('price');
        }


        return view('dashboard-provider-summary', compact('providers'));
    }



    public function consumptionSummary(){
            $providers = Provider::with(['saldoUsers' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'blastMessages'])->get();

        $oneWay = BlastMessage::count();
        $twoWay = ModelsRequest::count();
        foreach ($providers as $provider) {
            $provider->latestBalance = $provider->saldoUsers->isNotEmpty() ? $provider->saldoUsers->first()->balance : 0;
            $provider->totalUsage = count( $provider->blastMessages);
        }
        $all = $oneWay + $twoWay;

        return view('dashboard-consumption-summary',compact('providers','oneWay','twoWay','all'));

    }



}
