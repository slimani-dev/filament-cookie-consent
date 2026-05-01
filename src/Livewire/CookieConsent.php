<?php

namespace Slimani\CookieConsent\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;
use Slimani\CookieConsent\CookieConsentPlugin;

class CookieConsent extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public function mount(): void
    {
        $consent = Cookie::get('cookie_consent');
        $plugin = $this->getPlugin();

        if ($consent === 'accepted') {
            return;
        }

        if (! ($plugin?->areCookiesRequired() ?? false) && $consent === 'rejected') {
            return;
        }

        if ($consent !== 'accepted') {
            $this->mountAction('consent');
        }
    }

    public function consentAction(): Action
    {
        $plugin = $this->getPlugin();

        return Action::make('consent')
            ->modalHeading($plugin?->getModalHeading())
            ->modalDescription($plugin?->getModalDescription())
            ->modalIcon($plugin?->getModalIcon())
            ->modalIconColor($plugin?->getModalIconColor())
            ->schema($plugin?->getSchema() ?? [])
            ->modalSubmitActionLabel($plugin?->getModalSubmitActionLabel())
            ->modalCancelAction(false)
            ->modalFooterActionsAlignment($plugin?->getModalFooterActionsAlignment())
            ->modalAutofocus($plugin?->shouldAutofocusModal() ?? false)
            ->modalCloseButton($plugin?->shouldShowModalCloseButton() ?? false)
            ->closeModalByClickingAway($plugin?->shouldCloseModalByClickingAway() ?? false)
            ->closeModalByEscaping($plugin?->shouldCloseModalByEscaping() ?? false)
            ->modalWidth($plugin?->getModalWidth() ?? '5xl')
            ->action(function (): void {
                $this->acceptConsent();
            })
            ->extraModalFooterActions([
                Action::make('reject')
                    ->label($plugin?->getModalCancelActionLabel() ?? 'Refuse')
                    ->color('gray')
                    ->cancelParentActions()
                    ->action(function (): void {
                        $this->rejectConsent();
                    }),
            ]);
    }

    public function acceptConsent(): void
    {
        $plugin = $this->getPlugin();

        Cookie::queue('cookie_consent', 'accepted', 60 * 24 * 365);

        if ($plugin?->shouldShowAcceptedNotification() ?? true) {
            Notification::make()
                ->title('Consent Accepted')
                ->body('Thank you for accepting our data collection policy.')
                ->success()
                ->send();
        }
    }

    public function rejectConsent(): void
    {
        $plugin = $this->getPlugin();

        if (! ($plugin?->areCookiesRequired() ?? false)) {
            Cookie::queue('cookie_consent', 'rejected', 60 * 24);
        }

        if ($plugin?->shouldShowRejectedNotification() ?? true) {
            Notification::make()
                ->title('Consent Rejected')
                ->body('You can accept the data collection policy any time from the modal.')
                ->warning()
                ->send();
        }
    }

    public function getPlugin(): ?CookieConsentPlugin
    {
        $panel = Filament::getCurrentPanel();

        if (! $panel || ! $panel->hasPlugin('cookie-consent')) {
            return null;
        }

        /** @var CookieConsentPlugin $plugin */
        $plugin = $panel->getPlugin('cookie-consent');

        return $plugin;
    }

    public function render(): View
    {
        /** @var view-string $view */
        $view = 'filament-cookie-consent::livewire.component';

        return view($view);
    }
}
