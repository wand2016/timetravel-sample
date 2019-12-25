import * as puppeteer from 'puppeteer';

describe('E2E testing', () => {
    let browser: puppeteer.Browser;
    let page: puppeteer.Page;

    beforeEach(async () => {
        browser = await puppeteer.launch({
            slowMo: 30,
            headless: !!process.env.CI,
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox'
            ],
        });
        page = await browser.newPage();
    });

    afterEach(async () => {
        await page.close();
        await browser.close();
    });

    test('ログインしてHome画面に遷移し、timetravelパラメータを指定すると指定の日時が表示される', async () => {
        await page.goto('http://localhost:10080/login', { waitUntil: "domcontentloaded", timeout: 3000 });

        await page.type('input[name=email]', 'sample@example.com');
        await page.type('input[name=password]', 'password');
        await Promise.all([
            page.click('[type=submit]'),
            page.waitForNavigation({ waitUntil: "domcontentloaded", timeout: 3000 })
        ]);

        // then, set timetraveler parameter
        await page.goto(
            'http://localhost:10080/home?timetravel=20191224',
            { waitUntil: "domcontentloaded", timeout: 3000 }
        );

        expect(await page.content()).toContain('2019-12-24');
    });
});
