<?php


namespace App\Dtos\Administrator\Plan;

use App\Http\Requests\Administrator\Plan\PlanRequest;

class PlanDto
{

    public function __construct(
        public $name,
        public $price,
        public $currency,
        public $billing_cycle,
        public $is_default,
        public $days
    ) {}

    public static function fromRequest(PlanRequest $request): self
    {
        $data = $request->validated();

        return new self(
            name: $data['name'],
            price: $data['price'],
            currency: $data['currency'],
            billing_cycle: $data['billing_cycle'],
            is_default: $data['is_default'],
            days: $data['days']
        );
    }

    public function toDatabase(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'currency' => $this->currency,
            'billing_cycle' => $this->billing_cycle,
            'days' => $this->days,
            'is_default' => $this->is_default,
        ];
    }

}
