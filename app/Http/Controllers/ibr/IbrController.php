<?php

namespace App\Http\Controllers\ibr;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Ibr;
use App\Models\IbrDirectCommission;
use App\Models\IbrIndirectCommission;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class IbrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:ibr');
    }

    public function dashboard(): Factory|View|Application
    {
        /* Below code to show direct income data in donut chart in dashboard */
        $ibr_direct_com = IbrDirectCommission::select("ibr_no",
            DB::raw("(sum(amount)) as total"),
            DB::raw("(DATE_FORMAT(created_at, '%b-%Y')) as month_year"))
            ->where('ibr_no', \auth()->user()->ibr_no)
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
            ->get();

        /* Below code to show indirect income data in donut chart in dashboard */
        $ibr_in_direct_com = IbrIndirectCommission::select("ibr_no",
            DB::raw("(sum(amount)) as total"),
            DB::raw("(DATE_FORMAT(created_at, '%b-%Y')) as month_year"))
            ->where('ibr_no', \auth()->user()->ibr_no)
            ->whereMonth('created_at', '<', Carbon::now()->startOfMonth()->subMonthsWithNoOverflow(3))
            ->orWhereMonth('created_at', '>', Carbon::now()->startOfMonth()->subMonthsWithNoOverflow(3))
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
            ->get();

        /* Below code to show data in bar chart in dashboard */
        $direct_indirect_commissions = new Collection();
        /* Because showing two different charts for direct and indirect incomes this $direct_indirect_commissions['months'] is not used for now in charts */
        $direct_indirect_commissions['months'] = collect(today()->startOfMonth()->subMonths(2)->monthsUntil(today()->startOfMonth()))
                                                    ->flatMap(fn ($month) => [$month->month => $month->monthName. '-' .$month->year])
//                                                    ->reverse()
        ;
        /* Below code to show direct income data in bar chart in dashboard */
        $direct_indirect_commissions['direct_commission'] = IbrDirectCommission::select(
                                                                    DB::raw('DATE_FORMAT(created_at, "%M-%Y") as month'),
                                                                    \DB::raw("SUM(amount) as total") )
                                                                ->where('ibr_no', \auth()->user()->ibr_no)
                                                                /* Last 3 months */
                                                                ->whereMonth('created_at', '>', Carbon::now()->startOfMonth()->subMonthsWithNoOverflow(4))
                                                                ->whereMonth('created_at', '<', Carbon::now()->startOfMonth())
                                                                ->groupBy(\DB::raw('MONTH(created_at)'))
                                                                ->get();


        /* Below code to show indirect income data in bar chart in dashboard */
        $direct_indirect_commissions['in_direct_commission'] = IbrIndirectCommission::select(
                                                                    DB::raw('DATE_FORMAT(created_at, "%M-%Y") as month'),
                                                                    \DB::raw("SUM(amount) as total"))
                                                                ->where('ibr_no', \auth()->user()->ibr_no)
                                                                /* Last 3 months */
                                                                ->whereMonth('created_at', '>', Carbon::now()->startOfMonth()->subMonthsWithNoOverflow(4))
                                                                ->whereMonth('created_at', '<', Carbon::now()->startOfMonth())
                                                                ->groupBy(\DB::raw('MONTH(created_at)'))
                                                                ->get();

        return view('ibr.dashboard', compact('ibr_direct_com', 'ibr_in_direct_com', 'direct_indirect_commissions'));
    }

    public function direct_earnings(): Factory|View|Application
    {
        $directEarnings = IbrDirectCommission::with('transaction.business')
            ->where('ibr_no', auth()->guard('ibr')->user()->ibr_no)
            ->get();

        $inDirectEarnings = IbrIndirectCommission::with('directCommission')
            ->where('ibr_no', auth()->guard('ibr')->user()->ibr_no)
            ->get();

        $earnings = $directEarnings->merge($inDirectEarnings);

        return view('ibr.earnings.direct', compact('directEarnings', 'inDirectEarnings', 'earnings'));
    }

    public function in_direct_earnings(): Factory|View|Application
    {
        $directEarnings = IbrDirectCommission::with('transaction.business')
            ->where('ibr_no', auth()->guard('ibr')->user()->ibr_no)
            ->get();

        $inDirectEarnings = IbrIndirectCommission::with('directCommission', 'directCommission.transaction.business')
            ->where('ibr_no', auth()->guard('ibr')->user()->ibr_no)
            ->get();

        $earnings = $directEarnings->merge($inDirectEarnings);

        return view('ibr.earnings.inDirect', compact('directEarnings', 'inDirectEarnings', 'earnings'));
    }

    public function business_referrals(): Factory|View|Application
    {
        $referrals = Business::with('user')
            ->where('ibr', auth()->guard('ibr')->user()->ibr_no)
            ->get();
        return view('ibr.referrals.businessReferrals', compact('referrals'));
    }

    public function ibr_referrals(): Factory|View|Application
    {
        $referrals = Ibr::where('referred_by', auth()->guard('ibr')->user()->ibr_no)
            ->select(['name', 'email', 'mobile_number'])
            ->get();
        return view('ibr.referrals.ibrReferrals', compact('referrals'));
    }

    public function profileEdit(): Factory|View|Application
    {
        return view('ibr.credentials.edit');
    }

    public function profileUpdate(Request $request): RedirectResponse
    {
        Validator::make($request->all(), [
            'password' => ['required', 'confirmed'],
            'current_password' => ['required'],
        ])->validate();

        if ($request->current_password != '') {
            if (!(Hash::check($request->get('current_password'), Auth::guard('ibr')->user()->getAuthPassword()))) {
                return redirect()->back()->with('error', 'Current password not matched');
            }
        }
        if ($request->password != '') {
            if (strcmp($request->get('current_password'), $request->get('password')) == 0) {
                return redirect()->back()->with('error', 'Your current password cannot be same to new password');
            }
        }

        Ibr::where('id', auth()->guard('ibr')->id())->update(['password' => Hash::make($request->password)]);
        return redirect()->route('ibr.dashboard')->with('success', __('portal.Profile updated successfully!!'));

    }
}
