<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gift;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Database\QueryException;

class GiftController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $column = $request->input('sort', 'gift_name');
        $direction = $request->input('dir', 'asc');

        $query = $request->input('q', '');

        $gifts = Gift::
            join('product_options as po', 'po.id', '=', 'gifts.product_opt_id' )
            ->join('products as p', 'p.id', '=', 'po.product_id')
            ->join('product_color_options as pco', function ($join) {
                $join->on('pco.id', '=', 'po.color')
                    ->on('pco.product_id', '=', 'p.id');
            })
            ->join('product_size_options as pso', function ($join) {
                $join->on('pso.id', '=', 'po.size_opt_id')
                    ->on('pso.product_id', '=', 'p.id');
            })
            ->select('gifts.*', 'p.product_name', 'pso.size', 'pco.color_name')
            ->where('p.product_name', 'LIKE', "%$query%")
            ->orWhere('gifts.gift_name', 'LIKE', "%$query%")
            ->orderBy($column, $direction)
            ->paginate($this->perPage);

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', $this->perPage);
        $counter = ($page - 1) * $perPage + 1;

        return view('gifts.index', compact('gifts', 'column', 'direction', 'counter', 'query'));
    }

    public function create()
    {
        $products = Product::where('product_availability', '=', 'y')
                ->where('deleted_at', '=', null)
                ->get();
        return view('gifts.create', compact('products'));
    }

    public function getProductOptions($productId)
    {

        $ProductOption = ProductOption::join('products as p', 'p.id', '=', 'product_options.product_id')
            ->join('product_color_options as pco', function ($join) {
                $join->on('pco.id', '=', 'product_options.color')
                    ->on('pco.product_id', '=', 'p.id');
            })
            ->join('product_size_options as pso', function ($join) {
                $join->on('pso.id', '=', 'product_options.size_opt_id')
                    ->on('pso.product_id', '=', 'p.id');
            })
            ->select('product_options.*', 'p.product_name', 'pso.size', 'pso.dimension', 'pco.color_name')
            ->where('product_options.option_availability', '=', 'y')
                ->where('product_options.deleted_at', '=', null)
            ->where('p.id', $productId)->get();

        return response()->json($ProductOption);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'gift_name'             => 'required',
            'product_id'            => 'required',
            'gift_description'      => 'required',
            'product_opt_id'        => 'required',
            'is_for_first_purchase' => 'required|in:y,n',
            'min_purchase_value'    => 'required',
            'is_active'             => 'required|in:y,n',
        ]);

        try {
            $validatedData['min_purchase_value'] = (int) str_replace('.', '', $validatedData['min_purchase_value']);
            $validatedData['product_opt_id']     = (int) $validatedData['product_opt_id'];
            unset($validatedData['product_id']);
            // dd($validatedData);
            Gift::create($validatedData);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Duplicate entry error code
                $failedField = 'code';
                return redirect()->back()
                    ->withErrors([
                        $failedField => 'The ' . $failedField . ' has already been taken.'
                    ])
                    ->withInput();
            }
            throw $e;
        }

        return redirect()->route('gifts.index')
            ->with('success', 'Gift created successfully.');
    }
}
