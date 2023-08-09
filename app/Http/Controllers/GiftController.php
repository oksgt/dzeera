<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gift;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class GiftController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $column = $request->input('sort', 'gift_name');
        $direction = $request->input('dir', 'asc');

        $gift_setting = DB::select("select * from app_settings as2 where `key` = 'gift'")[0]->status;

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
        return view('gifts.index', compact('gifts', 'column', 'direction', 'counter', 'query', 'gift_setting'));
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

    public function edit(Gift $gift)
    {
        $products = Product::where('product_availability', '=', 'y')
                ->where('deleted_at', '=', null)
                ->get();

        $gift = Gift::select('gifts.*', 'p.id as product_id', 'po.id as product_opt_id')
            ->join('product_options as po', 'po.id', '=', 'gifts.product_opt_id' )
            ->join('products as p', 'p.id', '=', 'po.product_id')
            ->where('gifts.id', $gift->id)
            ->first();

        // dd($gift_data);
        return view('gifts.edit', compact('products', 'gift'));
    }

    public function update(Request $request, Gift $gift)
    {
        $validatedData = [];

        $validatedData['product_id'] = 'required';

        // Check if each input value has changed
        if ($request->input('gift_name') !== $gift->gift_name) {
            $validatedData['gift_name'] = 'required';
        }

        if ($request->input('gift_description') !== $gift->gift_description) {
            $validatedData['gift_description'] = 'required';
        }

        if ($request->input('product_opt_id') !== $gift->product_opt_id) {
            $validatedData['product_opt_id'] = 'required';
        }

        if ($request->input('is_for_first_purchase') !== $gift->is_for_first_purchase) {
            $validatedData['is_for_first_purchase'] = 'required|in:y,n';
        }

        if ($request->input('min_purchase_value') !== $gift->min_purchase_value) {
            $validatedData['min_purchase_value'] = 'required';
        }

        if ($request->input('is_active') !== $gift->is_active) {
            $validatedData['is_active'] = 'required|in:y,n';
        }

        if (empty($validatedData)) {
            return redirect()->route('gifts.index')
                ->with('warning', 'No changes made to the gift.');
        }

        $validatedData = $request->validate($validatedData);

        $validatedData['min_purchase_value'] = (int) str_replace('.', '', $validatedData['min_purchase_value']);
        $validatedData['product_opt_id']     = (int) $validatedData['product_opt_id'];

        $gift->update($validatedData);

        return redirect()->route('gifts.index')
            ->with('success', 'Gift updated successfully.');
    }

    public function delete(Gift $gift){
        return view('gifts.delete', ['gift' => $gift]);
    }

    public function destroy(Request $request, Gift $gift)
    {
        $action_ = 'delete';
        if($action_ !== $request->input('action_text')){
            return redirect()->route('gifts.index')->with('error', 'Delete gift failed due to wrong proceed text value');
        }

        $gift->delete();
        return redirect()->route('gifts.index')->with('success', 'Gift deleted successfully!');
    }

    public function changeSetting(Request $request){
        $result = DB::table('app_settings')->where('key', 'gift')->update([
            'status' => $request->status,
        ]);
        $message = ($request->status == 1) ? 'Gift enabled successfully.' : 'Gift disabled successfully.';
        return redirect()->route('gifts.index')
            ->with('success', $message);
    }
}
