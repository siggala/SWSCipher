# SWSCipher
PHP-class for data encryption/decryption.

### Quick Start
Basic encryption. Default salt value is set to 32 and base64 encoding is enabled.
```php
require 'SWSCipher.php';

$secured_data = SWSCipher::encrypt( 'This is secret message.', 'secretkey' ); 

// This will output: HBcnCBYNCgYLHBcBEU4dBxgLBg4HFgdOCAocCwYOFgYRDggGCxcHEV8GABYKAA4WFxEEBBEXSw===
```

Basic decryption. Default salt value is set to 32 and base64 encoding is enabled.
```php
require 'SWSCipher.php';

$data = SWSCipher::decrypt( 'HBcnCBYNCgYLHBcBEU4dBxgLBg4HFgdOCAocCwYOFgYRDggGCxcHEV8GABYKAA4WFxEEBBEXSw===', 'secretkey' ); 

// This will output: This is secret message.
```
### Examples
This example will add 50% more random chars to output string in relation of the secret message length.

If you want to use certain amount of extra chars just use integer value instead on percents.
```php
SWSCipher::encrypt( 'This is secret message.', 'secretkey', '50%', true );

// This will output: JwANAQ0XCgFOHRhOChoYFgYXGREXAAERXwAGAAoAAAQEF0s==
```
Basic encryption without base64 encoding.
```php
SWSCipher::encrypt( 'This is secret message.', 'secretkey', 0, false );

// This will output: ' NN _ K
```

### Donation
If this project helped you in any way, you can give me a small donation :)

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EP597V6WZ3838)

### License
MIT
