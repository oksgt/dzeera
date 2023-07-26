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
        $keysToRemove = ['id', 'created_at', 'updated_at', 'deleted_at'];
        foreach ($keysToRemove as $key) {
            unset($bankAccount[$key]);
        }
        $validatedData = $request->validate([
            'bank_name' => 'required',
            'account_number' => [
                'required',
                Rule::unique('bank_accounts')->ignore($bankAccount->id),
            ],
            'account_name' => 'required',
            'is_active' => 'required|in:y,n',
        ]);

        if ($validatedData == $bankAccount->toArray()) {
            return redirect()->route('bank-accounts.index')->with('error', 'No changes made to the bank account.');
        }

        try {
            $bankAccount->update($validatedData);
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
            ->with('success', 'Bank account updated successfully.');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return response()->json(['message' => 'Bank account deleted successfully.']);
    }

}
