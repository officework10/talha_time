
import { test, expect } from '@playwright/test';

test('Verify Years Ago Calculator Subtraction', async ({ page }) => {
    // Navigate to the Years Ago Calculator page
    // Assuming URL /years-ago-calculator/ based on list
    await page.goto('http://127.0.0.1:8000/years-ago-calculator/');

    // Test Case 1: 5 Years Ago
    await page.fill('#number', '5');
    // Ensure current date is set (it should default to today)
    // We can also set it explicitly to be sure.
    await page.fill('#current', '2023-01-01');

    await page.click('button:has-text("Calculate")');
    await page.waitForSelector('#result-section');

    const resultText = await page.innerText('#result-section');
    // 5 years ago from 2023 is 2018.
    expect(resultText).toContain('2018');

    // Check that it's NOT adding years (2028)
    expect(resultText).not.toContain('2028');

});
