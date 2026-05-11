
import { test, expect } from '@playwright/test';

test('Verify Hours Calculator', async ({ page }) => {
    // Navigate to the Hours Calculator page (assuming URL is /hours-calculator/)
    // If exact URL is unknown, I'll try to find it from the home page list or guess.
    // Based on previous file listing, `HoursCalculator.php` exists.
    // Let's assume the route is /hours-calculator/
    await page.goto('http://127.0.0.1:8000/hours-calculator/');

    // Test Case 1: Simple 9 to 5
    // Start Time: 09:00 AM
    await page.fill('input[name="hh"]', '9');
    await page.fill('input[name="mm"]', '00');
    // method default AM

    // End Time: 05:00 PM
    await page.fill('input[name="hhe"]', '5');
    await page.fill('input[name="mme"]', '00');
    // method default PM (or we might need to select it)
    await page.selectOption('select[name="methode"]', 'PM'); // Assuming it's a select or radio. 
    // If it's radio, we need to click.
    // Let's check logic: $method = $request->input('method');

    // Let's rely on basic inputs first. If UI is complex, we might fail and need to adjust.
    // But since I can't see the UI code for HoursCalculator right now, I'll assume standard inputs.

    await page.click('button:has-text("Calculate")');

    await page.waitForSelector('#result-section');
    const resultText = await page.innerText('#result-section');

    // 9 to 5 is 8 hours.
    expect(resultText).toContain('8:00');
    expect(resultText).toContain('8'); // Decimal hours

    // Test Case 2: Overnight 10 PM to 2 AM
    await page.fill('input[name="hh"]', '10');
    await page.selectOption('select[name="method"]', 'PM');

    await page.fill('input[name="hhe"]', '2');
    await page.selectOption('select[name="methode"]', 'AM');

    await page.click('button:has-text("Calculate")');
    await page.waitForSelector('#result-section');
    const resultText2 = await page.innerText('#result-section');

    // 10pm to 2am is 4 hours.
    expect(resultText2).toContain('4:00');
});
