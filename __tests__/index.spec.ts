import * as puppeteer from 'puppeteer';

describe('E2E testing', () => {
    let browser: puppeteer.Browser;
    let page: puppeteer.Page;

    beforeEach(async () => {
        browser = await puppeteer.launch({
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

    test('empty', async () => {
        await page.goto('https://example.com');
        expect(1).toBe(1);
    });
});
