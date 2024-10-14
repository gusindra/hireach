<?php

namespace App\Http\Controllers;

use App\Exports\ExportLogAdmin;
use App\Models\CommerceItem;
use App\Models\Company;
use App\Models\LogChange;
use App\Models\ProductLine;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public $user_info;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Your auth here
            $granted = false;
            $user = auth()->user();
            $granted = userAccess('SETTING');
            if ($granted) {
                return $next($request);
            }
            abort(403);
        });
    }

    public function index()
    {
        return view('settings.company.companies');
        // return view('role.role-table', ['page' => 'role']);
    }

    /**
     * show
     *
     * @param  mixed $page
     * @return mixed
     */
    public function show($page)
    {
        // return $page;
        if ($page == "company") {
            return view('settings.company.companies', ['page' => $page]);
        }
        if ($page == "general") {
            return view('settings.general', ['page' => $page]);
        }
        return view('role.role-detail', ['page' => $page]);
    }

    public function company(Request $request)
    {
        return $request;
        if($request->page=='price'){
            return view('settings.company.companies');
        }
        return view('settings.general');
    }

    public function logChange()
    {
        return view('settings.log-change');
    }

    /**
     * logExport
     *
     * @param  mixed $request
     * @return void
     */
    public function logExport(Request $request)
    {
        $file = Excel::download(new ExportLogAdmin, date('d-m-y') . '_log.xlsx');
        if($request->action=="clear"){
            LogChange::truncate();
        }
        return $file;
    }

    /**
     * companyShow
     *
     * @param  App\Models\Company $company
     * @return mixed
     */
    public function companyShow(Company $company)
    {
        return view('settings.company.details', ['company' => $company]);
    }

    /**
     * commerceItemShow
     *
     * @param  App\Models\CommerceItem $commerceItem
     * @return mixed
     */
    public function commerceItemShow(CommerceItem $commerceItem)
    {
        return view('settings.commerce-item.details', ['commerceItem' => $commerceItem]);
    }

    /**
     * productLineShow
     *
     * @param  App\Models\ProductLine $productLine
     * @return mixed
     */
    public function productLineShow(ProductLine $productLine)
    {
        return view('settings.product-line.details', ['productLine' => $productLine]);
    }
}
