<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function getProducts()
    {
        return [
            [
                "slug" => "БЧЭ1",
                "name" => "БЧЭ1",
                "series" => "Series S",
                "tagline" => "Малогабаритный инерцилальный модуль для БПЛА",
                "specs" => [
                    "Гироскоп, макс. диапазон" => "±4000 °/s",
                    "Нестабильность смещения нуля в запуске(гироскопа)" => "≤ 3 °/ч",
                    "Спектральная плотность шума гироскопа" => "≤ 0.005 °/c/√Гц",
                    "Акселерометр, макс. диапазон" => "±16 g",
                    "Нестабильность смещения нуля в запуске (акселерометра)" => "≤ 0.01 mg",
                    "Спектральная плотность шума акселерометра" => "≤ 60 мкg/c/√Гц",
                    "Интерфейсы" => "UART",
                    "Питание" => "3.3 V",
                    "Рабочая температура" => "-40…+85 °C",
                ],
                "images" => [
                    "assets/BCHE-1/imu1.jpg",
                    "assets/BCHE-1/imu2.jpg",
                    "assets/BCHE-1/imu3.jpg",
                    "assets/BCHE-1/imu4.jpg",
                    "assets/BCHE-1/imu5.jpg"
                ],
                "datasheet" => "БЧЭ 1.pdf",
                "model3d" => null,
            ]
        ];
    }

    public function index()
    {
        $products = $this->getProducts();
        return view('products', compact('products'));
    }

    public function show($slug)
    {
        $products = $this->getProducts();
        $product = collect($products)->firstWhere('slug', urldecode($slug));
        
        if (!$product) {
            abort(404);
        }
        
        return view('product_detail', compact('product'));
    }
}
