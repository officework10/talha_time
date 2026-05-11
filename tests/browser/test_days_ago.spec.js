
import { test, expect } from '@playwright/test';

test('Verify Days Ago Calculator', async ({ page }) => {
    // Navigate to the Days Ago Calculator page
    // Assuming URL /days-ago-calculator/ based on pattern
    await page.goto('http://127.0.0.1:8000/days-ago-calculator/');

    // Test Case 1: 10 Days Ago
    await page.fill('#number', '10');
    // Ensure current date is set to something fixed for testing
    await page.fill('#current', '2023-01-11');

    await page.click('button:has-text("Calculate")');
    await page.waitForSelector('#result-section');

    const resultText = await page.innerText('#result-section');
    // 10 days ago from Jan 11, 2023 is Jan 1, 2023.
    expect(resultText).toContain('January 1, 2023');

    // Check Date Name
    expect(resultText).toContain('Sunday');
});
