
import { test, expect } from '@playwright/test';

test('Verify Playback Speed Calculator', async ({ page }) => {
    // Navigate to the Playback Speed Calculator page
    // Assuming URL /playback-speed-calculator/ based on pattern
    await page.goto('http://127.0.0.1:8000/playback-speed-calculator/');

    // Test Case: 1 Hour at 1.5x Speed
    await page.fill('#hours', '1');
    await page.fill('#minutes', '0');
    await page.fill('#seconds', '0');

    // Select Speed 1.5x
    // Assuming speed selection is via buttons or dropdown. 
    // If it's buttons:
    await page.click('button:has-text("1.5x")').catch(() => {
        // Fallback for select if buttons fail, or try input[name="speed"]
        return page.fill('input[name="speed"]', '1.5');
    });

    await page.click('button:has-text("Calculate")');
    await page.waitForSelector('#result-section');

    const resultText = await page.innerText('#result-section');

    // Total time: 1 hour = 60 mins. 
    // At 1.5x: 60 / 1.5 = 40 mins listening time.
    // Saved: 60 - 40 = 20 mins saved.

    expect(resultText).toContain('0h 40m 0s'); // Listening Time
    expect(resultText).toContain('0h 20m 0s'); // Time Saved

    // Check message
    expect(resultText).toContain('At 1.5x speed, your audiobook will take 0h 40m 0s');
});
