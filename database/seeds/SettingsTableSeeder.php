<?php


use App\Modules\Config\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * @var array
     */
    protected $settings = [
        [
            'key' => 'site_name',
            'value' => 'Cluster ERP'
        ],
        [
            'key' => 'site_title',
            'value' => 'Cluster ERP'
        ],
        [
            'key' => 'company_name',
            'value' => 'Dhaka International University'
        ],
        [
            'key' => 'road_no',
            'value' => 'Panthapath'
        ],
        [
            'key' => 'house_no',
            'value' => '245/1'
        ],
        [
            'key' => 'post_code',
            'value' => 'Dhaka-1208'
        ],
        [
            'key' => 'default_email_address',
            'value' => 'info@erp.com'
        ],
        [
            'key' => 'default_email_address_2',
            'value' => 'info@erp.com'
        ],
        [
            'key' => 'phone',
            'value' => '+(880) 15151515'
        ],
        [
            'key' => 'phone_2',
            'value' => '+(880) 15151515'
        ],
        [
            'key' => 'phone_3',
            'value' => '+(880) 15151515'
        ],
        [
            'key' => 'address',
            'value' => "Dhaka International University<br>It's rhyming like cloud as well has cluster in it, which means it's a clustered package of ERP businesses."
        ],
        [
            'key' => 'fax',
            'value' => '+(000) 00 000 0000'
        ],
        [
            'key' => 'fax_2',
            'value' => '+(000) 00 000 0000'
        ],
        [
            'key' => 'currency_code',
            'value' => 'BDT'
        ],
        [
            'key' => 'currency_symbol',
            'value' => '৳'
        ],
        [
            'key' => 'site_logo',
            'value' => ''
        ],
        [
            'key' => 'site_favicon',
            'value' => ''
        ],
        [
            'key' => 'site_copyright_text',
            'value' => ''
        ],
        [
            'key' => 'seo_meta_title',
            'value' => ''
        ],
        [
            'key' => 'seo_meta_description',
            'value' => ''
        ],
        [
            'key' => 'social_facebook',
            'value' => ''
        ],
        [
            'key' => 'social_linkedin',
            'value' => ''
        ],
        [
            'key' => 'social_twitter',
            'value' => ''
        ],
        [
            'key' => 'social_instagram',
            'value' => ''
        ],
        [
            'key' => 'google_analytics',
            'value' => ''
        ],
        [
            'key' => 'facebook_pixels',
            'value' => ''
        ],
        [
            'key' => 'stripe_payment_method',
            'value' => ''
        ],
        [
            'key' => 'stripe_key',
            'value' => ''
        ],
        [
            'key' => 'stripe_secret_key',
            'value' => ''
        ],
        [
            'key' => 'paypal_payment_method',
            'value' => ''
        ],
        [
            'key' => 'paypal_client_id',
            'value' => ''
        ],
        [
            'key' => 'paypal_secret_id',
            'value' => ''
        ],
        [
            'key' => 'opening_day',
            'value' => 'MON - SAT DAY'
        ],
        [
            'key' => 'opening_hour',
            'value' => '10.00 - 18.00'
        ],
        [
            'key' => 'closing_day',
            'value' => 'Sunday '
        ],
        [
            'key' => 'closing_hour',
            'value' => 'Closed'
        ],
        [
            'key' => 'google_latitude',
            'value' => ''
        ],
        [
            'key' => 'google_longitude',
            'value' => ''
        ],
        [
            'key' => 'google_map_marker_image',
            'value' => ''
        ],
        [
            'key' => 'google_map_marker_title',
            'value' => ''
        ],
        [
            'key' => 'google_map_zoom',
            'value' => ''
        ],
        [
            'key' => 'google_map_api_key',
            'value' => ''
        ],
        [
            'key' => 'developed_by',
            'value' => 'AMDADUL, RAIHAN, RONEY, SHOMA, MAJEDUL'
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $index => $setting) {
            $result = Setting::create($setting);
            if (!$result) {
                $this->command->info("Inserted at record $index.");
                return;
            }
            $this->command->info('Inserted '.count($this->settings) . ' records');
        }
    }
}
