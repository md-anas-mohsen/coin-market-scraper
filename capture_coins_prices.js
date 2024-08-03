// fetch-page.js
// const puppeteer = require("puppeteer");
import * as puppeteer from "puppeteer";

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.goto("https://coinmarketcap.com/", {
        waitUntil: "networkidle2",
    });

    // Function to perform autoscrolling
    await page.evaluate(async () => {
        await new Promise((resolve, reject) => {
            const distance = 100;
            let totalHeight = 0;
            const timer = setInterval(() => {
                const scrollHeight = document.body.scrollHeight;
                window.scrollBy(0, distance);
                totalHeight += distance;

                if (totalHeight >= scrollHeight) {
                    clearInterval(timer);
                    resolve();
                }
            }, 100);
        });
    });

    const content = await page.content();
    console.log(content);

    await browser.close();
})();
