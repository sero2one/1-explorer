<?php

declare(strict_types=1);

use App\Services\Settings;
use Illuminate\Support\Facades\Session;

it('should have all settings with defaults', function () {
    expect(Settings::all())->toBe([
        'currency'   => 'usd',
        'priceChart' => true,
        'feeChart'   => true,
        'darkTheme'  => true,
    ]);
});

it('should have all settings with values from a session', function () {
    $settings = [
        'currency'   => 'chf',
        'priceChart' => true,
        'feeChart'   => true,
        'darkTheme'  => true,
    ];

    Session::shouldReceive('has')
        ->once()
        ->with('settings')
        ->andReturn(true);

    Session::shouldReceive('get')
        ->once()
        ->with('settings')
        ->andReturn(json_encode($settings));

    expect(Settings::all())->toBe($settings);
});

it('should have a currency setting', function () {
    expect(Settings::currency())->toBe('usd');
});

it('should have a price chart setting', function () {
    expect(Settings::priceChart())->toBeTrue();
});

it('should have a fee chart setting', function () {
    expect(Settings::feeChart())->toBeTrue();
});

it('should have a dark theme setting', function () {
    expect(Settings::darkTheme())->toBeTrue();
});

it('should determine the name of the theme', function () {
    Session::put('settings', json_encode(['darkTheme' => true]));

    expect(Settings::theme())->toBe('dark');

    Session::put('settings', json_encode(['darkTheme' => false]));

    expect(Settings::theme())->toBe('light');

    Session::put('settings', json_encode(['darkTheme' => true]));

    expect(Settings::theme())->toBe('dark');
});

it('should determine if visitor uses price chart', function () {
    Session::put('settings', json_encode(['priceChart' => true]));

    expect(Settings::usesPriceChart())->toBeTrue();

    Session::put('settings', json_encode(['priceChart' => false]));

    expect(Settings::usesPriceChart())->toBeFalse();

    Session::put('settings', json_encode(['priceChart' => true]));

    expect(Settings::usesPriceChart())->toBeTrue();
});

it('should determine if visitor uses fee chart', function () {
    Session::put('settings', json_encode(['feeChart' => true]));

    expect(Settings::usesFeeChart())->toBeTrue();

    Session::put('settings', json_encode(['feeChart' => false]));

    expect(Settings::usesFeeChart())->toBeFalse();

    Session::put('settings', json_encode(['feeChart' => true]));

    expect(Settings::usesFeeChart())->toBeTrue();
});

it('should determine if visitor uses dark theme', function () {
    Session::put('settings', json_encode(['darkTheme' => true]));

    expect(Settings::usesDarkTheme())->toBeTrue();

    Session::put('settings', json_encode(['darkTheme' => false]));

    expect(Settings::usesDarkTheme())->toBeFalse();

    Session::put('settings', json_encode(['darkTheme' => true]));

    expect(Settings::usesDarkTheme())->toBeTrue();
});
