<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $column = $request->input('sort', 'created_at');
        $direction = $request->input('dir', 'asc');

        $query = $request->input('q', '');

        $orders = Transaction::
                    // join('brands', 'brands.id', '=', 'video_embeds.brand_id')
                    where('trans_number', 'LIKE', "%$query%")
                    ->orWhere('cust_name', 'LIKE', "%$query%")
                    ->orWhere('recp_name', 'LIKE', "%$query%")
                    ->orderBy($column, $direction)
                    ->paginate($this->perPage);

        // $orders = null;
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', $this->perPage);
        $counter = ($page - 1) * $perPage + 1;

        return view('orders.index', compact('orders', 'column', 'direction', 'counter', 'query'));
    }

    public function details($trans_number){

        $code = $trans_number;
        if (empty($code)) {
            return redirect()->route('orders');
        }

        $transaction = Transaction::where('trans_number', $code)->first();

        if (!$transaction) {
            return redirect()->route('home');
        }

        $trans_detail = DB::select("
        select
            po.id as cart_id,
            po.id as opt_id,
            p.id as product_id, p.product_name, pco.id as color_opt_id, pco.color_name , pso.id as size_opt_id, pso.`size`, po.price,
            po.qty,
            po.qty * po.price as total_price
            -- pi2.file_name
            from transaction_details po
            join products p on p.id = po.product_id
            join product_color_options pco on pco.id = po.color_opt_id
            join product_size_options pso on pso.id = po.size_opt_id
            -- LEFT JOIN product_images pi2 ON pi2.product_id = p.id AND pi2.is_thumbnail = 1
                where po.trans_number = ?
            ", [$code]);

        if($transaction->voucher_id !== "-"){
            $voucher = Voucher::where('code', $transaction->voucher_id)->first();
        } else {
            $voucher = [];
        }

        return view('orders.details', compact('transaction', 'trans_detail', 'voucher'));
    }

    // Function to update 'shipping_code' on 'transactions' table
    public function updateShippingCode(Request $request, $transactionId)
    {
        $shippingCode = $request->input('shipping_code');

        $transaction = Transaction::findOrFail($transactionId);
        $transaction->shipping_code = $shippingCode;
        $transaction->save();

        Session::flash('success', 'Shipping code updated successfully.');
        return redirect()->back();
    }

    // Function to update 'trans_status' on 'transactions' table
    public function updateTransStatus(Request $request, $transactionId)
    {
        $transStatus = $request->input('input_trans_status');

        $transaction = Transaction::findOrFail($transactionId);
        $transaction->trans_status = $transStatus;
        $transaction->save();

        Session::flash('success', 'Transaction status updated successfully.');
        return redirect()->back();
    }
}
