# Crypto Display WordPress Plugin
![alt text](https://static.coingecko.com/s/coingecko-branding-guide-8447de673439420efa0ab1e0e03a1f8b0137270fbc9c0b7c086ee284bd417fa1.png)

## What is this?
This is a slightly more specialized and modernized version of an old project you can check out [here](https://github.com/haa-gg/Coin-Market-API-Example)

## What does it do?
Display the top 10 crypto curriencies (by market cap) of the day via shortcode after installing this plugin!

## How do I use it?
1. Download the repo
2. Upload the zip file via plugin upload in WordPress
3. Activate the plugin in the dashboard
4. Go make an API demo account on [CoinGecko](https://www.coingecko.com/en/api)
5. Paste your shiny new API key into the settings page
6. Now you can paste this shortcode in a text block `[crypto_prices]` and see the top 10 crypto prices!

## Tech wise, what's neat about it?
Uses the CoinGecko API to pull in a list of digital currencies and display them via shortcode.

CoinGecko does require an API key which is why I made the handy settings page where you can add it.

I also love that this plugin is really is just a single file just a tad over 100 lines so you can look it over and mess with it as you please!

### Troubleshooting tip(s)
If it works right out of the box but breaks shortly after installation, you probably didn't add the API key in the settings or there's a typo in it.
For better or worse CoinGecko's API will work once or twice with no key required.