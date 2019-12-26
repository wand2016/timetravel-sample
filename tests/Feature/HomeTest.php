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
     */
    public function home_GET_未ログイン状態でアクセスするとログイン画面にリダイレクトされる()
    {
        $response = $this->get('/home');

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     * @dataProvider dataProvider_現在時刻と表示
     */
    public function home_GET_現在時刻が表示される(
        Carbon $now,
        string $messageExpected
    ) {
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
    public function home_GET_timetravelパラメータが指定されているとその日時が表示される(
        Carbon $now,
        string $timetravel,
        string $messageExpected
    ) {
        // ----------------------------------------
        // 1. setup
        // ----------------------------------------
        $this->be(User::first());
        Carbon::setTestNow($now);

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


    /**
     * @test
     */
    public function home_POST_未ログイン状態でアクセスするとログイン画面にリダイレクトされる()
    {
        $response = $this->post('/home');

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     * @dataProvider dataProvider_現在時刻と表示
     */
    public function home_POST_現在時刻が表示される(
        Carbon $now,
        string $messageExpected
    ) {
        // ----------------------------------------
        // 1. setup
        // ----------------------------------------
        $this->be(User::first());
        $this->followingRedirects();
        Carbon::setTestNow($now);

        // ----------------------------------------
        // 2. action
        // ----------------------------------------
        $response = $this->post('/home');

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
    public function home_POST_timetravelパラメータが指定されているとその日時が表示される(
        Carbon $now,
        string $timetravel,
        string $messageExpected
    ) {
        // ----------------------------------------
        // 1. setup
        // ----------------------------------------
        $this->be(User::first());
        $this->followingRedirects();
        Carbon::setTestNow($now);

        // ----------------------------------------
        // 2. action
        // ----------------------------------------
        $response = $this->call('post', '/home', [
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
            Carbon::create(2019, 12, 31, 23, 59, 59),
            '2019-12-31 23:59:59',
        ];
    }

    public function dataProvider_timetravelパラメータと表示(): iterable
    {
        yield '昨日' => [
            Carbon::create(2020, 1, 1, 12, 34, 56),
            '2019-12-31',
            '2019-12-31 00:00:00',
        ];
        yield '1年前' => [
            Carbon::create(2020, 1, 1, 12, 34, 56),
            '2019-01-01',
            '2019-01-01 00:00:00',
        ];
        yield '明日' => [
            Carbon::create(2020, 1, 1, 12, 34, 56),
            '2020-01-02',
            '2020-01-02 00:00:00',
        ];
        yield '来週' => [
            Carbon::create(2020, 1, 1, 12, 34, 56),
            '2020-01-08',
            '2020-01-08 00:00:00',
        ];
        yield '来年' => [
            Carbon::create(2020, 1, 1, 12, 34, 56),
            '2021-01-01',
            '2021-01-01 00:00:00',
        ];
    }
}
