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
        try {
            $transactionCreateCommand = new TransactionCreateCommand(
                $request->payerId,
                $request->payeeId,
                $request->value
            );
            return $this->success($this->transactionService->create($transactionCreateCommand)->toArray());
        } catch(\Exception $e) {
            return $this->error($e);
        }
    }

    public function list(TransactionListRequest $request)
    {
        try {
            return $this->success($this->transactionService->list($request->payerId, $request->payeeId));
        } catch(\Exception $e) {
            return $this->error($e);
        }
    }
}
