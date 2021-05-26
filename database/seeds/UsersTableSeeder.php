<?php


use App\Model\User\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'group_name' => 'permission',
                'permissions' => [
                    'permission.view',
                    'permission.create',
                    'permission.edit',
                    'permission.delete'
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    'role.view',
                    'role.create',
                    'role.edit',
                    'role.delete'
                ]
            ],
            [
                'group_name' => 'admin',
                'permissions' => [
                    'admin.view',
                    'admin.create',
                    'admin.edit',
                    'admin.delete'
                ]
            ],
            [
                'group_name' => 'settings',
                'permissions' => [
                    'settings.view',
                    'settings.create',
                    'settings.edit',
                    'settings.delete'
                ]
            ],
            [
                'group_name' => 'lookup',
                'permissions' => [
                    'lookup.view',
                    'lookup.create',
                    'lookup.edit',
                    'lookup.delete'
                ]
            ],
            [
                'group_name' => 'category',
                'permissions' => [
                    'category.view',
                    'category.create',
                    'category.edit',
                    'category.delete'
                ]
            ],
            [
                'group_name' => 'brand',
                'permissions' => [
                    'brand.view',
                    'brand.create',
                    'brand.edit',
                    'brand.delete'
                ]
            ],
            [
                'group_name' => 'unit',
                'permissions' => [
                    'unit.view',
                    'unit.create',
                    'unit.edit',
                    'unit.delete'
                ]
            ],
            [
                'group_name' => 'product',
                'permissions' => [
                    'product.view',
                    'product.create',
                    'product.edit',
                    'product.delete'
                ]
            ],
            [
                'group_name' => 'sell_price',
                'permissions' => [
                    'sell_price.view',
                    'sell_price.create',
                    'sell_price.edit',
                    'sell_price.delete'
                ]
            ],
            [
                'group_name' => 'store',
                'permissions' => [
                    'store.view',
                    'store.create',
                    'store.edit',
                    'store.delete'
                ]
            ],
            [
                'group_name' => 'store_transfer',
                'permissions' => [
                    'store_transfer.view',
                    'store_transfer.create',
                    'store_transfer.edit',
                    'store_transfer.delete',
                    'store_transfer.report',
                    'store_transfer.receive'
                ]
            ],
            [
                'group_name' => 'purchase_return',
                'permissions' => [
                    'purchase_return.view',
                    'purchase_return.create',
                    'purchase_return.edit',
                    'purchase_return.delete',
                    'purchase_return.report',
                    'purchase_return.product_wise_report'
                ]
            ],
            [
                'group_name' => 'inventory',
                'permissions' => [
                    'inventory.view',
                    'inventory.create',
                    'inventory.edit',
                    'inventory.delete',
                    'inventory.report',
                    'inventory.value_report',
                    'inventory.ledger_report'
                ]
            ],
            [
                'group_name' => 'supplier',
                'permissions' => [
                    'supplier.view',
                    'supplier.create',
                    'supplier.edit',
                    'supplier.delete',
                ]
            ],
            [
                'group_name' => 'purchase',
                'permissions' => [
                    'purchase.view',
                    'purchase.create',
                    'purchase.edit',
                    'purchase.delete',
                    'purchase.report',
                    'purchase.product_wise_report',
                ]
            ],
            [
                'group_name' => 'chart_of_accounts',
                'permissions' => [
                    'chart_of_accounts.view',
                    'chart_of_accounts.create',
                    'chart_of_accounts.edit',
                    'chart_of_accounts.delete',
                ]
            ],
            [
                'group_name' => 'money_receipt',
                'permissions' => [
                    'money_receipt.view',
                    'money_receipt.create',
                    'money_receipt.edit',
                    'money_receipt.delete',
                    'money_receipt.collection_report',
                ]
            ],
            [
                'group_name' => 'supplier_payment',
                'permissions' => [
                    'supplier_payment.view',
                    'supplier_payment.create',
                    'supplier_payment.edit',
                    'supplier_payment.delete',
                    'supplier_payment.payment_report',
                    'supplier_payment.supplier_due_report',
                ]
            ],
            [
                'group_name' => 'journal',
                'permissions' => [
                    'journal.view',
                    'journal.create',
                    'journal.edit',
                    'journal.delete',
                    'journal.expense_report',
                    'journal.profit_loss_report',
                    'journal.profit_loss_report_by_date',
                    'journal.liquid_money_report',
                ]
            ],
            [
                'group_name' => 'department',
                'permissions' => [
                    'department.view',
                    'department.create',
                    'department.edit',
                    'department.delete',
                ]
            ],
            [
                'group_name' => 'designation',
                'permissions' => [
                    'designation.view',
                    'designation.create',
                    'designation.edit',
                    'designation.delete',
                ]
            ],
            [
                'group_name' => 'employee',
                'permissions' => [
                    'employee.view',
                    'employee.create',
                    'employee.edit',
                    'employee.delete',
                    'employee.report',
                    'employee.joining_report',
                ]
            ],
            [
                'group_name' => 'holiday',
                'permissions' => [
                    'holiday.view',
                    'holiday.create',
                    'holiday.edit',
                    'holiday.delete',
                ]
            ],
            [
                'group_name' => 'leave',
                'permissions' => [
                    'leave.view',
                    'leave.create',
                    'leave.edit',
                    'leave.delete',
                    'leave.approve',
                ]
            ],
            [
                'group_name' => 'attendance',
                'permissions' => [
                    'attendance.view',
                    'attendance.create',
                    'attendance.edit',
                    'attendance.delete',
                    'attendance.report',
                ]
            ],
            [
                'group_name' => 'salary_setup',
                'permissions' => [
                    'salary_setup.view',
                    'salary_setup.create',
                    'salary_setup.edit',
                    'salary_setup.delete',
                    'salary_setup.salary_sheet',
                ]
            ],
            [
                'group_name' => 'customer',
                'permissions' => [
                    'customer.view',
                    'customer.create',
                    'customer.edit',
                    'customer.delete',
                    'customer.due_report',
                ]
            ],
            [
                'group_name' => 'sales_order',
                'permissions' => [
                    'sales_order.view',
                    'sales_order.create',
                    'sales_order.edit',
                    'sales_order.delete',
                    'sales_order.invoice_create',
                    'sales_order.report',
                ]
            ],
            [
                'group_name' => 'invoice',
                'permissions' => [
                    'invoice.view',
                    'invoice.create',
                    'invoice.edit',
                    'invoice.delete',
                    'invoice.report',
                    'invoice.customer_sales_report',
                ]
            ],
            [
                'group_name' => 'invoice_return',
                'permissions' => [
                    'invoice_return.view',
                    'invoice_return.create',
                    'invoice_return.edit',
                    'invoice_return.delete',
                    'invoice_return.report',
                    'invoice_return.customer_return_report',
                ]
            ],
        ];

        for ($i=0;$i<count($permissions);$i++)
        {
            $permission_group = $permissions[$i]['group_name'];
            for ($j=0;$j<count($permissions[$i]['permissions']);$j++)
            {
                Permission::create(['name' => $permissions[$i]['permissions'][$j],'group' => $permission_group]);
            }
        }

        $role = Role::create(['name' => 'developer-admin']);
        $role->givePermissionTo(Permission::all());

        $user = User::create([
            'name'      =>  'Developer Admin',
            'email'     =>  'admin@admin.com',
            'password'  =>  bcrypt('password'),
        ]);

        $user->assignRole('developer-admin');
    }
}
