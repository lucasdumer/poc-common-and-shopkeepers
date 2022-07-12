<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Commands\TransactionCreateCommand;
use App\Application\Services\TransactionService;
use App\Interfaces\Http\Requests\TransactionCreateRequest;
use App\Interfaces\Http\Requests\TransactionListRequest;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService
    ) {}

    public function create(TransactionCreateRequest $request)
    {
        $transactionCreateCommand = new TransactionCreateCommand(
            $request->payerId,
            $request->payeeId,
            $request->value
        );
        return $this->success($this->transactionService->create($transactionCreateCommand)->toArray());
    }

    public function list(TransactionListRequest $request)
    {
        return $this->success($this->transactionService->list($request->payerId, $request->payeeId));
    }
}
