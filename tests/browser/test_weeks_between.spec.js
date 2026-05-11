
import { test, expect } from '@playwright/test';

test('Verify Weeks Between Calculator', async ({ page }) => {
    // Navigate to the Weeks Between Calculator page
    // Assuming URL /weeks-between-dates/ or similar based on naming convention
    // The user didn't specify URL, but usually it matches the calculator name.
    // Let's guess /weeks-between-dates-calculator/ or check routes later if it fails.
    // Based on previous ones: /weeks-ago-calculator/ -> /weeks-between-dates-calculator/ ?

    // START_URL: http://127.0.0.1:8000/weeks-between-dates-calculator/
    await page.goto('http://127.0.0.1:8000/weeks-between-dates-calculator/');

    // Select Date 1: Jan 1, 2023
    // Inputs likely month, day, year separately based on repo code
    await page.selectOption('select[name="month"]', '1');
    await page.selectOption('select[name="day"]', '1');
    await page.fill('input[name="year"]', '2023');

    // Select Date 2: Jan 18, 2023 (17 days later -> 2 weeks 3 days)
    await page.selectOption('select[name="month1"]', '1');
    await page.selectOption('select[name="day1"]', '18');
    await page.fill('input[name="year1"]', '2023');

    await page.click('button:has-text("Calculate")');
    await page.waitForSelector('#result-section');

    const resultText = await page.innerText('#result-section');

    // Expected: 2 Weeks, 3 Days
    expect(resultText).toContain('2');
    expect(resultText).toContain('3');

    // Verify Carbon object formatting in view (likely shows Date 1 and Date 2 strings)
    // The view likely formats it like "Sunday, January 1, 2023"
    expect(resultText).toContain('January 1, 2023');
    expect(resultText).toContain('January 18, 2023');
});
