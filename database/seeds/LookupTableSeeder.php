<?php

use Illuminate\Database\Seeder;

class LookupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $lookups = [
        [
            'name' => 'Male',
            'type' => 'gender',
            'code' => '1'
        ],
        [
            'name' => 'Female',
            'type' => 'gender',
            'code' => '2'
        ],
        [
            'name' => 'Others',
            'type' => 'gender',
            'code' => '3'
        ],
        [
            'name' => 'Single',
            'type' => 'marital_status',
            'code' => '1'
        ],
        [
            'name' => 'Married',
            'type' => 'marital_status',
            'code' => '2'
        ],
        [
            'name' => 'Separated',
            'type' => 'marital_status',
            'code' => '3'
        ],
        [
            'name' => 'Islam',
            'type' => 'religion',
            'code' => '1'
        ],
        [
            'name' => 'Hinduism',
            'type' => 'religion',
            'code' => '2'
        ],
        [
            'name' => 'Cristian',
            'type' => 'religion',
            'code' => '3'
        ],
        [
            'name' => 'Cash',
            'type' => 'cashcredit',
            'code' => '1'
        ],
        [
            'name' => 'Credit',
            'type' => 'cashcredit',
            'code' => '2'
        ],
        [
            'name' => 'Cash',
            'type' => 'payment_method',
            'code' => '1'
        ],
        [
            'name' => 'Bkash',
            'type' => 'payment_method',
            'code' => '2'
        ],
        [
            'name' => 'Card',
            'type' => 'payment_method',
            'code' => '3'
        ],
        [
            'name' => 'Cheque',
            'type' => 'payment_method',
            'code' => '4'
        ],
        [
            'name' => 'Bank',
            'type' => 'payment_method',
            'code' => '5'
        ],
        [
            'name' => 'Brac Bank',
            'type' => 'bank',
            'code' => '1'
        ],
        [
            'name' => 'City Bank',
            'type' => 'bank',
            'code' => '2'
        ],
        [
            'name' => 'Prime Bank',
            'type' => 'bank',
            'code' => '3'
        ],
        [
            'name' => 'Dhaka Bank',
            'type' => 'bank',
            'code' => '4'
        ],
        [
            'name' => 'Eastern Bank',
            'type' => 'bank',
            'code' => '5'
        ],
        [
            'name' => 'Dutch Bangla Bank',
            'type' => 'bank',
            'code' => '6'
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->lookups as $index => $lookup) {
            $result = \App\Modules\Config\Models\Lookup::create($lookup);
            if (!$result) {
                $this->command->info("Inserted at record $index.");
                return;
            }
            $this->command->info('Inserted '.count($this->lookups) . ' records');
        }
    }
}
