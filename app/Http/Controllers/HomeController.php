<?php
// namespace App\Http\Controllers;
// use Illuminate\Http\Request;

// class HomeController extends Controller{
//     public function index(){
//         return view('home');
//     }
// }
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman home.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Data dummy produk, bisa diambil dari database jika sudah ada modelnya
        $products = [
            [
                'image' => 'product1.jpg',
                'name' => 'Jaket Angkatan',
                'description' => 'Jaket Angkatan JTI angkatan 2022, ORDER NOW!!',
            ],
            [
                'image' => 'product2.jpg',
                'name' => 'Kemeja Jurusan',
                'description' => 'Kemeja Jurusan baru saja rilis jadi kalian bisa PRE-ORDER mulai sekarang!!',
            ],
            [
                'image' => 'produk3.jpg',
                'name' => 'Snack',
                'description' => 'Makanan ringan yang cocok disantap dengan santai',
            ],
            [
                'image' => 'produk4.jpeg',
                'name' => 'Minuman',
                'description' => 'Berbagai macam minuman manis, asam, soda yang dapat menghilangkan rasa dahaga',
            ],
        ];

        // Mengirim data produk ke view
        return view('home.index', compact('products'));
    }
}

?>