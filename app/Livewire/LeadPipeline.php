<?php

namespace App\Livewire;

use App\Models\Lead;
use App\Support\TenantContext;
use Livewire\Component;

class LeadPipeline extends Component
{
    public array $stages = ['new_lead' => 'Novo Lead', 'contacted' => 'Contato', 'interested' => 'Interessado', 'scheduled' => 'Agendamento', 'first_visit' => '1º Atendimento', 'customer' => 'Cliente'];

    public function move(int $id, string $to)
    {
        Lead::findOrFail($id)->update(['status' => $to]);
    }

    public function render()
    {
        $cards = [];
        foreach ($this->stages as $k => $v) {
            $cards[$k] = Lead::where('business_id', TenantContext::businessId())->where('status', $k)->get();
        }

return view('livewire.lead-pipeline', compact('cards'));
    }
}
