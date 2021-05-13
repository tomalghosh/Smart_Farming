module.exports = async function (query) {

    query = `${query} crop fertilizer`;

    const puppeteer = require('puppeteer');

    const browser = await puppeteer.launch({
        //headless: false,
        //slowMo: 100,
        //devtools: false
    });

    const page = await browser.newPage();

    await page.goto(`https://www.google.com/search?q=${query}&tbm=shop`);

    const result = await page.evaluate(function () {
        var host = location.protocol + location.host;
        return Array.from(document.querySelectorAll(".KZmu8e")).reduce(function (acc, node) {
            var name = node.querySelector(".sh-np__product-title").textContent;
            var price = node.querySelector(".T14wmb").textContent;
            var img = node.querySelector(".sh-img__image img").getAttribute("src");
            var link = host + node.querySelector(".sh-np__click-target").getAttribute("href");
            var source = node.querySelector(".E5ocAb").textContent;

            acc.push({
                name,
                price,
                img,
                link,
                source
            })



            return acc;
        }, []);


    })

    await page.close();
    await browser.close();

    return result;

}