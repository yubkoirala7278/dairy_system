<?php

namespace Database\Factories;

use App\Models\MilkDeposit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MilkDeposit>
 */
class MilkDepositFactory extends Factory
{
    protected $model = MilkDeposit::class;

    public function definition()
    {
        $nepaliDates = ['२०८१-१०-०१', '२०८१-०९-२९', '२०८१-०९-२७', '२०८१-१०-२५'];
        $milkTypes = ['मिश्रित', 'गाईको'];

        return [
            'user_id' => User::role('farmer')->inRandomOrder()->first()?->id,
            'milk_quantity' => $this->faker->randomFloat(2, 1, 50), // Random milk quantity between 1 to 50 liters
            'milk_fat' => $this->faker->randomFloat(2, 3, 7),       // Random fat percentage (3% to 7%)
            'milk_snf' => $this->faker->randomFloat(2, 8, 10),      // Random SNF percentage (8% to 10%)
            'milk_price_per_ltr' => $this->faker->randomFloat(2, 50, 100), // Price per liter (50 to 100)
            'per_ltr_commission' => $this->faker->randomFloat(2, 0, 5),    // Commission (0 to 5)
            'milk_per_ltr_price_with_commission' => function (array $attributes) {
                return $attributes['milk_price_per_ltr'] + $attributes['per_ltr_commission'];
            },
            'milk_total_price' => function (array $attributes) {
                return $attributes['milk_quantity'] * $attributes['milk_per_ltr_price_with_commission'];
            },
            'milk_deposit_date' => $this->faker->randomElement($nepaliDates),
            'milk_deposit_time' => $this->faker->randomElement(['बिहान', 'साझ']),
            'milk_type' => $this->faker->randomElement($milkTypes),
        ];
    }
}
