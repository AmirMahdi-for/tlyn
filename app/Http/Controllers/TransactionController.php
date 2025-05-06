<?php

namespace App\Http\Controllers;

use App\Http\Resources\Paginated\TransactionResources;
use App\Http\Resources\TransactionResource;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected TransactionRepositoryInterface $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
    
    public function get($locale, $id, Request $request) 
    {
        $transaction = $this->transactionRepository->get($id, $request->user()->id);
        return new TransactionResource($transaction);
    }

    public function list(Request $request) 
    {
        $filters = [];
        $transactions = $this->transactionRepository->getAll($filters, $request->user()->id);
        return new TransactionResources($transactions);
    }
}
