<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\UserModel;
use App\Models\SaleModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please sign in to continue.');
        }

        $db = \Config\Database::connect();

        $data = [
            'title' => 'Dashboard',
            'productCount' => $db->table('products')->countAllResults(),
            'customerCount' => $db->table('customers')->countAllResults(),
            'staffCount' => $db->table('users')->countAllResults(),
            'salesCount' => $db->table('sales')->countAllResults(),
            'salesRevenue' => $db->table('sales')
                ->selectSum('total_price')
                ->get()
                ->getRow()
                ->total_price ?? 0,
            'recentSales' => $db->table('sales s')
                ->select('s.id, s.quantity, s.total_price, s.created_at,
                          p.name AS product_name,
                          c.full_name AS customer_name,
                          u.full_name AS staff_name')
                ->join('products p', 'p.id = s.product_id')
                ->join('customers c', 'c.id = s.customer_id', 'left')
                ->join('users u', 'u.id = s.sold_by', 'left')
                ->orderBy('s.created_at', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray(),
            'lowStock' => $db->table('products')
                ->where('stock_quantity <=', 5)
                ->orderBy('stock_quantity', 'ASC')
                ->limit(5)
                ->get()
                ->getResultArray(),
        ];

        return view('dashboard/index', $data);
    }
}