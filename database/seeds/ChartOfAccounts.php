<?php

use Illuminate\Database\Seeder;

class ChartOfAccounts extends Seeder
{


    protected $coa = [
        [
            'root_id' => null,
            'name' => 'ROOT',
            'code' => '1'
        ]
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->coa as $index => $coa) {
            $result = \App\Modules\Accounting\Models\ChartOfAccounts::create($coa);
            if (!$result) {
                $this->command->info("Inserted at record $index.");
                return;
            }
            $this->command->info('Inserted '.count($this->coa) . ' records');
        }

    }
}
