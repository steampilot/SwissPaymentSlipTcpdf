SwissPaymentSlipTcpdf - Swiss Payment Slips with TCPDF
======================================================

[![Travis Build Status](https://travis-ci.org/ravage84/SwissPaymentSlipTcpdf.png?branch=master)](https://travis-ci.org/ravage84/SwissPaymentSlipTcpdf)
[![Scrutinizer CI Build Status](https://scrutinizer-ci.com/g/ravage84/SwissPaymentSlipTcpdf/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ravage84/SwissPaymentSlipTcpdf/build-status/master)
[![Scrutinizer CI Code Coverage](https://scrutinizer-ci.com/g/ravage84/SwissPaymentSlipTcpdf/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ravage84/SwissPaymentSlipTcpdf/?branch=master)
[![Scrutinizer CI Code Quality](https://scrutinizer-ci.com/g/ravage84/SwissPaymentSlipTcpdf/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ravage84/SwissPaymentSlipTcpdf/?branch=master)
[![Total Downloads](https://poser.pugx.org/swiss-payment-slip/swiss-payment-slip-tcpdf/d/total.png)](https://packagist.org/packages/swiss-payment-slip/swiss-payment-slip-tcpdf)
[![Latest Stable Version](https://poser.pugx.org/swiss-payment-slip/swiss-payment-slip-tcpdf/v/stable.png)](https://packagist.org/packages/swiss-payment-slip/swiss-payment-slip-tcpdf)

Do you need to create Swiss payment slips (called ESR) as PDF files in a project of yours?
Then you found the right place, read on...

By the way if you don't like [TCPDF](http://www.tcpdf.org/) or don't want to use it for whatever reason,
checkout [SwissPaymentSlipFpdf](https://github.com/ravage84/SwissPaymentSlipFpdf/).

How to use
----------

Just install the the package (see [Installation](https://github.com/ravage84/SwissPaymentSlipTcpdf#installation))
and check out the contained examples in the
[examples folder](https://github.com/ravage84/SwissPaymentSlipTcpdf/tree/master/examples).

How to extend for custom needs
------------------------------

[TODO]
If you need help, ask for help.

Installation
------------

### Requirements

- PHP 5.3.x+
- [SwissPaymentSlip](https://github.com/ravage84/SwissPaymentSlip/) (automatically installed by Composer)
- [SwissPaymentSlipPdf](https://github.com/ravage84/SwissPaymentSlipPdf/) (automatically installed by Composer)
- A [TCPDF compatible](http://www.tcpdf.org/fonts.php) [OCR-B](http://en.wikipedia.org/wiki/OCR-B) font for the code line, see issue #1

### Composer

Just [install composer](http://getcomposer.org/doc/00-intro.md#system-requirements) on your system, if not already there.
Then create a [composer.json](http://getcomposer.org/doc/04-schema.md) file in your project's root folder
and copy the following into it:

```JSON
{
    "require": {
        "swiss-payment-slip/swiss-payment-slip-tcpdf": "*"
    }
}
```

After that you can install the package using

    $ php composer.phar install

in your project's root folder.

Background Story
----------------

In february 2013 I was looking for a solution to create swiss payment slips for a project I had to do at my work place.
After a short Google search I came across Manuel Reinhard's
[blog post](http://sprain.ch/blog/downloads/class-esr-besr-einzahlungsschein-php/) about the class he made for that.
On his [Github project's page](https://github.com/sprain/class.Einzahlungsschein.php) I found
[Peter Siska's](https://github.com/peschee) [pull request](https://github.com/sprain/class.Einzahlungsschein.php/pull/5).
His pull request introduced PSR-0 compatibility and he created a composer package on [Packagist](http://packagist.org/).
So I tried Peter's version and it suited my basic needs.

BUT since the customer I was working for used custom designed payment slips I couldn't use Manuel's/Peter's script
since it wasn't flexible enough.
Now I had to decide whether I want to "just" change the script to fit my needs or to rewrite it and
make it as flexible as possible.
I decided myself for the latter.

TODOs
-----

- Improve code documentation
- Add more examples/improve existing ones
- Write tests
- Release the stable release of the API

Submitting bugs and feature requests
------------------------------------

Bugs and feature request are tracked on [GitHub](https://github.com/ravage84/SwissPaymentSlipTcpdf/issues).

Author
------

This project was created by [Marc Würth](https://github.com/ravage84).
See Background Story for more details.

License
-------

SwissPaymentSlipTcpdf is licensed under the MIT License.
See the [LICENSE](https://github.com/ravage84/SwissPaymentSlipTcpdf/blob/master/LICENSE) file for details.
