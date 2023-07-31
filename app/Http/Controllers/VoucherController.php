<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Database\QueryException;

class VoucherController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {

        $column = $request->input('sort', 'voucher_name');
        $direction = $request->input('dir', 'asc');

        $query = $request->input('q', '');

        $vouchers = Voucher::where('voucher_name', 'LIKE', "%$query%")
                    ->orWhere('voucher_desc', 'LIKE', "%$query%")
                    ->orWhere('code', 'LIKE', "%$query%")
                    ->orderBy($column, $direction)
                    ->paginate($this->perPage);

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', $this->perPage);
        $counter = ($page - 1) * $perPage + 1;

        return view('vouchers.index', compact('vouchers', 'column', 'direction', 'counter', 'query'));
    }

    public function create()
    {
        return view('vouchers.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'voucher_name' => 'required',
            'code' => 'required|unique:vouchers',
            'voucher_desc' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'is_percent' => 'required|in:y,n',
            'value' => 'required',
            'is_active' => 'required|in:y,n',
        ]);

        try {
            $validatedData['start_date'] = date('Y-m-d', strtotime($validatedData['start_date']));
            $validatedData['end_date']   = date('Y-m-d', strtotime($validatedData['end_date']));
            $validatedData['value'] = (int) str_replace('.', '', $validatedData['value']);
            // dd($validatedData);
            Voucher::create($validatedData);
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

        return redirect()->route('vouchers.index')
            ->with('success', 'Voucher created successfully.');
    }

    public function edit(Voucher $voucher)
    {
        // dd($voucher);
        $voucher->start_date = date('d-m-Y', strtotime($voucher->start_date));
        $voucher->end_date   = date('d-m-Y', strtotime($voucher->end_date));
        return view('vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $validatedData = [];

        // Check if each input value has changed
        if ($request->input('voucher_name') !== $voucher->voucher_name) {
            $validatedData['voucher_name'] = 'required';
        }

        if ($request->input('code') !== $voucher->code) {
            $validatedData['code'] = 'required|unique:vouchers';
        }

        if ($request->input('voucher_desc') !== $voucher->voucher_desc) {
            $validatedData['voucher_desc'] = 'required';
        }

        if ($request->input('start_date') !== $voucher->start_date) {
            $validatedData['start_date'] = 'required';
        }

        if ($request->input('end_date') !== $voucher->end_date) {
            $validatedData['end_date'] = 'required';
        }

        if ($request->input('is_percent') !== $voucher->is_percent) {
            $validatedData['is_percent'] = 'required';
        }

        if ($request->input('value') !== $voucher->value) {
            $validatedData['value'] = 'required';
        }

        if ($request->input('is_active') !== $voucher->is_active) {
            $validatedData['is_active'] = 'required|in:y,n';
        }

        if (empty($validatedData)) {
            return redirect()->route('vouchers.index')
                ->with('warning', 'No changes made to the voucher.');
        }

        $validatedData = $request->validate($validatedData);

        $validatedData['start_date'] = date('Y-m-d', strtotime($validatedData['start_date']));
        $validatedData['end_date']   = date('Y-m-d', strtotime($validatedData['end_date']));
        $validatedData['value'] = (int) str_replace('.', '', $validatedData['value']);

        $voucher->update($validatedData);

        return redirect()->route('vouchers.index')
            ->with('success', 'Voucher updated successfully.');
    }

    public function delete(Voucher $voucher){
        return view('vouchers.delete', ['voucher' => $voucher]);
    }

    public function destroy(Request $request, Voucher $voucher)
    {
        $action_ = 'delete';
        if($action_ !== $request->input('action_text')){
            return redirect()->route('vouchers.index')->with('error', 'Delete voucher failed due to wrong proceed text value');
        }

        $voucher->delete();
        return redirect()->route('vouchers.index')->with('success', 'Voucher deleted successfully!');
    }

}
