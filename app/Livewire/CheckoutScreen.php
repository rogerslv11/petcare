<?php

namespace App\Livewire;

use App\Actions\CompleteCheckoutAction;
use App\Models\Appointment;
use Livewire\Component;

class CheckoutScreen extends Component
{
    public ?Appointment $appt = null;

    public string $method = 'pix';

    public function select(int $id)
    {
        $this->appt = Appointment::with(['pet', 'customer', 'service'])->findOrFail($id);
    }

    public function finish(CompleteCheckoutAction $action)
    {
        $action->execute($this->appt, $this->method);
        $this->dispatch('notify', message: 'Pagamento concluído 💳');

        return redirect()->route('kanban.index');
    }

    public function render()
    {
        $ready = Appointment::with(['pet', 'customer', 'service'])->where('status', 'ready')->get();

        return view('livewire.checkout-screen', compact('ready'));
    }
}
