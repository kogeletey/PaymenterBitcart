# BitCart plugin for Paymenter

**WARNING**: Use at your own risk not tested in production

## Integration Requirements

This version requires the following:

- Installed Paymenter in your server - [install guide](https://paymenter.org/docs/getting-started/installation/)
- Running Bitcart instance: [deployment guide](https://docs.bitcart.ai/deployment)

## Installing the Plugin

1. Download the latest release from the [git repository](https://git.0ut0f.space/siren/PaymenterBitcart)
2. Extract the archive you've downloaded in the first step into the following path `/var/www/paymenter/app/Extensions/Gateways/BitCart`
3. Set permissions for all directories, by default:

```sh
chown -R www-data:www-data /var/www/paymenter/*
```

4. Click the Bitcart to install and configure Bitcart

## Plugin Configuration

After you have enabled the Bitcart plugin, the configuration steps are:

1. Enter your admin panel URL (for example, https://admin.bitcart.ai) without slashes. If deployed via configurator, you should use https://bitcart.yourdomain.com/admin
2. Enter your merchants API URL (for example, https://api.bitcart.ai) without slashes. If deployed via configurator, you should use https://bitcart.yourdomain.com/api
3. Enter your store ID (click on id field in Bitcart's admin panel to copy id)

## Support 

Feel free to create issues. 
In addition we are waiting for your improvements and corrections at [activitypub](https://mitra.0ut0f.space/@kglt)

## License

All work is licensed under [ISC License](https://www.isc.org/licenses/)
