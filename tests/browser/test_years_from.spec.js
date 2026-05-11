
import { test, expect } from '@playwright/test';

test('Verify Years From Today Calculator', async ({ page }) => {
    // Navigate to the Years From Today Calculator page
    // Assuming URL /years-from-today/ based on list
    await page.goto('http://127.0.0.1:8000/years-from-today/');

    // Test Case 1: 5 Years From Now
    await page.fill('#number', '5');
    // Ensure current date is set (it should default to today)
    // We can also set it explicitly to be sure.
    await page.fill('#current', '2023-01-01');

    await page.click('button:has-text("Calculate")');
    await page.waitForSelector('#result-section');

    const resultText = await page.innerText('#result-section');
    // 5 years from 2023 is 2028.
    expect(resultText).toContain('2028');

    // Test Case 2: 5 Years Ago (Negative input logic handled by controller/repository, but UI might restrict)
    // The method handles negative numbers, but UI might be "Years Ago" separate calculator.
    // The function `years_from` handles both if number is negative.
    // Let's check "Years Ago Calculator" too if needed, but let's stick to positive for "From Today".

});
