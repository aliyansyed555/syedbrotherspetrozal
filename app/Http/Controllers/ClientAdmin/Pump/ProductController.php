<?php

namespace App\Http\Controllers\ClientAdmin\Pump;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductInventory;

class ProductController extends Controller
{
    private $user;
    private $company;
    private $pump;

    public function __construct(Request $request)
    {
        // Initialize the user and company properties
        $this->user = Auth::user();
        $this->company = get_company($this->user); 
        
        $this->pump = $request->pump;
    }

    function index(Request $request)
    {
        $pump_id = $this->pump->id;
        return view('client_admin.pump.product', compact(['pump_id']));
    }

    public function getAll()
    {
        $products = $this->pump->products()
            ->selectRaw('products.id, products.name, products.price, products.buying_price, products.company, coalesce((select sum(quantity) from product_inventory where product_id = products.id), 0) as quantity')
            ->get();

        return response()->json([ 
            'recordsTotal' => $products->count(),
            'recordsFiltered' => $products->count(),
            'success' => true,
            'data' => $products,
        ]);
    }
    
    public function create(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'buying_price' => 'required|string',
            'company' => 'required|string|max:255',
        ]);
        $validatedData['petrol_pump_id'] = $this->pump->id;
        $product = Product::create($validatedData);
        return response()->json(['success' => true, 'message' => 'Product created successfully.']);
    }

    
    public function update(Request $request)
    {
        $product = Product::findOrFail($request->id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }
        if ($product->petrol_pump_id != $this->pump->id) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied to Product.',
            ], 403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'buying_price' => 'required|string',
            'company' => 'required|string|max:255',
        ]);

        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->buying_price = $validatedData['buying_price'];
        $product->company = $validatedData['company'];
        $product->save();

        return response()->json(['success' => true, 'message' => 'Product updated successfully.']);
    }
    
    public function addStock(Request $request)
    {

        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        $product = Product::findOrFail($validatedData['product_id']);
        if ($product->petrol_pump_id != $this->pump->id) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied to Product.',
            ], 403);
        }

        $productInventory = ProductInventory::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Stock Updated successfully.']);
    }


    public function delete($pump_id, $product_id)
    {
        if (!$this->user->can('owner-access')) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to delete this.'], 403);
        }
        try {
            $product = Product::findOrFail($product_id);
            if (!$this->company->petrolPumps->contains('id', $product->petrol_pump_id)) {
                return response()->json(['success' => false, 'message' => 'Access denied to Product.'], 403);
            }
            $product->delete();
            return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Product.'], 500);
        }
    }
}
