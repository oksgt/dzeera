<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BankAccountController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $bankAccounts = BankAccount::all();

        $column = $request->input('sort', 'bank_name');
        $direction = $request->input('dir', 'asc');

        $query = $request->input('q', '');

        $bankAccounts = BankAccount::where('bank_name', 'LIKE', "%$query%")
                    ->orWhere('account_name', 'LIKE', "%$query%")
                    ->orWhere('account_number', 'LIKE', "%$query%")
                    ->orderBy($column, $direction)
                    ->paginate($this->perPage);

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', $this->perPage);
        $counter = ($page - 1) * $perPage + 1;
        return view('bank-accounts.index', compact('bankAccounts', 'column', 'direction', 'counter', 'query'));

    }

    public function create()
    {
        return view('bank-accounts.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bank_name' => 'required',
            'account_number' => 'required|unique:bank_accounts',
            'account_name' => 'required',
            'is_active' => 'required|in:y,n',
        ]);

        try {
            BankAccount::create($validatedData);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Duplicate entry error code
                $failedField = 'account_number';
                return redirect()->back()
                    ->withErrors([
                        $failedField => 'The ' . $failedField . ' has already been taken.'
                    ])
                    ->withInput();
            }
            throw $e;
        }

        return redirect()->route('bank-accounts.index')
            ->with('success', 'Bank account created successfully.');
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('bank-accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $validatedData = [];

        // Check if each input value has changed
        if ($request->input('bank_name') !== $bankAccount->bank_name) {
            $validatedData['bank_name'] = 'required';
        }

        if ($request->input('account_number') !== $bankAccount->account_number) {
            $validatedData['account_number'] = 'required|unique:bank_accounts';
        }

        if ($request->input('account_name') !== $bankAccount->account_name) {
            $validatedData['account_name'] = 'required';
        }

        if ($request->input('is_active') !== $bankAccount->is_active) {
            $validatedData['is_active'] = 'required|in:y,n';
        }

        // Skip validation if nothing has changed
        if (empty($validatedData)) {
            return redirect()->route('bank-accounts.index')
                ->with('warning', 'No changes made to the bank account.');
        }

        $validatedData = $request->validate($validatedData);

        $bankAccount->update($validatedData);

        return redirect()->route('bank-accounts.index')
            ->with('success', 'Bank account updated successfully.');
    }

    public function delete(BankAccount $bankAccount){
        return view('bank-accounts.delete', ['bankAccount' => $bankAccount]);
    }

    public function destroy(Request $request, BankAccount $bankAccount)
    {
        $action_ = 'delete';
        if($action_ !== $request->input('action_text')){
            return redirect()->route('bank-accounts.index')->with('error', 'Delete bank account failed due to wrong proceed text value');
        }

        $bankAccount->delete();
        return redirect()->route('bank-accounts.index')->with('success', 'Bank account deleted successfully!');
    }

}
