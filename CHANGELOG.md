# Change Log
All notable changes to this project are documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/ravage84/SwissPaymentSlipTcpdf/compare/0.5.0...master)
### Added

### Changed

### Fixed

## [0.5.0](https://github.com/ravage84/SwissPaymentSlipTcpdf/releases/tag/0.5.0) - 2013-07-04
### Added
- The README

### Changed
- Added DocBlocks everywhere, some other minor clean up 
- Completed SwissInpaymentSlipTest
- Improved the composer.json
- Renamed namespace Gridonic\ESR to more general, library style SwissPaymentSlip\SwissPaymentSlip
- Removed SwissPaymentSlipData and SwissPaymentSlip classes and its associated files (moved them to a separate repo)
- Removed SwissPaymentSlipPdf class and and added it as dependency to composer.json
- Removed SwissPaymentSlipFPdf class and its associated files, updated composer.json. What's left is only TCPDF related
- Renamed the repo to SwissPaymentSlipTcpdf

## [0.4.0](https://github.com/ravage84/SwissPaymentSlipTcpdf/releases/tag/0.4.0) - 2013-03-05
### Changed
- Changed parameter order (height, width --> width, height) in setSlipSize and
  its protected setters in SwissInpaymentSlip

## [0.3.0](https://github.com/ravage84/SwissPaymentSlipTcpdf/releases/tag/0.3.0) - 2013-03-05
### Changed
- Changed parameter order (height, width --> width, height) in various setters in SwissInpaymentSlip

## [0.2.0](https://github.com/ravage84/SwissPaymentSlipTcpdf/releases/tag/0.2.0) - 2013-03-05
### Changed
- Major refactoring (including):
  Renamed SwissInpaymentSlip to SwissInpaymentSlipData
  Renamed SwissInpaymentSlipPdf to SwissInpaymentSlip
  Removed FPDF specific code from SwissInpaymentSlipPdf into new SwissInpaymentSlipFpdf

## [0.0.1](https://github.com/ravage84/SwissPaymentSlipTcpdf/releases/tag/0.0.1) - 2013-02-23
### Added
- Initial commit based on [peschee/class.Einzahlungsschein.php](https://github.com/peschee/class.Einzahlungsschein.php)
