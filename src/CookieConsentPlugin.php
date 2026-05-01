<?php

namespace Slimani\CookieConsent;

use BackedEnum;
use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Slimani\CookieConsent\Http\Middleware\CheckCookieConsent;

class CookieConsentPlugin implements Plugin
{
    use EvaluatesClosures;

    protected bool|Closure $enabled = true;

    /**
     * @var array<int, \Filament\Schemas\Components\Component> | Closure | null
     */
    protected array|Closure|null $schema = null;

    protected string|Htmlable|Closure|null $modalHeading = 'Cookie Policy';

    protected string|Htmlable|Closure|null $modalDescription = null;

    protected string|BackedEnum|Htmlable|Closure|null $modalIcon = null;

    /**
     * @var string | array<string> | Closure | null
     */
    protected string|array|Closure|null $modalIconColor = null;

    protected string|Closure|null $modalSubmitActionLabel = 'I Accept';

    protected string|Closure|null $modalCancelActionLabel = 'Refuse';

    protected bool|Closure $modalCloseButton = false;

    protected bool|Closure $modalAutofocus = false;

    protected bool|Closure $closeModalByClickingAway = false;

    protected bool|Closure $closeModalByEscaping = false;

    protected string|Closure|null $modalWidth = '5xl';

    protected Alignment|string|Closure|null $modalFooterActionsAlignment = null;

    protected bool|Closure $showAcceptedNotification = true;

    protected bool|Closure $showRejectedNotification = true;

    protected bool|Closure $cookiesRequired = false;

    public function getId(): string
    {
        return 'cookie-consent';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function enable(bool|Closure $condition = true): static
    {
        $this->enabled = $condition;

        return $this;
    }

    public function getEnabled(): bool
    {
        return (bool) $this->evaluate($this->enabled);
    }

    /**
     * @param  array<int, \Filament\Schemas\Components\Component> | Closure | null  $schema
     */
    public function schema(array|Closure|null $schema): static
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public function getSchema(): array
    {
        $schema = $this->evaluate($this->schema);

        if (is_array($schema) && $schema !== []) {
            return $schema;
        }

        return $this->getDefaultSchema();
    }

    public function modalHeading(string|Htmlable|Closure|null $heading): static
    {
        $this->modalHeading = $heading;

        return $this;
    }

    public function getModalHeading(): string|Htmlable|null
    {
        return $this->evaluate($this->modalHeading);
    }

    public function modalDescription(string|Htmlable|Closure|null $description): static
    {
        $this->modalDescription = $description;

        return $this;
    }

    public function getModalDescription(): string|Htmlable|null
    {
        return $this->evaluate($this->modalDescription);
    }

    public function modalIcon(string|BackedEnum|Htmlable|Closure|null $icon): static
    {
        $this->modalIcon = $icon;

        return $this;
    }

    public function getModalIcon(): string|BackedEnum|Htmlable|null
    {
        return $this->evaluate($this->modalIcon);
    }

    /**
     * @param  string | array<string> | Closure | null  $color
     */
    public function modalIconColor(string|array|Closure|null $color): static
    {
        $this->modalIconColor = $color;

        return $this;
    }

    /**
     * @return string | array<string> | null
     */
    public function getModalIconColor(): string|array|null
    {
        return $this->evaluate($this->modalIconColor);
    }

    public function modalSubmitActionLabel(string|Closure|null $label): static
    {
        $this->modalSubmitActionLabel = $label;

        return $this;
    }

    public function getModalSubmitActionLabel(): ?string
    {
        return $this->evaluate($this->modalSubmitActionLabel);
    }

    public function modalCancelActionLabel(string|Closure|null $label): static
    {
        $this->modalCancelActionLabel = $label;

        return $this;
    }

    public function getModalCancelActionLabel(): ?string
    {
        return $this->evaluate($this->modalCancelActionLabel);
    }

    public function modalCloseButton(bool|Closure $condition = true): static
    {
        $this->modalCloseButton = $condition;

        return $this;
    }

    public function shouldShowModalCloseButton(): bool
    {
        return (bool) $this->evaluate($this->modalCloseButton);
    }

    public function modalAutofocus(bool|Closure $condition = true): static
    {
        $this->modalAutofocus = $condition;

        return $this;
    }

    public function shouldAutofocusModal(): bool
    {
        return (bool) $this->evaluate($this->modalAutofocus);
    }

    public function closeModalByClickingAway(bool|Closure $condition = true): static
    {
        $this->closeModalByClickingAway = $condition;

        return $this;
    }

    public function shouldCloseModalByClickingAway(): bool
    {
        return (bool) $this->evaluate($this->closeModalByClickingAway);
    }

    public function closeModalByEscaping(bool|Closure $condition = true): static
    {
        $this->closeModalByEscaping = $condition;

        return $this;
    }

    public function shouldCloseModalByEscaping(): bool
    {
        return (bool) $this->evaluate($this->closeModalByEscaping);
    }

    public function modalWidth(string|Closure|null $width): static
    {
        $this->modalWidth = $width;

        return $this;
    }

    public function getModalWidth(): ?string
    {
        return $this->evaluate($this->modalWidth);
    }

    public function modalFooterActionsAlignment(Alignment|string|Closure|null $alignment): static
    {
        $this->modalFooterActionsAlignment = $alignment;

        return $this;
    }

    public function getModalFooterActionsAlignment(): Alignment|string|null
    {
        return $this->evaluate($this->modalFooterActionsAlignment);
    }

    public function showAcceptedNotification(bool|Closure $condition = true): static
    {
        $this->showAcceptedNotification = $condition;

        return $this;
    }

    public function shouldShowAcceptedNotification(): bool
    {
        return (bool) $this->evaluate($this->showAcceptedNotification);
    }

    public function showRejectedNotification(bool|Closure $condition = true): static
    {
        $this->showRejectedNotification = $condition;

        return $this;
    }

    public function shouldShowRejectedNotification(): bool
    {
        return (bool) $this->evaluate($this->showRejectedNotification);
    }

    public function cookiesRequired(bool|Closure $condition = true): static
    {
        $this->cookiesRequired = $condition;

        return $this;
    }

    public function areCookiesRequired(): bool
    {
        return (bool) $this->evaluate($this->cookiesRequired);
    }

    public function register(Panel $panel): void
    {
        if (! $this->getEnabled()) {
            return;
        }

        $panel
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => Blade::render('@livewire(\'cookie-consent\')')
            )
            ->middleware([
                CheckCookieConsent::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    protected function getDefaultSchema(): array
    {
        return [
            Section::make()
                ->schema([
                    Text::make(new HtmlString('We use cookies to improve your experience and keep the portal working properly.'))
                        ->size('sm'),
                ]),
        ];
    }
}
