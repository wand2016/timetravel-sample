import * as puppeteer from 'puppeteer';
import each from 'jest-each';


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

    each([
        ['19991224', '1999-12-24'],
        ['20191224', '2019-12-24'],
        ['20991224', '2099-12-24'],
    ]).
        test('ログインしてHome画面に遷移し、timetravelパラメータを指定すると指定の日時が表示される', async (param, expectedString) => {
            await page.goto('http://localhost:10080/login', { waitUntil: "domcontentloaded", timeout: 3000 });

            await page.type('input[name=email]', 'sample@example.com');
            await page.type('input[name=password]', 'password');
            await Promise.all([
                page.click('[type=submit]'),
                page.waitForNavigation({ waitUntil: "domcontentloaded", timeout: 3000 })
            ]);

            // then, set timetraveler parameter
            await page.goto(
                `http://localhost:10080/home?timetravel=${param}`,
                { waitUntil: "domcontentloaded", timeout: 3000 }
            );

            expect(await page.content()).toContain(expectedString);
        });

    each([
        ['19991224', '1999-12-24'],
        ['20191224', '2019-12-24'],
        ['20991224', '2099-12-24'],
    ]).
        test('タイムトラベル後の画面でPOSTすると、遷移後の画面で指定の日時が表示される', async (param, expectedString) => {
            await page.goto('http://localhost:10080/login', { waitUntil: "domcontentloaded", timeout: 3000 });

            await page.type('input[name=email]', 'sample@example.com');
            await page.type('input[name=password]', 'password');
            await Promise.all([
                page.click('[type=submit]'),
                page.waitForNavigation({ waitUntil: "domcontentloaded", timeout: 3000 })
            ]);

            // then, set timetraveler parameter
            await page.goto(
                `http://localhost:10080/home?timetravel=${param}`,
                { waitUntil: "domcontentloaded", timeout: 3000 }
            );

            // then, set timetraveler parameter
            await Promise.all([
                page.waitForNavigation({ waitUntil: "domcontentloaded", timeout: 3000 }),
                page.click('input[type="submit"]'),
            ]);

            expect(await page.content()).toContain('posted');
            expect(await page.content()).toContain(expectedString);
        });

});
