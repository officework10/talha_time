
import { test, expect } from '@playwright/test';

test('Verify Weeks Ago Calculator', async ({ page }) => {
    // Navigate to the Weeks Ago Calculator page
    // Assuming URL /weeks-ago-calculator/ based on pattern
    await page.goto('http://127.0.0.1:8000/weeks-ago-calculator/');

    // Test Case 1: 4 Weeks Ago
    await page.fill('#number', '4');
    // Ensure current date is set to something fixed for testing
    await page.fill('#current', '2023-02-01');

    await page.click('button:has-text("Calculate")');
    await page.waitForSelector('#result-section');

    const resultText = await page.innerText('#result-section');
    // 4 weeks ago from Feb 1, 2023 is Jan 4, 2023.
    expect(resultText).toContain('January 4, 2023');

    // Check Date Name
    expect(resultText).toContain('Wednesday');
});
