<?php

use Filament\Panel;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Support\Enums\Alignment;
use Slimani\CookieConsent\CookieConsentPlugin;

it('can be registered as a plugin', function () {
    $panel = Panel::make('test')
        ->plugin(CookieConsentPlugin::make());

    expect($panel->getPlugin('cookie-consent'))
        ->toBeInstanceOf(CookieConsentPlugin::class);
});

it('uses a minimal default schema and allows customization', function () {
    $plugin = CookieConsentPlugin::make();

    expect($plugin->getSchema())
        ->toHaveCount(1)
        ->and($plugin->getSchema()[0])
        ->toBeInstanceOf(Section::class);
    
    expect($plugin->shouldShowAcceptedNotification())->toBeTrue()
        ->and($plugin->shouldShowRejectedNotification())->toBeTrue()
        ->and($plugin->areCookiesRequired())->toBeFalse();

    $plugin = CookieConsentPlugin::make()
        ->modalHeading('Custom heading')
        ->modalDescription('Custom description')
        ->modalIcon('heroicon-m-shield-check')
        ->modalIconColor('warning')
        ->modalSubmitActionLabel('Accept')
        ->modalCancelActionLabel('Decline')
        ->modalFooterActionsAlignment(Alignment::Center)
        ->showAcceptedNotification(false)
        ->showRejectedNotification(false)
        ->cookiesRequired(true)
        ->schema([
            Section::make('Custom section')
                ->schema([
                    Text::make('Custom content'),
                ]),
        ]);

    expect($plugin->getModalHeading())->toBe('Custom heading')
        ->and($plugin->getModalDescription())->toBe('Custom description')
        ->and($plugin->getModalIcon())->toBe('heroicon-m-shield-check')
        ->and($plugin->getModalIconColor())->toBe('warning')
        ->and($plugin->getModalSubmitActionLabel())->toBe('Accept')
        ->and($plugin->getModalCancelActionLabel())->toBe('Decline')
        ->and($plugin->getModalFooterActionsAlignment())->toBe(Alignment::Center)
        ->and($plugin->shouldShowAcceptedNotification())->toBeFalse()
        ->and($plugin->shouldShowRejectedNotification())->toBeFalse()
        ->and($plugin->areCookiesRequired())->toBeTrue()
        ->and($plugin->getSchema())
        ->toHaveCount(1);
});
