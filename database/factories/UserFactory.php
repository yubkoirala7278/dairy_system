<?php

namespace Database\Factories;

use App\Helpers\NumberHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition()
    {
        static $farmerNumber = 1;

        // Nepali names array
        $nepaliNames = [
            'राम', 'सीता', 'गिता', 'हरि', 'लक्ष्मी',
            'शिव', 'कृष्ण', 'सरस्वती', 'अर्जुन', 'सुनिता'
        ];

        // Nepali locations array
        $nepaliLocations = [
            'काठमाडौं', 'पोखरा', 'ललितपुर', 'बुटवल', 'जनकपुर',
            'वीरगञ्ज', 'नेपालगञ्ज', 'धनगढी', 'इटहरी', 'धरान'
        ];

        // Random Nepali phone number generator
        $generateNepaliPhoneNumber = function () {
            $prefixes = ['984', '985', '986', '981', '982'];
            $randomPrefix = $prefixes[array_rand($prefixes)];
            $randomSuffix = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $phoneNumber = $randomPrefix . $randomSuffix;
            return NumberHelper::toNepaliNumber($phoneNumber);
        };

        return [
            'name' => fake()->name(),
            'owner_name' => fake()->randomElement($nepaliNames),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'farmer_number' => NumberHelper::toNepaliNumber($farmerNumber++),
            'location' => fake()->randomElement($nepaliLocations),
            'gender' => fake()->randomElement(['पुरुष', 'महिला', 'अन्य']),
            'status' => fake()->randomElement(['चालू', 'बन्द']),
            'phone_number' => $generateNepaliPhoneNumber(),
            'pan_number' => fake()->unique()->numerify('PAN-#####'),
            'vat_number' => fake()->unique()->numerify('VAT-#####'),
            'slug' => fake()->slug(),
            'milk_fat' => fake()->randomFloat(1, 3.0, 6.0),
            'milk_snf' => fake()->randomFloat(1, 8.0, 10.0),
            'remember_token' => fake()->uuid(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('farmer'); // Assign the farmer role
        });
    }
}