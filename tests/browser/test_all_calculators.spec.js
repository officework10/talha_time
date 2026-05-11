
import { test, expect } from '@playwright/test';

test('Verify Business Days Calculator', async ({ page }) => {
    // Navigate to the Business Days Calculator page (assuming the route, adjust if needed)
    await page.goto('http://127.0.0.1:8000/business-days-calculator');

    // Test Simple Mode
    await page.click('text=Simple');
    await page.fill('#s_date', '2023-10-01');
    await page.fill('#e_date', '2023-10-10');
    // Ensure "Include End Date" is checked or unchecked based on desired logic (defaulting to unchecked here for simplicity)

    // Select "No Holidays" for simplicity first
    await page.click('label[for="bedtime"]'); // "No" for holidays

    await page.click('button:has-text("Calculate")');

    // Wait for results
    await page.waitForSelector('#result-section');

    // Basic validation - check if "Business Days" text appears in result
    const resultText = await page.innerText('#result-section');
    expect(resultText).toContain('Business Days');

    // Test Advance Mode
    await page.click('text=Advance');
    await page.fill('#add_date', '2023-10-01');
    await page.selectOption('#method', '+');
    await page.fill('#days', '5'); // Add 5 days
    await page.click('label[for="cal_bus"]'); // Select "Calculate Business Days"

    await page.click('button:has-text("Calculate")');
    await page.waitForSelector('#result-section');
    const advanceResult = await page.innerText('#result-section');
    expect(advanceResult).toContain('Business Days');


});

test('Verify Birth Year Calculator', async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/birth-year-calculator');
    // Input data
    await page.fill('#age', '30');
    await page.selectOption('#age_unit', 'years');
    await page.fill('#date', '2023-10-27');
    await page.selectOption('#choose', 'before'); // "born before"

    await page.click('button:has-text("Calculate")');

    await page.waitForSelector('#result-section');
    const result = await page.innerText('#result-section');
    expect(result).toContain('Birth Year');
});

test('Verify Working Days Calculator', async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/working-days-calculator');
    // Simple mode test
    await page.fill('#s_date', '2023-10-01');
    await page.fill('#e_date', '2023-10-10');
    await page.click('button:has-text("Calculate")');

    await page.waitForSelector('#result-section');
    const result = await page.innerText('#result-section');
    expect(result).toContain('Working Days');
});

test('Verify Week Calculator', async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/week-calculator');
    // week between dates
    await page.click('text=Week Between dates');
    await page.fill('#s_date', '2023-10-01');
    await page.fill('#e_date', '2023-10-31');
    await page.click('button:has-text("Calculate")');

    await page.waitForSelector('#result-section');
    const result = await page.innerText('#result-section');
    expect(result).toContain('Weeks');
});

test('Verify Date Calculator', async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/date-calculator');
    // Add days
    await page.fill('#add_date', '2023-10-01');
    await page.selectOption('#method', '+');
    await page.fill('#days', '10');
    await page.click('button:has-text("Calculate")');

    await page.waitForSelector('#result-section');
    const result = await page.innerText('#result-section');
    expect(result).toContain('Date');
});

test('Verify Drive Time Calculator', async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/drive-time-calculator');
    // Speed = 60, Distance = 120
    await page.fill('#speed', '60');
    await page.fill('#distance', '120');
    await page.click('button:has-text("Calculate")');

    await page.waitForSelector('#result-section');
    const result = await page.innerText('#result-section');
    expect(result).toContain('Hours');
});
