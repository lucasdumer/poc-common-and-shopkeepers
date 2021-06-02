<?php

namespace Tests\Domain\Marketplace\User;

use App\Domain\Marketplace\User\Document;
use App\Domain\Marketplace\User\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_construct()
    {
        $user = new User(
            'name',
            new Document('95478456245'),
            'teste@teste.com',
            '123456',
            1000
        );
        $this->assertEquals($user->getName(), 'name');
        $this->assertEquals($user->getDocument()->getValue(), '95478456245');
        $this->assertEquals($user->getEmail(), 'teste@teste.com');
        $this->assertEquals($user->getPassword(), '123456');
        $this->assertEquals($user->getBalance(), 1000);
    }

    public function test_get_set()
    {
        $user = new User(
            'name',
            new Document('95478456245'),
            'teste@teste.com',
            '123456',
            1000
        );
        $user->setId(1);
        $user->setName('name2');
        $user->setDocument(new Document('42564587231'));
        $user->setEmail('teste2@teste.com');
        $user->setPassword('654321');

        $this->assertEquals($user->getId(), 1);
        $this->assertEquals($user->getName(), 'name2');
        $this->assertEquals($user->getDocument()->getValue(), '42564587231');
        $this->assertEquals($user->getEmail(), 'teste2@teste.com');
        $this->assertEquals($user->getPassword(), '654321');
    }

    public function test_balance()
    {
        $user = new User(
            'name',
            new Document('95478456245'),
            'teste@teste.com',
            '123456',
            1000
        );
        $this->assertEquals($user->getBalance(), 1000);
        $user->addBalance(1000);
        $this->assertEquals($user->getBalance(), 2000);
        $user->removeBalance(500);
        $this->assertEquals($user->getBalance(), 1500);
    }

    public function test_balance_negative()
    {
        try {
            $user = new User(
                'name',
                new Document('95478456245'),
                'teste@teste.com',
                '123456',
                1000
            );
            $user->removeBalance(1001);
        } catch(\Exception $e) {
            $this->assertEquals($e->getMessage(), "Balance less than zero.");
        }
    }
}
