
import { test, expect } from '@playwright/test';

test('Verify Hours From Now Calculator', async ({ page }) => {
    // Navigate to the Hours From Now Calculator page
    await page.goto('http://127.0.0.1:8000/hours-from-now/');

    // Switch to "Input Time" (Static) mode if needed, but default is Live. 
    // Let's toggle to Static to control inputs.
    await page.click('label[for="stat"]');

    // Set Time: 12:00:00
    await page.fill('#hours', '12');
    await page.fill('#minutes', '00');
    await page.fill('#seconds', '00');

    // Add 2 hours 30 minutes
    await page.fill('#hrs', '2');
    await page.fill('#min', '30');

    await page.click('button:has-text("Calculate")');

    // Wait for results
    await page.waitForSelector('#result-section');

    // Validate Result
    // 12:00 + 2:30 = 14:30. 
    // Format might be 14:30:00 or 02:30:00 PM depending on default.
    // The error was "Call to a member function format() on string", so just appearing without error is a pass.

    const resultText = await page.innerText('#result-section');
    // Check for 14:30 or 02:30
    const containsTime = resultText.includes('14:30') || resultText.includes('02:30');
    expect(containsTime).toBeTruthy();

    // Also check that the error message is NOT present
    const errorText = await page.locator('text=Call to a member function format() on string').count();
    expect(errorText).toBe(0);

});
