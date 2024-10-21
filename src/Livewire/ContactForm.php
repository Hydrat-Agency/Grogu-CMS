<?php

namespace Hydrat\GroguCMS\Livewire;

use GrantHolle\Altcha\Rules\ValidAltcha;
use Hydrat\GroguCMS\Actions\Form as Actions;
use Hydrat\GroguCMS\Models\Form;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ContactForm extends Component
{
    #[Locked]
    public Form $form;

    public array $data = [];

    public string $altcha;

    public string $onSuccessMessage = '';

    public function submit()
    {
        $validationRules = Actions\GetFormValidationRules::run($this->form, prefixKey: 'data.');
        $validationAttributes = Actions\GetFormValidationAttributes::run($this->form, prefixKey: 'data.');

        $validationRules['altcha'] = ['required', new ValidAltcha];

        if (filled($validationRules)) {
            $this->validate(
                rules: $validationRules,
                attributes: $validationAttributes,
            );
        }

        $this->dispatch('form-validated');

        Actions\SubmitFormEntry::run($this->form, $this->data);

        $this->data = [];
        $this->onSuccessMessage = $this->form->submit_success_message;

        $this->dispatch('form-submitted');
    }

    public function render()
    {
        return view('grogu-cms::livewire.contact-form');
    }
}
