<?php

namespace App\Http\Livewire\Admin\Invoice;

use App\Models\Invoice;
use App\Notifications\InvoicePaymentReminderNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class NotifyTenantPaymentComponent extends Component
{
    use LivewireAlert;

    public $invoiceId;

    public $invoice;
    public $tenant_name, $balance, $month_year;

    protected $listeners = ['notifyTenantPayment', 'resetDetails'];

    public function render(): Factory|View|Application
    {
        return view('livewire.admin.invoice.notify-tenant-payment-component');
    }

    public function notifyTenantPayment($id)
    {
        $this->invoiceId = $id;

        $this->invoice = Invoice::with('tenant')
            ->findOrFail($this->invoiceId);

        $this->tenant_name = $this->invoice->tenant->name;
        $this->balance = $this->invoice->balance_due;
        $this->month_year = $this->invoice->created_at->format('F Y');


        $this->emit('showTenantPaymentModal');

    }

    public function resetDetails()
    {
        $this->reset(['invoiceId', 'invoice', 'tenant_name', 'balance', 'month_year']);

    }


    public function submit()
    {
        $data = [
            'tenant_name' => $this->tenant_name,
            'balance' => $this->balance,
            'month_year' => $this->month_year,
            'invoice_url' => route('tenant.invoices.show', $this->invoiceId)
        ];

        $this->invoice->tenant->notify(new InvoicePaymentReminderNotification($data));

        $this->alert('success', __('Notification sent successfully to ') . $this->tenant_name);

        $this->emit('notificationSent');

    }
}
