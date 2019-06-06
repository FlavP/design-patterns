<?php


class CustomerRepositoryTest extends PHPUnit\Framework\TestCase
{
    protected $customers = [];

    public function setUp(): void
    {
        $this->customers = new CustomerRepository([
            new Customer('gold'),
            new Customer('silver'),
            new Customer('bronze'),
            new Customer('gold')
        ]);
    }

    /** @test */
    function it_fetches_all_customers(){
        $results = $this->customers->all();
        $this->assertCount(4, $results);
    }

    /** @test */
    function it_fetches_all_customers_who_match_a_certain_specification() {
        $customers = new CustomerRepository([
            new Customer('gold'),
            new Customer('silver'),
            new Customer('bronze'),
            new Customer('gold'),
        ]);
        $results = $customers->bySpecification(new CustomerIsGold());
        $this->assertCount(2, $results);
    }
}