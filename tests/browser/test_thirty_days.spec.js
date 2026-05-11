
import { test, expect } from '@playwright/test';

test('Verify Thirty Days From Today Calculator', async ({ page }) => {
    // Navigate to the Thirty Days From Today Calculator page
    // Assuming URL /thirty-days-from-today-calculator/ 
    await page.goto('http://127.0.0.1:8000/thirty-days-from-today-calculator/');

    // Test Case: 60 Days
    await page.fill('input[name="days"]', '60'); // Assuming name="days" based on repo code

    await page.click('button:has-text("Calculate")');
    await page.waitForSelector('#result-section');

    // Check for Time Difference section which uses data from the new implementation
    // The view likely displays "Days", "Weeks", "Months" if available.
    // Based on user screenshot, it shows "60 Days", "8.6 Weeks", "2.0 Months".

    const resultText = await page.innerText('#result-section');
    expect(resultText).toContain('60'); // Days
    expect(resultText).toContain('8.6'); // Weeks
    expect(resultText).toContain('2.0'); // Months

    // Check date progression timeline (Chart) existence
    // If it's a chart, maybe check for canvas or a specific container
    // User screenshot says "Date Progression Timeline" header
    expect(resultText).toContain('Date Progression Timeline');
});
