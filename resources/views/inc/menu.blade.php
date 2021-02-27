<!-- Horizontal navigation-->
<div
    class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-shadow menu-border"
    role="navigation" data-menu="menu-wrapper">
    <!-- Horizontal menu content-->
    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <!-- include ../../../includes/mixins-->
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}"><i class="ft-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="ft-settings"></i><span>Software Configuration</span>
                </a>
                <ul class="dropdown-menu">
                    <li data-menu="">
                        <a class="dropdown-item" href="{{ route('admin.settings') }}" data-toggle="dropdown">Settings
                            <submenu class="name"></submenu>
                        </a>
                    </li>
                    <li data-menu="">
                        <a class="dropdown-item" href="{{ url('/config/lookups') }}" data-toggle="dropdown">Lookups
                            <submenu class="name"></submenu>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="ft-settings"></i><span>User Management</span>
                </a>
                <ul class="dropdown-menu">
                    <li data-menu="">
                        <a class="dropdown-item" href="{{ url('/users/permissions') }}" data-toggle="dropdown">Permissions
                            <submenu class="name"></submenu>
                        </a>
                    </li>
                    <li data-menu="">
                        <a class="dropdown-item" href="{{ url('/users/roles') }}" data-toggle="dropdown">Roles
                            <submenu class="name"></submenu>
                        </a>
                    </li>
                    <li data-menu="">
                        <a class="dropdown-item" href="{{ url('/users/admins') }}" data-toggle="dropdown">Admins
                            <submenu class="name"></submenu>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="ft-trash"></i><span>Store & Inventory</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Configuration
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('storeInventory.categories.index') }}"
                                   data-toggle="dropdown">Category
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/store-inventory/brand') }}"
                                   data-toggle="dropdown">Brand
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/store-inventory/units') }}"
                                   data-toggle="dropdown">Unit
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/store-inventory/products') }}" data-toggle="dropdown">Products
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/store-inventory/sellprices') }}" data-toggle="dropdown">Sell Price
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/store-inventory/stores') }}" data-toggle="dropdown">Stores
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Purchase Return
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/store-inventory/purchase-return/') }}" data-toggle="dropdown">Return Manage
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/store-inventory/purchase-return/create') }}" data-toggle="dropdown">Return Create
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Inventory
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('storeInventory.inventory.index') }}" data-toggle="dropdown">Stock Ledger
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Reports
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/commercial/purchase/create') }}" data-toggle="dropdown">Stock Report
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/commercial/purchase/create') }}" data-toggle="dropdown">Stock Value Report
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/commercial/purchase/create') }}" data-toggle="dropdown">Stock Ledger Report
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="ft-bell"></i><span>Commercial</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Configuration
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/commercial/suppliers') }}" data-toggle="dropdown">Supplier
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Purchase
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/commercial/purchase/create') }}" data-toggle="dropdown">Purchase Create
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/commercial/purchase') }}" data-toggle="dropdown">Purchase Manage
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Reports
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ url('/commercial/purchase/create') }}" data-toggle="dropdown">Purchase Report
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>


            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="ft-hash"></i><span>Accounting</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Configuration
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('accounting.chartofaccounts.index') }}" data-toggle="dropdown">Chart Of Accounts
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">MoneyReceipt
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('accounting.mr.index') }}" data-toggle="dropdown">MoneyReceipt Manage
                                    <submenu class="name"></submenu>
                                </a>
                            </li>

                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('accounting.mr.create') }}" data-toggle="dropdown">MoneyReceipt Create
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Supplier Payment
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('accounting.payment.create') }}" data-toggle="dropdown">Create Payment
                                    <submenu class="name"></submenu>
                                </a>
                            </li>

                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('accounting.payment.index') }}" data-toggle="dropdown">Manage Payment
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Reports
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('accounting.mr.index') }}" data-toggle="dropdown">Collection Reports
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('accounting.mr.create') }}" data-toggle="dropdown">Payment Reports
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('accounting.mr.create') }}" data-toggle="dropdown">Due Reports
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('accounting.mr.create') }}" data-toggle="dropdown">Expense Reports
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="ft-users"></i><span>HR</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Configuration
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('hr.employees.index') }}" data-toggle="dropdown">Salary Setup
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('hr.holidaysetup.index') }}" data-toggle="dropdown">Holidays Setup
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('hr.departments.index') }}" data-toggle="dropdown">Departments
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('hr.designations.index') }}" data-toggle="dropdown">Designations
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('hr.employees.index') }}" data-toggle="dropdown">Employees
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Reports
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('hr.employees.index') }}" data-toggle="dropdown">Daily Attendance Report
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('hr.holidaysetup.index') }}" data-toggle="dropdown">Employees Report
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('hr.departments.index') }}" data-toggle="dropdown">Joining Report
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('hr.designations.index') }}" data-toggle="dropdown">Salary Sheet
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="ft-circle"></i><span>CRM</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Configuration
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('crm.customers.index') }}"
                                   data-toggle="dropdown">Customer
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Sales Order
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('crm.sales.order.create') }}"
                                   data-toggle="dropdown">Order Create
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('crm.sales.order.index') }}"
                                   data-toggle="dropdown">Order Manage
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Invoice
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('crm.invoice.create') }}"
                                   data-toggle="dropdown">Invoice Create
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('crm.invoice.index') }}"
                                   data-toggle="dropdown">Invoice Manage
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('crm.invoiceReturn.create') }}"
                                   data-toggle="dropdown">Create  Return
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('crm.invoiceReturn.index') }}"
                                   data-toggle="dropdown">Return Manage
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown">Reports
                            <submenu class="name"></submenu>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('crm.reports.order-report') }}"
                                   data-toggle="dropdown">Sales Order Reports
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('crm.reports.invoice-report') }}"
                                   data-toggle="dropdown">Invoice Report
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('crm.reports.invoice-return-report') }}"
                                   data-toggle="dropdown">Invoice Return Report
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('crm.reports.customer-sales-report') }}"
                                   data-toggle="dropdown">Customer Sales Report
                                    <submenu class="name"></submenu>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /horizontal menu content-->
</div>
<!-- Horizontal navigation-->
