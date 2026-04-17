<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $seo = [
            'title' => 'Qwetu Link POS - Smart Point of Sale for Modern Businesses',
            'description' => 'Qwetu Link POS helps businesses manage sales, inventory, customers, and reports with ease. Streamline your operations and grow faster with an all-in-one POS solution.',
            'keywords' => 'POS system, point of sale software, inventory management, sales tracking, business management, Qwetu Link POS',
            'og_title' => 'Qwetu Link POS - Simplify Sales & Business Management',
            'og_description' => 'Power your business with Qwetu Link POS. Manage sales, track inventory, and gain insights in real-time.',
        ];

        return view('welcome', compact('seo'));
    }
}
