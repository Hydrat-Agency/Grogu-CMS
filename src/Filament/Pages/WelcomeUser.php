<?php

namespace Hydrat\GroguCMS\Filament\Pages;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\PasswordResetResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Livewire\Attributes\Locked;

class WelcomeUser extends SimplePage
{
    use InteractsWithFormActions;
    use WithRateLimiting;

    #[Locked]
    public User $user;

    #[Locked]
    public ?string $email = null;

    public ?string $password = '';

    public ?string $passwordConfirmation = '';

    protected static string $view = 'grogu-cms::filament.pages.welcome-user';

    protected static ?string $slug = 'welcome';

    public function mount(User $user): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->user = $user;

        $this->form->fill([
            'email' => $this->user->email,
        ]);
    }

    public function resetPassword(): ?PasswordResetResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/password-reset/reset-password.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/password-reset/reset-password.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/password-reset/reset-password.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        $this->user->password = Hash::make($data['password']);
        $this->user->remember_token = Str::random(60);
        $this->user->welcome_valid_until = null;
        $this->user->save();

        event(new PasswordReset($this->user));

        auth()->login($this->user);

        Notification::make()
            ->title(__('Password set successfully!'))
            ->success()
            ->send();

        return app(PasswordResetResponse::class);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/password-reset/reset-password.form.email.label'))
            ->disabled()
            ->autofocus();
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/password-reset/reset-password.form.password.label'))
            ->password()
            ->required()
            ->rule(PasswordRule::default())
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::pages/auth/password-reset/reset-password.form.password.validation_attribute'));
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::pages/auth/password-reset/reset-password.form.password_confirmation.label'))
            ->password()
            ->required()
            ->dehydrated(false);
    }

    public function getTitle(): string|Htmlable
    {
        return __('Welcome, :name', ['name' => $this->user->name]);
    }

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    protected function getFormActions(): array
    {
        return [
            $this->getResetPasswordFormAction(),
        ];
    }

    public function getResetPasswordFormAction(): Action
    {
        return Action::make('resetPassword')
            ->label(__('Set password'))
            ->submit('resetPassword');
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    // public function mount(): void
    // {
    //     abort_unless(auth()->user()->canManageSettings(), 403);
    // }
}
