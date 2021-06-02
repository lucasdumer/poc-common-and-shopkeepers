<?php

namespace App\Application\Services;

use App\Domain\Marketplace\ITransactionCreateCommand;
use App\Domain\Marketplace\ITransactionService;
use App\Domain\Marketplace\Transaction;
use App\Infrastructure\Clients\ExternalServerClient;
use App\Infrastructure\Clients\NotificationClient;
use App\Infrastructure\Repositories\TransactionRepository;
use App\Infrastructure\Repositories\UserRepository;

class TransactionService implements ITransactionService
{
    public function __construct(
        private TransactionRepository $transactionRepository,
        private UserRepository $userRepository,
        private ExternalServerClient $externalServerClient,
        private NotificationClient $notificationClient
    ) {}

    public function create(ITransactionCreateCommand $transactionCreateCommand): Transaction
    {
        try {
            $payer = $this->userRepository->find($transactionCreateCommand->getPayerId());
            $payee = $this->userRepository->find($transactionCreateCommand->getPayeeId());
            $transaction = new Transaction($payer, $payee, $transactionCreateCommand->getValue());
            if (!$this->externalServerClient->getAuthorizationStatus()) {
                throw new \Exception("Not allowed to transact.");
            }

            $transaction = $this->transactionRepository->create($transaction);
            $this->notificationClient->pub($transaction);
            return $transaction;
        } catch(\Exception $e) {
            throw new \Exception("Service error on create transaction. ".$e->getMessage());
        }
    }

    public function list(int $payerId = null, int $payeeId = null): array
    {
        try {
            return $this->transactionRepository->list($payerId, $payeeId);
        } catch(\Exception $e) {
            throw new \Exception("Service error on list transaction. ".$e->getMessage());
        }
    }
}
