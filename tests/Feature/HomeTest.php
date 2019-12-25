<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @test
     * @dataProvider dataProvider_現在時刻と表示
     */
    public function home画面で現在時刻が表示される(
        Carbon $now,
        string $messageExpected
    )
    {
        // ----------------------------------------
        // 1. setup
        // ----------------------------------------
        $this->be(User::first());

        Carbon::setTestNow($now);

        // ----------------------------------------
        // 2. action
        // ----------------------------------------
        $response = $this->get('/home');

        // ----------------------------------------
        // 3. assertion
        // -----------------------------------------
        $response->assertSeeText(
            $messageExpected
        );
    }

    /**
     * @test
     * @dataProvider dataProvider_timetravelパラメータと表示
     */
    public function timetravelパラメータが指定されているとその日時が表示される(
        string $timetravel,
        string $messageExpected
    )
    {
        // ----------------------------------------
        // 1. setup
        // ----------------------------------------
        $this->be(User::first());

        // ----------------------------------------
        // 2. action
        // ----------------------------------------
        $response = $this->call('get', '/home', [
            'timetravel' => $timetravel,
        ]);

        // ----------------------------------------
        // 3. assertion
        // -----------------------------------------
        $response->assertSeeText(
            $messageExpected
        );
    }

    // ----------------------------------------
    // dataProviders
    // ----------------------------------------

    public function dataProvider_現在時刻と表示(): iterable
    {
        yield [
            Carbon::create(2019,12,31,23,59,59),
            '2019-12-31 23:59:59',
        ];
    }

    public function dataProvider_timetravelパラメータと表示(): iterable
    {
        yield [
            '2019-12-31',
            '2019-12-31 00:00:00',
        ];
    }
}
