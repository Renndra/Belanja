<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', // Tanpa konfirmasi password
        ]);
    
        try {
            // Buat pengguna baru
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']), // Gunakan bcrypt untuk hashing password
            ]);
    
            // Buat token untuk user
            $token = $user->createToken('user-token')->plainTextToken;
    
            // Berikan respons sukses
            return response()->json([
                'message' => 'Akun berhasil terdaftar.',
                'user' => $user,
                'token' => $token, // Token untuk autentikasi
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika ada masalah dengan database
            return response()->json([
                'message' => 'Terjadi kesalahan pada database.',
                'error' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            // Jika ada error lain
            return response()->json([
                'message' => 'Terjadi kesalahan saat mendaftar.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    



function login(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Ambil data email dan password
    $data = $request->only('email', 'password');

    try {
        // Cari user berdasarkan email
        $user = User::where('email', $data['email'])->first();

        // Jika user tidak ditemukan atau password salah
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah',
            ], 401);
        }

        // Buat token
        $token = $user->createToken('user-token')->plainTextToken;

        return response()->json([
            'message' => 'Berhasil login',
            'token' => $token,
            'user' => $user,
        ], 200);
    } catch (\Exception $e) {
        // Tangani error lain
        return response()->json([
            'message' => 'Terjadi kesalahan saat login',
            'error' => $e->getMessage(),
        ], 500);
    }
}

function logout(){
    Auth::logout();
    return response()->json([
        'message' => 'Berhasil metu',
    ]);

}
function products()
{
    $currentTime = now();
    
    $products = [
        [
            "id" => 1,
            "name" => "Hello Panda",
            "description" => "enak",
            "price" => 10000,
            "stock" => 20,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
        ],
        [
            "id" => 2,
            "name" => "Blukutuk",
            "description" => "Gaero opo iki",
            "price" => 0,
            "stock" => 0,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
        ],
        [
            "id" => 3,
            "name" => "Esteh bu madi",
            "description" => "Kopi Ternikmat",
            "price" => 3000,
            "stock" => 50,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
        ],
        [
            "id" => 4,
            "name" => "Tahu GO",
            "description" => "Tahu Ter Enak",
            "price" => 1000,
            "stock" => 1000,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
        ],
        [
            "id" => 5,
            "name" => "Mac n Cheese",
            "description" => "Keju ne lumer",
            "price" => 5000,
            "stock" => 1000,
            "created_at" => $currentTime,
            "updated_at" => $currentTime
        ],
        [
            "id" => 6,
            "name" => "Es Americano",
            "description" => "Americano Best Seller",
            "price" => 14000,
            "stock" => 2000,
            "created_at" => $currentTime,
            "updated_at" => $currentTime
        ]
    ];
    if (!$products) {
        return response()->json([
            "message" => "Produk tidak ditemukan",
        ], 404);
    }
    return response()->json([
        "message" => "Berhasil mengambil semua produk",
        "data" => $products
    ], 200);
}
function productsDetail($id)
{
    $currentTime = now();
    
    $products = [
        [
            "id" => 1,
            "name" => "Hello Panda",
            "description" => "enak",
            "price" => 10000,
            "stock" => 20,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
        ],
        [
            "id" => 2,
            "name" => "Blukutuk",
            "description" => "Gaero opo iki",
            "price" => 0,
            "stock" => 0,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
        ],
        [
            "id" => 3,
            "name" => "Esteh bu madi",
            "description" => "Kopi Ternikmat",
            "price" => 3000,
            "stock" => 50,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
        ],
        [
            "id" => 4,
            "name" => "Tahu GO",
            "description" => "Tahu Ter Enak",
            "price" => 1000,
            "stock" => 1000,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
        ],
        [
            "id" => 5,
            "name" => "Mac n Cheese",
            "description" => "Keju ne lumer",
            "price" => 5000,
            "stock" => 1000,
            "created_at" => $currentTime,
            "updated_at" => $currentTime
        ],
        [
            "id" => 6,
            "name" => "Es Americano",
            "description" => "Americano Best Seller",
            "price" => 14000,
            "stock" => 2000,
            "created_at" => $currentTime,
            "updated_at" => $currentTime
        ]
    ];
    $products = collect($products)->firstWhere('id', $id);
    if (!$products) {
        return response()->json([
            "message" => "Produk tidak ditemukan",
        ], 404);
    }
    return response()->json([
        "message" => "Berhasil mengambil detail produk",
        "data" => $products
    ], 200);
}
function getCart(Request $request)
{
    $products = [
        [
            "id" => 1,
            "name" => "Hello Panda",
            "description" => "enak",
            "price" => 10000,
            "stock" => 20,
        ],
        [
            "id" => 2,
            "name" => "Blukutuk",
            "description" => "Gaero opo iki",
            "price" => 0,
            "stock" => 0,
        ],
        [
            "id" => 3,
            "name" => "Esteh bu madi",
            "description" => "Kopi Ternikmat",
            "price" => 3000,
            "stock" => 50,    
        ],
        [       
            "id" => 4,
            "name" => "Tahu GO",
            "description" => "Tahu Ter Enak",
            "price" => 1000,
            "stock" => 1000,
        ],
        [
            "id" => 5,
            "name" => "Mac n Cheese",
            "description" => "Keju ne lumer",
            "price" => 5000,
            "stock" => 1000,
        ],
        [
            "id" => 6,
            "name" => "Es Americano",
            "description" => "Americano Best Seller",
            "price" => 14000,
            "stock" => 2000,
        ],
    ];

        $total  = collect($products)->reduce(function($carry,$item){
            return $carry + ($item['price'] * $item['stock']);
        });
        return response()->json([
            "message" => "Berhasil",
            "data" => [
                "produk" => $products,
                "total" => $total
            ]
        ], 200);
}
function cart(Request $request)
{

    $validateData = $request->validate([
        'products_id' => 'required|numeric|exists:products,id', 
'stock' => 'required|numeric|min:1'

    ]);

    $currentTime = now();
    $products = [
        [
            "id" => 1,
            "name" => "Hello Panda",
            "description" => "enak",
            "price" => 10000,
            "stock" => 20,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
            "is_active" => true,
        ],
        [
            "id" => 2,
            "name" => "Blukutuk",
            "description" => "Gaero opo iki",
            "price" => 0,
            "stock" => 0,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
            "is_active" => false,
        ],
        [
            "id" => 3,
            "name" => "Esteh bu madi",
            "description" => "Kopi Ternikmat",
            "price" => 3000,
            "stock" => 50,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
            "is_active" => true,
        ],
        [
            "id" => 4,
            "name" => "Tahu GO",
            "description" => "Tahu Ter Enak",
            "price" => 1000,
            "stock" => 1000,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
            "is_active" => true,
        ],
        [
            "id" => 5,
            "name" => "Mac n Cheese",
            "description" => "Keju ne lumer",
            "price" => 5000,
            "stock" => 1000,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
            "is_active" => true,
        ],
        [
            "id" => 6,
            "name" => "Es Americano",
            "description" => "Americano Best Seller",
            "price" => 14000,
            "stock" => 2000,
            "created_at" => $currentTime,
            "updated_at" => $currentTime,
            "is_active" => true,
        ]
    ];
    $products= collect($products)->firstWhere('id', $validateData['products_id']);
    if (!$products) {
        return response()->json([
            "message" => "Produk tidak ditemukan"
        ], 404);
    }
    $products = Products::where('id', $validateData['products_id'])
    ->where('is_active', true)  // Memastikan produk aktif
    ->first();
    if ($products['stock'] < $validateData['stock']) {
        return response()->json([
            "message" => "Stok tidak mencukupi"
        ], 400);
    }
    $user = $request->user();
    $cart = Cart::where('user_id', $user->id)
                ->where('product_id', $validateData['products_id'])
                ->first();
    if ($cart) {
        $cart->stock += $validateData['stock']; 
        $cart->save();
    } else {
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $validateData['products_id'],
            'stock' => $validateData['stock'],
        ]);
    }
    return response()->json([
        "message" => "Berhasil memasukkan produk ke keranjang",
    ], 200);
}
function updateCart(Request $request, $cart_id)
{
    $request->validate([
        'stock' => 'required|integer|min:1',
    ]);
    $user = $request->user(); 
    $cart = Cart::where('user_id', $user->id)->find($cart_id);
    if (!$cart) {
        return response()->json([
            'message' => 'Keranjang bukan milik pengguna',
        ], 403);  
    }
    $product = Products::find($cart->product_id);

    if (!$product || !$product->is_active) {
        return response()->json([
            'message' => 'Produk tidak ditemukan atau tidak aktif',
        ], 404); 
    }
    if ($product->stock < $request->stock) {
        return response()->json([
            'message' => 'Stok produk tidak cukup',
        ], 400); 
    }
    $cart->stock = $request->stock;
    $cart->save();

    return response()->json([
        'message' => 'Keranjang berhasil diperbarui',
    ], 200);  
}

public function deletCart(Request $request, $cart_id)
{
    if (!$request->user()) {
        return response()->json([
            'message' => 'Unauthenticated', 
        ], 401);
    }

    $user = $request->user();
    $cart = Cart::where('user_id', $user->id)->find($cart_id);

    if (!$cart) {
        return response()->json([
            'message' => 'Keranjang tidak ditemukan',
        ], 404);
    }

    if ($cart->user_id !== $user->id) {
        return response()->json([
            'message' => 'Forbidden',
        ], 403);
    }

    $cart->delete();

    return response()->json([
        'message' => 'Keranjang berhasil diperbarui',
    ], 200);
}
public function Order(Request $request)
{
    $user = auth()->user();
    if (!$user) {
        return response()->json([
            'message' => 'Unauthenticated',
        ], 401);
    }
    $orders = Order::where('user_id', $user->id)
        ->with('products') 
        ->get();
    $ordersData = $orders->map(function ($order) {
        $products = $order->products->map(function ($products) {
            return [
                'id' => $products->id,
                'name' => $products->name,
                'price' => $products->price,
                'stock' => $products->pivot->stock,
                'total' => $products->pivot->stock * $products->price,
            ];
        });

        return [
            'id' => $order->id,
            'status' => $order->status,
            'total' => $order->total,
            'produk' => $products,
        ];
    });

    return response()->json([
        'message' => 'Berhasil mengambil data pesanan',
        'data' => $ordersData,
    ], 200);
}
public function show($order_id)
{
    $user = auth()->user();
    $order = Order::with('products')->where('id', $order_id)->first();
    if (!$order || $order->user_id !== $user->id) {
        return response()->json([
            'message' => 'Bukan Milikmu',
        ], 403);
    }
    $data = [
        'id' => $order->id,
        'status' => $order->status,
        'total' => $order->total_price,
        'produk' => $order->products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'stock' => $product->pivot->stock,
                'total' => $product->price * $product->pivot->stock,
            ];
        }),
    ];
    return response()->json([
        'message' => 'Berhasil mengambil data pesanan',
        'data' => $data,
    ], 200);
}
public function checkout()
{
    $user = auth()->user();
    $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
    if ($cartItems->isEmpty()) {
        return response()->json([
            'message' => 'Keranjang belanja kosong',
        ], 400);
    }
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $product = $item->product;

        if (!$product->is_active) {
            return response()->json([
                'message' => "Produk {$product->name} tidak tersedia",
            ], 422);
        }

        if ($product->stock < $item->stock) {
            return response()->json([
                'message' => "Stok produk {$product->name} tidak mencukupi",
            ], 422);
        }
        $totalPrice += $product->price * $item->stock;
    }
    DB::beginTransaction();
    try {
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'status' => 'proses',
        ]);
        foreach ($cartItems as $item) {
            $product = $item->product;
            $product->decrement('stock', $item->stock);
            $order->products()->attach($product->id, [
                'quantity' => $item->stock,
                'price' => $product->price,
            ]);
        }
        Cart::where('user_id', $user->id)->delete();

        DB::commit();
        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
        ], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Terjadi kesalahan saat membuat pesanan',
        ], 500);
    }
}
}