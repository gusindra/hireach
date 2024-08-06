<?php

namespace App\Http\Controllers;

use App\Models\CommerceItem;
use App\Models\Company;
use App\Models\Permission;
use App\Models\ProductLine;
use Auth;

class SettingController extends Controller
{
    public $user_info;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Your auth here
            $granted = false;
            $user = auth()->user();
            $granted = userAccess('SETTINGS');
            if ($granted) {
                return $next($request);
            }
            abort(403);
        });
    }

    public function index()
    {
        return view('role.role-table', ['page' => 'role']);
    }

    public function show($page)
    {
        // return $page;
        if ($page == "company") {
            return view('settings.company.companies', ['page' => $page]);
        }
        return view('role.role-detail', ['page' => $page]);
    }


    public function company()
    {
        return view('settings.company.companies');
    }
    public function logChange()
    {

        return view('settings.log-change');
    }

    public function companyShow(Company $company)
    {
        return view('settings.company.details', ['company' => $company]);
    }

    public function commerceItemShow(CommerceItem $commerceItem)
    {
        return view('settings.commerce-item.details', ['commerceItem' => $commerceItem]);
    }
    public function productLineShow(ProductLine $productLine)
    {
        return view('settings.product-line.details', ['productLine' => $productLine]);
    }
}
